<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Throwable;

class MeetingDateController extends Controller
{
    private const SESSION_KEY = 'meeting_date.form';

    private const TABLE = 'HM_meeting_date';

    public function index(Request $request): View
    {
        if (in_array($request->query('mode'), ['MODE_RESET', 'CANCEL'], true)) {
            $request->session()->forget(self::SESSION_KEY);
        }

        $form = (array) $request->session()->get(self::SESSION_KEY, []);

        if ($request->filled('graduation')) {
            $form['contactDetail'] = (string) $request->query('graduation');
            $request->session()->put(self::SESSION_KEY, $form);
        }

        return view('meeting-date.index', [
            'form' => $form,
        ]);
    }

    public function confirm(Request $request): View|RedirectResponse
    {
        foreach (['expected_delivery_date', 'visit_date_1', 'visit_date_2'] as $field) {
            $value = (string) $request->input($field, '');

            if (preg_match('/^\d{4}\/\d{2}\/\d{2}$/', $value) === 1) {
                $request->merge([$field => str_replace('/', '-', $value)]);
            }
        }

        $data = $request->validate([
            'cont_type' => ['required', 'in:ご訪問,ZOOM等リモートミーティング'],
            'Company_Name' => ['required', 'string', 'max:30'],
            'person_name' => ['required', 'string', 'max:100'],
            'department' => ['nullable', 'string', 'max:100'],
            'zip' => ['nullable', 'string', 'max:8', 'regex:/^[0-9-]+$/'],
            'prefc' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'address_street' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'regex:/^[0-9]{10,11}$/'],
            'email' => ['required', 'email', 'max:60'],
            'email_confirm' => ['required', 'same:email'],
            'expected_product' => ['nullable', 'string', 'max:60'],
            'qty' => ['nullable', 'string', 'max:20'],
            'expected_price' => ['nullable', 'string', 'max:20'],
            'expected_delivery_date' => ['nullable', 'date_format:Y-m-d'],
            'visit_date_1' => ['nullable', 'date_format:Y-m-d'],
            'visit_time_1' => ['nullable', 'in:10,11,12,13,14,15,16,17'],
            'visit_date_2' => ['nullable', 'date_format:Y-m-d'],
            'visit_time_2' => ['nullable', 'in:10,11,12,13,14,15,16,17'],
            'contactDetail' => ['nullable', 'string', 'max:10000'],
        ], [
            'required' => 'この項目は必須です。',
            'same' => 'メールアドレスが一致しません。',
            'email.email' => 'メールアドレスを正しく入力してください。',
            'phone_number.regex' => '電話番号は10〜11桁の数字で入力してください。',
            'zip.regex' => '郵便番号は数字またはハイフンで入力してください。',
            'date_format' => '日付はYYYY-MM-DD形式で入力してください。',
        ]);

        $request->session()->put(self::SESSION_KEY, $data);

        return view('meeting-date.confirm', [
            'form' => $data,
        ]);
    }

    public function complete(Request $request): View|RedirectResponse
    {
        $form = $request->session()->get(self::SESSION_KEY);

        if (! is_array($form) || blank($form['email'] ?? null)) {
            return redirect()->route('meeting-date.index');
        }

        $submissionId = null;

        if (Schema::hasTable(self::TABLE)) {
            try {
                $submissionId = $this->storeSubmission($form);
            } catch (Throwable $exception) {
                report($exception);
            }
        }

        $mailError = null;

        try {
            $body = $this->mailBody($form);
            $from = (string) env('HM_MEETING_FROM_ADDRESS', env('HM_CONTACT_FROM_ADDRESS', 'contact@hotmobily.jp'));
            $bcc = collect(explode(',', (string) env('HM_MEETING_BCC', env('HM_CONTACT_BCC', 'contact@hotmobily.jp'))))
                ->map(static fn (string $address): string => trim($address))
                ->filter(static fn (string $address): bool => filter_var($address, FILTER_VALIDATE_EMAIL) !== false)
                ->unique()
                ->values()
                ->all();

            Mail::send([], [], function ($message) use ($form, $body, $from, $bcc): void {
                $message
                    ->to((string) $form['email'])
                    ->from($from, 'HOTMOBILY ウェブサイト')
                    ->subject('【ご連絡】営業担当呼び出し依頼を受付ました！')
                    ->html($body);

                foreach ($bcc as $address) {
                    $message->bcc($address, 'HOTMOBILY ウェブサイト');
                }
            });

            if ($submissionId !== null) {
                try {
                    DB::table(self::TABLE)
                        ->where('id', $submissionId)
                        ->update([
                            'mail_sent_at' => now(),
                            'date_modify' => now(),
                        ]);
                } catch (Throwable $updateException) {
                    report($updateException);
                }
            }
        } catch (Throwable $exception) {
            report($exception);
            $mailError = 'メール送信は完了しませんでしたが、ご依頼内容は受け付けました。';
        }

        if ($mailError !== null && $submissionId !== null) {
            try {
                DB::table(self::TABLE)
                    ->where('id', $submissionId)
                    ->update([
                        'mail_error' => $mailError,
                        'date_modify' => now(),
                    ]);
            } catch (Throwable $updateException) {
                report($updateException);
            }
        }

        $request->session()->forget(self::SESSION_KEY);

        return view('meeting-date.complete', [
            'mailError' => $mailError,
        ]);
    }

    /** @param array<string, mixed> $form */
    private function storeSubmission(array $form): string
    {
        $baseId = 'MD_'.now()->format('YmdHi');
        $submissionId = $baseId;
        $suffix = 1;

        while (DB::table(self::TABLE)->where('id', $submissionId)->exists()) {
            $submissionId = $baseId.str_pad((string) $suffix, 2, '0', STR_PAD_LEFT);
            $suffix++;
        }

        $stringValue = static fn (string $key): ?string => filled($form[$key] ?? null)
            ? trim((string) $form[$key])
            : null;

        DB::table(self::TABLE)->insert([
            'id' => $submissionId,
            'date_create' => now(),
            'date_modify' => now(),
            'status' => 'New',
            'cont_type' => $stringValue('cont_type'),
            'company_name' => $stringValue('Company_Name'),
            'person_name' => $stringValue('person_name'),
            'department' => $stringValue('department'),
            'zip' => $stringValue('zip'),
            'prefc' => $stringValue('prefc'),
            'address' => $stringValue('address'),
            'address_street' => $stringValue('address_street'),
            'phone_number' => $stringValue('phone_number'),
            'email' => $stringValue('email'),
            'email_confirm' => $stringValue('email_confirm'),
            'expected_product' => $stringValue('expected_product'),
            'qty' => $stringValue('qty'),
            'expected_price' => $stringValue('expected_price'),
            'expected_delivery_date' => $stringValue('expected_delivery_date'),
            'visit_date_1' => $stringValue('visit_date_1'),
            'visit_time_1' => $stringValue('visit_time_1'),
            'visit_date_2' => $stringValue('visit_date_2'),
            'visit_time_2' => $stringValue('visit_time_2'),
            'contact_detail' => $stringValue('contactDetail'),
        ]);

        return $submissionId;
    }

    /** @param array<string, mixed> $form */
    private function mailBody(array $form): string
    {
        $value = static fn (mixed $item): string => nl2br(e((string) $item));
        $row = static fn (string $label, mixed $item): string => '<tr><td style="padding:8px 10px;width:180px;font-weight:bold;background:#e5e5e5;border-bottom:1px solid #fff;">'.e($label).'</td><td style="padding:8px 10px;width:400px;background:#f3f3f3;border-bottom:1px solid #fff;">'.$value($item).'</td></tr>';

        $body = '<div style="width:550px;font-size:12px;line-height:150%;font-family:Arial,sans-serif;color:#281600;">';
        $body .= '<strong>'.e((string) ($form['Company_Name'] ?? '')).'<br>'.e((string) ($form['person_name'] ?? '')).' 様</strong><br><br>';
        $body .= 'この度は、営業担当呼び出しのご依頼ありがとうございます。ご入力頂きました内容をお送り致します。<br>念のためご確認をお願い致します。<br><br>';
        $body .= '<table cellpadding="0" cellspacing="0" style="width:550px;border-collapse:collapse;background:#f3f3f3;">';
        $body .= $row('お打ち合わせ方法', $form['cont_type'] ?? '');
        $body .= $row('会社名', $form['Company_Name'] ?? '');
        $body .= $row('ご担当者様', $form['person_name'] ?? '');
        $body .= $row('ご担当者部署名', $form['department'] ?? '');

        if (($form['cont_type'] ?? '') === 'ご訪問') {
            $body .= $row('郵便番号', $form['zip'] ?? '');
            $body .= $row('都道府県', $form['prefc'] ?? '');
            $body .= $row('以降の住所', $form['address'] ?? '');
            $body .= $row('番地・建物名・部屋番号', $form['address_street'] ?? '');
        }

        $body .= $row('ご連絡先電話番号', $form['phone_number'] ?? '');
        $body .= $row('E-mail', $form['email'] ?? '');
        $body .= $row('ご希望製品', $form['expected_product'] ?? '');
        $body .= $row('予定数量', ($form['qty'] ?? '').' 個');
        $body .= $row('ご希望単価', ($form['expected_price'] ?? '').' 円');
        $body .= $row('製品ご利用予定日（納期）', $this->displayDate($form['expected_delivery_date'] ?? ''));
        $body .= $row('ご希望日時（第一希望）', $this->meetingDate($form, 1));
        $body .= $row('ご希望日時（第二希望）', $this->meetingDate($form, 2));
        $body .= $row('お問い合わせ・ご連絡', $form['contactDetail'] ?? '');
        $body .= '</table></div>';

        return $body;
    }

    /** @param array<string, mixed> $form */
    private function meetingDate(array $form, int $number): string
    {
        return trim($this->displayDate($form['visit_date_'.$number] ?? '').' '.($form['visit_time_'.$number] ?? '').'時');
    }

    private function displayDate(mixed $date): string
    {
        $date = (string) $date;

        return preg_replace('/^(\d{4})-(\d{2})-(\d{2})$/', '$1/$2/$3', $date) ?: $date;
    }
}
