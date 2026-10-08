<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class ContactController extends Controller
{
    private const SESSION_KEY = 'contact.form';

    public function index(Request $request): View
    {
        if ($request->query('mode') === 'MODE_RESET') {
            $request->session()->forget(self::SESSION_KEY);
        }

        $form = (array) $request->session()->get(self::SESSION_KEY, []);
        $type = (string) $request->query('sndKBN', $form['sndKBN'] ?? '');

        if (! in_array($type, ['0', '1'], true)) {
            $type = '';
        }

        if ($type === '') {
            unset($form['sndKBN']);
        } else {
            $form['sndKBN'] = $type;
        }

        if (filled($request->query('item'))) {
            $form['ItemType'] = (string) $request->query('item');
            $form['sndKBN'] = '1';
        }

        if (filled($request->query('sample'))) {
            $form['sample_pic'] = str_replace('::', '/', (string) $request->query('sample'));
            $form['contactDetail'] = trim((string) ($form['contactDetail'] ?? '')
                . 'この事例と同じ種類の製品を作りたい。');
        }

        if (filled($request->query('graduation'))) {
            $form['contactDetail'] = (string) $request->query('graduation');
        }

        return view('contact.index', [
            'form' => $form,
            'sampleProductGroups' => $this->sampleProductCatalog(),
        ]);
    }

    public function confirm(Request $request): View|RedirectResponse
    {
        $data = $request->validate([
            'sndKBN' => ['required', 'in:0,1'],
            'ItemType' => ['nullable', 'string', 'max:255', 'required_if:sndKBN,1'],
            'email' => ['required', 'email', 'max:250'],
            'Name_S' => ['required', 'string', 'max:100'],
            'Name_S_K' => ['required', 'string', 'max:100'],
            'tel' => ['required', 'string', 'max:30', 'regex:/^[0-9]+$/'],
            'cstKBN' => ['required', 'in:Corp,Personal'],
            'Corp_Name' => ['nullable', 'string', 'max:100', 'required_if:cstKBN,Corp'],
            'Corp_Name_K' => ['nullable', 'string', 'max:100', 'required_if:cstKBN,Corp'],
            'dev' => ['nullable', 'string', 'max:100'],
            'contactDetail' => ['nullable', 'string', 'max:10000'],
            'zip' => ['nullable', 'string', 'max:8', 'regex:/^[0-9-]+$/', 'required_if:sndKBN,1'],
            'prefc' => ['nullable', 'string', 'max:100', 'required_if:sndKBN,1'],
            'address' => ['nullable', 'string', 'max:255', 'required_if:sndKBN,1'],
            'address_street' => ['nullable', 'string', 'max:255', 'required_if:sndKBN,1'],
            'sample_pic' => ['nullable', 'string', 'max:500'],
            'file' => ['nullable', 'array', 'max:3'],
            'file.*' => [
                'file',
                'max:10240',
                'extensions:ai,pdf,doc,xls,jpeg,jpg,psd,zip',
            ],
        ], [
            'required_if' => 'この項目は必須です。',
            'tel.regex' => '電話番号は数字のみで入力してください。',
            'zip.regex' => '郵便番号は数字で入力してください。',
        ]);

        if ($data['cstKBN'] === 'Personal') {
            $data['Corp_Name'] = '';
            $data['Corp_Name_K'] = '';
            $data['dev'] = '';
        }

        $uploadedFiles = [];

        foreach (array_values(array_filter($request->file('file', []))) as $file) {
            $extension = strtolower($file->getClientOriginalExtension() ?: 'bin');
            $storedName = Str::uuid().'.'.$extension;
            $path = $file->storeAs('contact/upload', $storedName, 'public');

            $uploadedFiles[] = [
                'path' => $path,
                'name' => $file->getClientOriginalName(),
                'stored_name' => basename($path),
            ];
        }

        $data['uploaded_files'] = $uploadedFiles;
        $request->session()->put(self::SESSION_KEY, $data);

        return view('contact.confirm', [
            'form' => $data,
            'sampleProductGroups' => $this->sampleProductCatalog(),
        ]);
    }

    public function complete(Request $request): View|RedirectResponse
    {
        $form = $request->session()->get(self::SESSION_KEY);

        if (! is_array($form) || blank($form['email'] ?? null)) {
            return redirect()->route('contact.index');
        }

        $isSample = (string) ($form['sndKBN'] ?? '0') === '1';
        $itemType = trim((string) ($form['ItemType'] ?? ''));
        $inquiry = $isSample
            ? ($itemType !== '' ? $itemType.'の無料サンプル希望' : '無料サンプル希望')
            : 'お問い合わせ';
        $prefix = $isSample ? 'SA' : 'CO';
        $contactId = $this->newContactId($prefix);
        $createdAt = now();
        $uploadedFiles = is_array($form['uploaded_files'] ?? null) ? $form['uploaded_files'] : [];
        $fileUpdate = implode(',', array_filter(array_map(
            static fn (array $file): string => (string) ($file['stored_name'] ?? ''),
            $uploadedFiles
        )));
        $address = trim(implode(' ', array_filter([
            (string) ($form['address'] ?? ''),
            (string) ($form['address_street'] ?? ''),
        ])));

        DB::transaction(function () use ($contactId, $form, $inquiry, $fileUpdate, $address, $createdAt): void {
            DB::table('HM_contact_customer')->insert([
                'id' => $contactId,
                'email' => trim((string) $form['email']),
                'name' => trim((string) ($form['Name_S'] ?? '')),
                'name_k' => trim((string) ($form['Name_S_K'] ?? '')),
                'corp_name' => trim((string) ($form['Corp_Name'] ?? '')),
                'corp_names' => trim((string) ($form['Corp_Name_K'] ?? '')),
                'tel' => trim((string) ($form['tel'] ?? '')),
                'province' => trim((string) ($form['prefc'] ?? '')),
                'address' => $address,
                'zip_code' => trim((string) ($form['zip'] ?? '')),
                'signature' => trim((string) ($form['dev'] ?? '')),
                'inquiry' => $inquiry,
                'file_update' => $fileUpdate,
                'note' => trim((string) ($form['contactDetail'] ?? '')),
                'date_create' => $createdAt,
            ]);

            DB::table('HM_contact_status')->insert([
                'contact_id' => $contactId,
                'status' => 1,
                'date_modify' => $createdAt,
            ]);
        });

        $mailError = null;

        try {
            Mail::html($this->mailBody($form, $contactId, $inquiry, $uploadedFiles), function ($message) use ($form, $inquiry, $uploadedFiles): void {
                $from = (string) env('HM_CONTACT_FROM_ADDRESS', 'contact@hotmobily.jp');
                $message
                    ->to((string) $form['email'])
                    ->from($from, 'HOTMOBILY ウェブサイト')
                    ->subject('【ご連絡】'.$inquiry.'のご確認です！');

                foreach ($this->bccAddresses() as $bcc) {
                    $message->bcc($bcc, 'HOTMOBILY ウェブサイト');
                }

                foreach ($uploadedFiles as $file) {
                    $path = (string) ($file['path'] ?? '');

                    if ($path !== '' && Storage::disk('public')->exists($path)) {
                        $message->attach(Storage::disk('public')->path($path), [
                            'as' => (string) ($file['name'] ?? basename($path)),
                        ]);
                    }
                }
            });
        } catch (Throwable $exception) {
            report($exception);
            $mailError = 'メール送信は完了しませんでしたが、お問い合わせ内容は受け付けました。';
        }

        $request->session()->forget(self::SESSION_KEY);

        return view('contact.complete', [
            'contactId' => $contactId,
            'mailError' => $mailError,
        ]);
    }

    /** @return array<int, array{label: string, items: array<int, string>}> */
    private function sampleProductGroups(): array
    {
        return [
            [
                'label' => 'ラバー製品',
                'items' => [
                    'ラバーストラップ',
                    'ラバーキーホルダー',
                    'ラバーコースター',
                    'ラバースマホスタンド',
                    'ラバーイヤホンホルダー',
                    'ラバーキーカバー',
                    'ラバーペットボトルホルダー',
                    'ラバータグ',
                    'フォトフレーム',
                    'ジビッツチャーム',
                    'ラバーケーブルバンド',
                ],
            ],
            [
                'label' => 'クリーナー・反射材',
                'items' => [
                    'ラバー携帯クリーナー',
                    'ビニール携帯クリーナー',
                    '剥離クリーナー',
                    'リフレクターチャーム（圧着タイプ）',
                    'リフレクターチャーム（硬質タイプ）',
                    'リフレクターチャーム（表面印刷タイプ）',
                    '反射リストバンド',
                    '反射ステッカー',
                ],
            ],
            [
                'label' => 'マイクロファイバー・バッグ',
                'items' => [
                    'マイクロファイバーメガネクロス',
                    'マイクロファイバーマウスパッド',
                    'マイクロファイバーポーチ',
                    'マイクロファイバータオル',
                    'メガネクリーナー（リサイクル原糸）',
                    'クリアーポーチ',
                    '保冷バッグ',
                    'スマホ手袋',
                ],
            ],
            [
                'label' => 'LED・その他',
                'items' => [
                    'LEDライトチャーム（1点照射タイプ）',
                    'LEDライトチャーム（発光タイプ）',
                    'LEDペンライト',
                    'コンパクトジョグボトル',
                    'スタビーホルダー',
                    '防水ケース',
                    'PVCポーチ',
                    'クッションポーチ',
                    'その他（お問い合わせ内容にご希望製品を記載）',
                ],
            ],
            [
                'label' => 'アクリル製品',
                'items' => [
                    'アクリルキーホルダー',
                    '2連アクリルキーホルダー',
                    'アクリルスタンド',
                    'アクリルアンブレラマーカー',
                    'アクリルバッジ',
                    'アクリルコースター',
                    'アクリルヘアバンド',
                ],
            ],
            [
                'label' => '刺繍・金具',
                'items' => [
                    'フライトタグ（刺繍キーホルダー）',
                    'オリジナルワッペン',
                    '刺繍キーホルダー',
                    '刺繍バッジ',
                    'カラビナリング',
                ],
            ],
        ];
    }

    /** @return array<int, array{key: string, label: string, items: array<int, array{value: string, label: string}>}> */
    private function sampleProductCatalog(): array
    {
        $item = static fn (string $value, ?string $label = null): array => [
            'value' => $value,
            'label' => $label ?? $value,
        ];

        return [
            [
                'key' => 'group_a',
                'label' => 'ラバー製品',
                'items' => [
                    $item('ラバーストラップ'),
                    $item('ラバーキーホルダ', 'ラバーキーホルダー'),
                    $item('ラバーコースター'),
                    $item('ラバーキーカバー'),
                    $item('ラバーイヤホンホルダー'),
                    $item('ラバースマートフォンスタンド'),
                    $item('ラバーペットボトルホルダー'),
                    $item('ゴルフターゲットカップ'),
                    $item('ラバータグ'),
                    $item('フォトフレーム'),
                    $item('ジビッツチャーム'),
                    $item('ラバーケーブルバンド'),
                ],
            ],
            [
                'key' => 'group_b',
                'label' => 'クリーナー製品',
                'items' => [
                    $item('ラバー携帯クリーナー'),
                    $item('ビニール携帯クリーナー'),
                    $item('剥離クリーナー'),
                ],
            ],
            [
                'key' => 'group_c',
                'label' => '反射製品',
                'items' => [
                    $item('リフレクターチャーム（圧着タイプ）', 'リフレクターチャーム（圧着）'),
                    $item('リフレクターチャーム（硬質タイプ）', 'リフレクターチャーム（硬質）'),
                    $item('リフレクターチャーム（表面印刷タイプ）', 'リフレクターチャーム（印刷）'),
                    $item('反射リストバンド'),
                    $item('反射ステッカー'),
                ],
            ],
            [
                'key' => 'group_d',
                'label' => 'マイクロファイバー製品',
                'items' => [
                    $item('マイクロファイバーメガネクロス'),
                    $item('マイクロファイバーマウスパット'),
                    $item('マイクロファイバーポーチ'),
                    $item('マイクロファイバータオル'),
                    $item('メガネクリーナー（リサイクル原糸）'),
                    $item('メガネクリーナー（裏面タオル地）'),
                    $item('マイクロファイバーメガネケース'),
                ],
            ],
            [
                'key' => 'group_e',
                'label' => '季節製品',
                'items' => [
                    $item('保冷バッグ'),
                    $item('エコカイロ'),
                    $item('保冷材'),
                    $item('スマホ手袋'),
                    $item('ビーチサンダル'),
                ],
            ],
            [
                'key' => 'group_f',
                'label' => 'チャーム製品',
                'items' => [
                    $item('LEDライトチャーム（1点照射タイプ）', 'LEDライトチャーム（1点照射）'),
                    $item('LEDペンライト', 'LEDライトチャーム（発光タイプ）'),
                    $item('バックハンガー'),
                ],
            ],
            [
                'key' => 'group_g',
                'label' => 'ビニール製品他',
                'items' => [
                    $item('クリアーポーチ'),
                    $item('コンパクトジョグボトル'),
                    $item('スタビーホルダー'),
                    $item('ノベルティ用灰皿'),
                    $item('防水ケース'),
                    $item('テンチャックケース'),
                    $item('PVCポーチ'),
                    $item('クッションポーチ'),
                ],
            ],
            [
                'key' => 'group_h',
                'label' => 'アクリル製品',
                'items' => [
                    $item('アクリルキーホルダー'),
                    $item('2連アクリルキーホルダー'),
                    $item('ブリスターパック風アクリルキーホルダー'),
                    $item('シャカシャカアクリルキーホルダー'),
                    $item('アクリル詰め放題'),
                    $item('オーロラアクリルキーホルダー'),
                    $item('レインボーアクリルキーホルダー'),
                    $item('再生材料アクリルキーホルダー'),
                    $item('お守りアクリルキーホルダー'),
                    $item('アクリルフィギュアスタンド'),
                    $item('ジオラマアクリルスタンド'),
                    $item('モニターアクリルスタンド'),
                    $item('レインボーアクリルフィギュアスタンド'),
                    $item('オーロラアクリルフィギュアスタンド'),
                    $item('アクリルボード'),
                    $item('アクリルスマホスタンド'),
                    $item('アクリルアンブレラマーカー'),
                    $item('アクリルバッジ'),
                    $item('アクリルコースター'),
                    $item('アクリルヘアバンド'),
                    $item('アクリルグリップホルダー'),
                ],
            ],
            [
                'key' => 'group_k',
                'label' => '刺繍製品',
                'items' => [
                    $item('フライトタグ（刺繍キーホルダー）'),
                    $item('オリジナルワッペン'),
                    $item('刺繍キーホルダー'),
                    $item('刺繍バッジ'),
                    $item('刺繍コースター'),
                ],
            ],
            [
                'key' => 'group_i',
                'label' => '特殊製品',
                'items' => [
                    $item('カラビナ'),
                ],
            ],
            [
                'key' => 'group_j',
                'label' => 'その他',
                'items' => [
                    $item('その他', 'その他（お問い合わせ内容にご希望製品を記載ください）'),
                ],
            ],
        ];
    }

    private function newContactId(string $prefix): string
    {
        $base = $prefix.'_'.now()->format('YmdHi');
        $contactId = $base;
        $suffix = 1;

        while (DB::table('HM_contact_customer')->where('id', $contactId)->exists()) {
            $contactId = $base.str_pad((string) $suffix, 2, '0', STR_PAD_LEFT);
            $suffix++;
        }

        return $contactId;
    }

    /** @return array<int, string> */
    private function bccAddresses(): array
    {
        return collect(explode(',', (string) env('HM_CONTACT_BCC', 'contact@hotmobily.jp,nishioka@yejpn.com')))
            ->map(static fn (string $address): string => trim($address))
            ->filter(static fn (string $address): bool => filter_var($address, FILTER_VALIDATE_EMAIL) !== false)
            ->unique()
            ->values()
            ->all();
    }

    /** @param array<string, mixed> $form */
    private function mailBody(array $form, string $contactId, string $inquiry, array $uploadedFiles): string
    {
        $line = static fn (string $label, mixed $value): string => '<strong>'.e($label).':</strong> '.nl2br(e((string) $value)).'<br>';
        $body = e((string) ($form['Name_S'] ?? '')).' 様よりお問い合わせをいただきました。<br><br>';
        $body .= $line('受付番号', $contactId);
        $body .= $line('お問い合わせ区分', $inquiry);
        $body .= $line('お客様区分', ($form['cstKBN'] ?? '') === 'Personal' ? '個人' : '法人');
        $body .= $line('お名前', $form['Name_S'] ?? '');
        $body .= $line('フリガナ', $form['Name_S_K'] ?? '');
        $body .= $line('法人名', $form['Corp_Name'] ?? '');
        $body .= $line('法人名（フリガナ）', $form['Corp_Name_K'] ?? '');
        $body .= $line('メールアドレス', $form['email'] ?? '');
        $body .= $line('部署名', $form['dev'] ?? '');
        $body .= $line('電話番号', $form['tel'] ?? '');
        $body .= $line('郵便番号', $form['zip'] ?? '');
        $body .= $line('都道府県', $form['prefc'] ?? '');
        $body .= $line('以降の住所', $form['address'] ?? '');
        $body .= $line('番地・建物名・部屋番号', $form['address_street'] ?? '');
        $body .= '<br><strong>お問い合わせ内容:</strong><br>'.nl2br(e((string) ($form['contactDetail'] ?? '')));

        if ($uploadedFiles !== []) {
            $body .= '<br><br><strong>添付ファイル:</strong><br>'.implode('<br>', array_map(
                static fn (array $file): string => e((string) ($file['name'] ?? '')),
                $uploadedFiles
            ));
        }

        return $body;
    }
}
