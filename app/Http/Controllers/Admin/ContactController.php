<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class ContactController extends Controller
{
    private const CUSTOMER_TABLE = 'HM_contact_customer';

    private const STATUS_TABLE = 'HM_contact_status';

    private const STATUS_SETUP_TABLE = 'HM_contact_status_setup';

    private const REPLIED_TABLE = 'HM_contact_replied';

    private const LOG_TABLE = 'HM_log';

    public function index(Request $request): View
    {
        $filters = $this->filters($request);
        $statuses = Schema::hasTable(self::STATUS_SETUP_TABLE)
            ? DB::table(self::STATUS_SETUP_TABLE)->orderBy('id')->get()
            : collect();
        $contacts = collect();

        if ($this->contactTablesReady()) {
            $query = DB::table(self::CUSTOMER_TABLE.' as customer')
                ->join(self::STATUS_TABLE.' as contact_status', 'contact_status.contact_id', '=', 'customer.id')
                ->join(self::STATUS_SETUP_TABLE.' as status_setup', 'status_setup.id', '=', 'contact_status.status')
                ->where('customer.inquiry', '<>', '')
                ->select([
                    'customer.id',
                    'customer.date_create',
                    'customer.inquiry',
                    'customer.email',
                    'contact_status.status as status_id',
                    'status_setup.details as status_details',
                ])
                ->orderByDesc('customer.date_create');

            if (filled($filters['id'])) {
                $query->where('customer.id', 'like', '%'.$filters['id'].'%');
            }

            if (filled($filters['email'])) {
                $query->where('customer.email', 'like', '%'.$filters['email'].'%');
            }

            if (filled($filters['name'])) {
                $query->where('customer.name', 'like', '%'.$filters['name'].'%');
            }

            if (filled($filters['corp_name'])) {
                $query->where('customer.corp_name', 'like', '%'.$filters['corp_name'].'%');
            }

            if (filled($filters['tel'])) {
                $query->where('customer.tel', 'like', '%'.$filters['tel'].'%');
            }

            if (filled($filters['date_from']) && filled($filters['date_to'])) {
                $query->whereBetween('customer.date_create', [
                    Carbon::parse($filters['date_from'])->startOfDay(),
                    Carbon::parse($filters['date_to'])->endOfDay(),
                ]);
            }

            if (filled($filters['status'])) {
                $query->where('contact_status.status', $filters['status']);
            }

            if ($filters['inquiry_type'] === 'query') {
                $query->where('customer.id', 'like', '%CO%');
            } elseif ($filters['inquiry_type'] === 'sample') {
                $query->where('customer.id', 'like', '%SA%');
            }

            $contacts = $query->get();
        }

        return view('admin.contacts.index', [
            'contacts' => $contacts,
            'filters' => $filters,
            'statuses' => $statuses,
            'contactTablesReady' => $this->contactTablesReady(),
        ]);
    }

    public function show(string $contactId): View
    {
        $contact = $this->findContact($contactId);

        abort_if($contact === null, 404);

        $replies = Schema::hasTable(self::REPLIED_TABLE)
            ? DB::table(self::REPLIED_TABLE)
                ->where('contact_id', $contactId)
                ->orderBy('date_create')
                ->get()
            : collect();

        $statuses = Schema::hasTable(self::STATUS_SETUP_TABLE)
            ? DB::table(self::STATUS_SETUP_TABLE)->orderBy('id')->get()
            : collect();

        return view('admin.contacts.show', [
            'contact' => $contact,
            'replies' => $replies,
            'statuses' => $statuses,
            'replyDraft' => session($this->replySessionKey($contactId), []),
        ]);
    }

    public function legacyShow(Request $request): View
    {
        $contactId = trim((string) $request->query('id', ''));

        abort_if($contactId === '', 404);

        return $this->show($contactId);
    }

    public function updateStatus(Request $request, string $contactId): RedirectResponse
    {
        $contact = $this->findContact($contactId);

        abort_if($contact === null, 404);

        $data = $request->validate([
            'status' => ['required', 'string', 'max:100'],
        ]);

        abort_unless(
            Schema::hasTable(self::STATUS_SETUP_TABLE)
                && DB::table(self::STATUS_SETUP_TABLE)->where('id', $data['status'])->exists(),
            422,
            'The selected contact status does not exist.'
        );

        $statusQuery = DB::table(self::STATUS_TABLE)
            ->where('contact_id', $contactId);

        if ($statusQuery->exists()) {
            $statusQuery->update(['status' => $data['status']]);
        } else {
            DB::table(self::STATUS_TABLE)->insert([
                'contact_id' => $contactId,
                'status' => $data['status'],
                'date_modify' => now(),
            ]);
        }

        $this->writeLog('UPDATE:Update inquiry status');

        return redirect()
            ->route('admin.contact.show', ['contact' => $contactId])
            ->with('success', 'Contact status updated.');
    }

    public function replyConfirm(Request $request, string $contactId): View|RedirectResponse
    {
        $contact = $this->findContact($contactId);

        abort_if($contact === null, 404);

        if (! filter_var((string) ($contact->email ?? ''), FILTER_VALIDATE_EMAIL)) {
            return back()->withErrors([
                'reply' => 'This contact does not have a valid email address.',
            ])->withInput();
        }

        $data = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'sale' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:50000'],
            'attachments' => ['nullable', 'array', 'max:3'],
            'attachments.*' => [
                'file',
                'max:10240',
                'mimes:ai,pdf,doc,docx,xls,xlsx,jpeg,jpg,png,psd,zip,eps',
            ],
        ]);

        $sessionKey = $this->replySessionKey($contactId);
        $previousDraft = session($sessionKey, []);
        $previousDraft = is_array($previousDraft) ? $previousDraft : [];
        $previousAttachments = is_array($previousDraft['attachments'] ?? null)
            ? $previousDraft['attachments']
            : [];
        $uploadedFiles = array_values(array_filter($request->file('attachments', [])));

        $attachments = $uploadedFiles === [] ? $previousAttachments : [];
        $directory = 'contact-replies/'.$this->safeContactDirectory($contactId);

        foreach ($uploadedFiles as $file) {
            $extension = strtolower($file->getClientOriginalExtension() ?: 'bin');
            $storedName = Str::uuid().'.'.$extension;
            $path = $file->storeAs($directory, $storedName, 'local');

            if (! is_string($path) || $path === '' || ! Storage::disk('local')->exists($path)) {
                $this->deleteReplyFiles(['attachments' => $attachments]);

                return back()
                    ->withErrors(['attachments' => 'The selected file could not be stored. Please select it again.'])
                    ->withInput();
            }

            $attachments[] = [
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType() ?: 'application/octet-stream',
            ];
        }

        if ($uploadedFiles !== []) {
            $this->deleteReplyFiles($previousDraft);
        }

        $draft = [
            'contact_id' => $contactId,
            'subject' => trim($data['subject']),
            'sale' => trim((string) ($data['sale'] ?? '')),
            'content' => $data['content'],
            'attachments' => $attachments,
        ];

        session([$sessionKey => $draft]);

        return view('admin.contacts.reply-confirm', [
            'contact' => $contact,
            'draft' => $draft,
            'body' => $this->replyBody($contact, $draft['content']),
        ]);
    }

    public function replySend(string $contactId): RedirectResponse
    {
        $contact = $this->findContact($contactId);

        abort_if($contact === null, 404);

        $sessionKey = $this->replySessionKey($contactId);
        $draft = session($sessionKey);

        if (! is_array($draft) || ($draft['contact_id'] ?? null) !== $contactId) {
            return redirect()
                ->route('admin.contact.show', ['contact' => $contactId])
                ->withErrors(['reply' => 'The reply draft has expired.']);
        }

        $body = $this->replyBody($contact, (string) ($draft['content'] ?? ''));
        $attachments = is_array($draft['attachments'] ?? null) ? $draft['attachments'] : [];

        try {
            Mail::html(
                '<pre style="white-space: pre-wrap; font-family: inherit;">'.e($body).'</pre>',
                function ($message) use ($contact, $draft, $attachments): void {
                    $message
                        ->to($contact->email)
                        ->from(
                            (string) env('HM_CONTACT_FROM_ADDRESS', 'contact@hotmobily.jp'),
                            'HOTMOBILY ウェブサイト'
                        )
                        ->subject($draft['subject']);

                    foreach ($this->contactBccs() as $bcc) {
                        $message->bcc($bcc, 'HOTMOBILY ウェブサイト');
                    }

                    foreach ($attachments as $attachment) {
                        $path = (string) ($attachment['path'] ?? '');

                        if ($path === '' || ! Storage::disk('local')->exists($path)) {
                            throw new \RuntimeException('Reply attachment is missing: '.$path);
                        }

                        $mimeType = $attachment['mime_type'] ?? Storage::disk('local')->mimeType($path);

                        $message->attachData(
                            Storage::disk('local')->get($path),
                            (string) ($attachment['original_name'] ?? basename($path)),
                            [
                                'mime' => (string) ($mimeType ?: 'application/octet-stream'),
                            ]
                        );
                    }
                }
            );

            DB::table(self::REPLIED_TABLE)->insert([
                'contact_id' => $contactId,
                'sale_name' => $draft['sale'] ?? '',
                'subject' => $draft['subject'] ?? '',
                'content' => $body,
                'date_create' => now(),
            ]);

            $this->writeLog('Insert:Inquiry replied');
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('admin.contact.show', ['contact' => $contactId])
                ->withErrors(['reply' => 'The email could not be sent. Please check the mail settings.']);
        }

        $this->deleteReplyFiles($draft);
        session()->forget($sessionKey);

        return redirect()
            ->route('admin.contact.show', ['contact' => $contactId])
            ->with('success', 'Reply email sent.');
    }

    public function downloadAttachment(string $contactId, string $filename): Response
    {
        abort_if($this->findContact($contactId) === null, 404);

        $safeFilename = basename($filename);
        abort_if($safeFilename !== $filename || $safeFilename === '.', 404);

        $paths = [
            public_path('contact/upload/'.$safeFilename),
            storage_path('app/public/contact/upload/'.$safeFilename),
            base_path('original-web/contact/upload/'.$safeFilename),
        ];

        foreach ($paths as $path) {
            if (is_file($path)) {
                return response()->download($path, $safeFilename);
            }
        }

        abort(404);
    }

    /** @return array{id: string, email: string, name: string, corp_name: string, tel: string, date_from: string, date_to: string, inquiry_type: string, status: string} */
    private function filters(Request $request): array
    {
        $empty = [
            'id' => '',
            'email' => '',
            'name' => '',
            'corp_name' => '',
            'tel' => '',
            'date_from' => '',
            'date_to' => '',
            'inquiry_type' => '',
            'status' => '',
        ];

        if ($request->boolean('clear')) {
            session()->forget('admin.contact.search');

            return $empty;
        }

        if ($request->hasAny(array_keys($empty))) {
            $data = $request->validate([
                'id' => ['nullable', 'string', 'max:100'],
                'email' => ['nullable', 'string', 'max:255'],
                'name' => ['nullable', 'string', 'max:255'],
                'corp_name' => ['nullable', 'string', 'max:255'],
                'tel' => ['nullable', 'string', 'max:100'],
                'date_from' => ['nullable', 'date'],
                'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
                'inquiry_type' => ['nullable', 'in:query,sample'],
                'status' => ['nullable', 'string', 'max:100'],
            ]);

            $filters = array_map(
                static fn ($value): string => trim((string) ($value ?? '')),
                array_merge($empty, $data)
            );

            session(['admin.contact.search' => $filters]);

            return $filters;
        }

        return array_merge($empty, session('admin.contact.search', []));
    }

    private function findContact(string $contactId): ?object
    {
        if (! $this->contactTablesReady()) {
            return null;
        }

        return DB::table(self::CUSTOMER_TABLE.' as customer')
            ->join(self::STATUS_TABLE.' as contact_status', 'contact_status.contact_id', '=', 'customer.id')
            ->join(self::STATUS_SETUP_TABLE.' as status_setup', 'status_setup.id', '=', 'contact_status.status')
            ->where('customer.id', $contactId)
            ->select([
                'customer.*',
                'contact_status.status as status_id',
                'status_setup.details as status_details',
            ])
            ->first();
    }

    private function contactTablesReady(): bool
    {
        foreach ([self::CUSTOMER_TABLE, self::STATUS_TABLE, self::STATUS_SETUP_TABLE] as $table) {
            if (! Schema::hasTable($table)) {
                return false;
            }
        }

        return true;
    }

    private function replySessionKey(string $contactId): string
    {
        return 'admin.contact.reply.'.sha1($contactId);
    }

    private function safeContactDirectory(string $contactId): string
    {
        return preg_replace('/[^A-Za-z0-9_-]+/', '_', $contactId) ?: 'contact';
    }

    private function replyBody(object $contact, string $content): string
    {
        $name = trim((string) ($contact->name ?? ''));
        $corpName = trim((string) ($contact->corp_name ?? ''));
        $recipient = $name !== '' ? $name.' 様' : '';

        if ($corpName !== '') {
            return $corpName."\n".$recipient."\n\n".$content;
        }

        return $recipient."\n\n".$content;
    }

    /** @return list<string> */
    private function contactBccs(): array
    {
        $configured = array_filter(array_map(
            static fn (string $email): string => trim($email),
            explode(',', (string) env('HM_CONTACT_BCC', ''))
        ));

        if ($configured !== []) {
            return array_values(array_unique($configured));
        }

        return [
            'kadota@yejpn.com',
            'kikuchi@yejpn.com',
            'deng@yejpn.com',
            'takemura@yejpn.com',
            'sakata@yejpn.com',
            'abe@yejpn.com',
            'takaseki@yejpn.com',
            'umetsu@yejpn.com',
            'hara@yejpn.com',
            'vivianne@yejpn.com',
        ];
    }

    private function writeLog(string $detail): void
    {
        if (! Schema::hasTable(self::LOG_TABLE)) {
            return;
        }

        DB::table(self::LOG_TABLE)->insert([
            'user' => auth('admin')->user()?->user ?? 'admin',
            'detail' => $detail,
            'date_create' => now(),
        ]);
    }

    private function deleteReplyFiles(array $draft): void
    {
        foreach (($draft['attachments'] ?? []) as $attachment) {
            if (is_array($attachment) && filled($attachment['path'] ?? null)) {
                Storage::disk('local')->delete((string) $attachment['path']);
            }
        }
    }
}
