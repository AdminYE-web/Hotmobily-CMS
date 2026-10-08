@extends('admin.layouts.app')

@section('title', 'Contact detail')

@push('styles')
    <style>
        .contact-detail-page {
            width: 100%;
            max-width: none;
            padding-top: 10px !important;
        }

        .contact-detail-page h2 {
            display: inline-block;
            margin: 0 0 15px;
            padding: 10px 0;
            border-bottom: 3px solid #808080;
            font-size: 28px;
            line-height: 1.25;
        }

        .contact-detail-page h3 {
            margin: 20px 0 10px;
            font-size: 22px;
            line-height: 1.35;
        }

        .contact-detail-table {
            width: 80%;
            margin: 0;
            border: 1px solid #808080;
            border-collapse: collapse;
            table-layout: fixed;
            line-height: 1.5;
            background: #fff;
            box-shadow: none;
        }

        .contact-detail-table th,
        .contact-detail-table td {
            width: 80%;
            border: 1px solid #808080;
            padding: 8px;
            background: #fff;
            color: #000;
            vertical-align: top;
            text-align: left !important;
            overflow-wrap: anywhere;
        }

        .contact-detail-table th:first-child,
        .contact-detail-table td:first-child {
            width: 20%;
            background: #6fb4ff;
            font-weight: 600;
        }

        .contact-detail-table pre,
        .contact-confirm pre {
            white-space: pre-wrap;
            overflow-wrap: anywhere;
            margin: 0;
            font: inherit;
        }

        .contact-reply-card {
            width: 80%;
            margin: 0 0 10px;
            border: 1px solid #808080;
            border-collapse: collapse;
            line-height: 1.5;
            background: #fff;
            display: table;
            table-layout: fixed;
        }

        .contact-reply-card__row {
            display: table-row;
        }

        .contact-reply-card__row:last-child {
            border-bottom: 0;
        }

        .contact-reply-card__label,
        .contact-reply-card__value {
            display: table-cell;
            border: 1px solid #808080;
            padding: 8px;
            vertical-align: top;
        }

        .contact-reply-card__label {
            width: 20%;
            background: #6fb4ff;
            font-weight: 600;
        }

        .contact-reply-card__value {
            width: 80%;
            background: #fff;
        }

        .contact-reply-form {
            width: 80%;
            margin-top: 10px;
        }

        .contact-reply-form.is-hidden {
            display: none;
        }

        .contact-reply-form label {
            margin: 0;
        }

        .contact-reply-form input[type="text"],
        .contact-reply-form textarea {
            width: 100%;
            margin: 0;
            border: 1px solid #808080;
            border-radius: 0;
            padding: 6px 8px;
        }

        .contact-reply-form textarea {
            min-height: 200px;
            resize: vertical;
        }

        .contact-upload-box {
            padding: 20px 5px;
            border: 2px dashed #cbd5df;
            background: #f8fafc;
            text-align: center;
        }

        .contact-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 0 0 10px;
        }

        .contact-btn {
            display: inline-block;
            border: 0;
            border-radius: 5px;
            padding: 5px 15px;
            font-size: 16px;
            line-height: 1.5;
            cursor: pointer;
        }

        .contact-btn--back {
            background: #808080;
            color: #fff;
        }

        .contact-btn--back:hover,
        .contact-btn--back:focus {
            background: #000;
            color: #fff;
            text-decoration: none;
        }

        .contact-btn--submit,
        .contact-status-form button,
        .contact-reply-trigger {
            background: #d82234;
            color: #fff;
        }

        .contact-btn--submit:hover,
        .contact-btn--submit:focus,
        .contact-status-form button:hover,
        .contact-status-form button:focus,
        .contact-reply-trigger:hover,
        .contact-reply-trigger:focus {
            background: #da4c5a;
            color: #fff;
        }

        .contact-status-form {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
        }

        .contact-status-form select {
            width: auto;
            min-width: 170px;
            height: 35px;
            border: 1px solid #808080;
            border-radius: 0;
            padding: 4px 8px;
        }

        .contact-form-submit {
            background: transparent !important;
            text-align: right !important;
        }

        .contact-draft-files {
            margin-top: 8px;
        }

        .contact-draft-files ul {
            margin: 4px 0 0;
        }

        .contact-alert {
            width: 80%;
            margin-bottom: 12px;
            padding: 10px 12px;
        }

        .contact-alert--success {
            color: #155724;
            background: #d4edda;
            border: 1px solid #c3e6cb;
        }

        .contact-alert--error {
            color: #721c24;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 640px) {
            .contact-detail-page {
                padding-right: 10px !important;
                padding-left: 10px !important;
            }

            .contact-detail-table,
            .contact-reply-form,
            .contact-alert {
                width: 100%;
            }

            .contact-detail-table th,
            .contact-detail-table td {
                width: auto;
            }

            .contact-detail-table th:first-child,
            .contact-detail-table td:first-child {
                width: 32%;
            }

            .contact-detail-page h2 {
                font-size: 24px;
            }

            .contact-detail-page h3 {
                font-size: 20px;
            }
        }
    </style>
@endpush

@section('content')
    @php
        $fileUpdate = trim((string) data_get($contact, 'file_update', ''));
        $openReply = $errors->any();
    @endphp

    <main class="container-fluid py-3 contact-detail-page">
        <div class="contact-actions">
            <a href="{{ route('admin.contact.index') }}" class="contact-btn contact-btn--back">&lt; back</a>
        </div>

        @if (session('success'))
            <div class="contact-alert contact-alert--success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="contact-alert contact-alert--error">
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2>{{ data_get($contact, 'inquiry', 'Contact') }}({{ data_get($contact, 'status_details', '-') }})</h2>

        @if ($replies->isNotEmpty())
            <h3>Reply mail</h3>

            @foreach ($replies as $reply)
                <div class="contact-reply-card">
                    <div class="contact-reply-card__row">
                        <div class="contact-reply-card__label">Subject</div>
                        <div class="contact-reply-card__value">{{ $reply->subject }}</div>
                    </div>
                    <div class="contact-reply-card__row">
                        <div class="contact-reply-card__label">Message</div>
                        <div class="contact-reply-card__value"><pre>{{ $reply->content }}</pre></div>
                    </div>
                    <div class="contact-reply-card__row">
                        <div class="contact-reply-card__label">Sale</div>
                        <div class="contact-reply-card__value">{{ $reply->sale_name }}</div>
                    </div>
                    <div class="contact-reply-card__row">
                        <div class="contact-reply-card__label">Date</div>
                        <div class="contact-reply-card__value">{{ $reply->date_create }}</div>
                    </div>
                </div>
            @endforeach
        @endif

        <h3>Contact data</h3>
        <table class="contact-detail-table">
            <tr>
                <th>Date</th>
                <td>{{ data_get($contact, 'date_create', '-') }}</td>
            </tr>
            <tr>
                <th>ID</th>
                <td>{{ data_get($contact, 'id', '-') }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ data_get($contact, 'email', '-') }}</td>
            </tr>
            <tr>
                <th>file upload</th>
                <td>
                    @if ($fileUpdate !== '')
                        <a href="{{ route('admin.contact.attachment', ['contact' => $contact->id, 'filename' => basename($fileUpdate)]) }}" target="_blank" rel="noopener">
                            {{ $fileUpdate }}
                        </a>
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <th>Note</th>
                <td>{{ data_get($contact, 'note', '-') }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <form method="POST" action="{{ route('admin.contact.status.update', ['contact' => $contact->id]) }}" class="contact-status-form">
                        @csrf
                        @method('PUT')
                        <select name="status">
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}" @selected((string) $status->id === (string) data_get($contact, 'status_id'))>
                                    {{ $status->details }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="contact-btn">update</button>
                    </form>
                </td>
            </tr>
            <tr>
                <th>Reply</th>
                <td>
                    <button type="button" class="contact-btn contact-reply-trigger" data-contact-reply-toggle>reply email</button>
                </td>
            </tr>
        </table>

        <h3>Customer data</h3>
        <table class="contact-detail-table">
            <tr><th>お名前</th><td>{{ data_get($contact, 'name', '-') }}</td></tr>
            <tr><th>お名前（メイ）</th><td>{{ data_get($contact, 'name_k', '-') }}</td></tr>
            <tr><th>法人名</th><td>{{ data_get($contact, 'corp_name', '-') }}</td></tr>
            <tr><th>法人名（フリガナ）</th><td>{{ data_get($contact, 'corp_names', '-') }}</td></tr>
            <tr><th>お客様部署名</th><td>{{ data_get($contact, 'signature', '-') }}</td></tr>
            <tr><th>TEL</th><td>{{ data_get($contact, 'tel', '-') }}</td></tr>
            <tr><th>都道府県</th><td>{{ data_get($contact, 'province', '-') }}</td></tr>
            <tr><th>以降の住所</th><td>{{ data_get($contact, 'address', '-') }}</td></tr>
            <tr><th>郵便</th><td>{{ data_get($contact, 'zip_code', '-') }}</td></tr>
        </table>

        <div id="contact-reply-form" class="contact-reply-form {{ $openReply ? '' : 'is-hidden' }}">
            <form method="POST" action="{{ route('admin.contact.reply.confirm', ['contact' => $contact->id]) }}" enctype="multipart/form-data">
                @csrf
                <table class="contact-detail-table">
                    <tr>
                        <td>Subject</td>
                        <td><input id="contact-subject" type="text" name="subject" value="{{ old('subject', $replyDraft['subject'] ?? '') }}" required></td>
                    </tr>
                    <tr>
                        <td>Sale's name</td>
                        <td><input id="contact-sale" type="text" name="sale" value="{{ old('sale', $replyDraft['sale'] ?? '') }}"></td>
                    </tr>
                    <tr>
                        <td>Content</td>
                        <td><textarea id="contact-content" name="content" required>{{ old('content', $replyDraft['content'] ?? '') }}</textarea></td>
                    </tr>
                    <tr>
                        <td>file upload</td>
                        <td>
                            <div class="contact-upload-box">
                                <input id="contact-attachments" type="file" name="attachments[]" multiple>
                            </div>
                            <div class="text-muted small">
                                Allowed: ai, pdf, doc, docx, xls, xlsx, jpeg, jpg, png, psd, zip, eps. Maximum 10MB per file, maximum 3 files.
                            </div>

                            @if (! empty($replyDraft['attachments']))
                                <div class="contact-draft-files">
                                    <strong>Files in current draft:</strong>
                                    <ul>
                                        @foreach ($replyDraft['attachments'] as $attachment)
                                            <li>{{ $attachment['original_name'] ?? basename($attachment['path'] ?? '') }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="contact-form-submit">
                            <button type="submit" class="contact-btn contact-btn--submit">send</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.querySelector('[data-contact-reply-toggle]');
            const form = document.getElementById('contact-reply-form');

            if (toggle && form) {
                toggle.addEventListener('click', function () {
                    form.classList.toggle('is-hidden');
                    if (!form.classList.contains('is-hidden')) {
                        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            }
        });
    </script>
@endpush
