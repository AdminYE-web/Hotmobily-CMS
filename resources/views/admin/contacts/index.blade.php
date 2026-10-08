@extends('admin.layouts.app')

@section('title', 'Contact/Inquire')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .contact-page {
            max-width: none;
            padding-right: 9px !important;
            padding-left: 9px !important;
        }

        .contact-search {
            display: flex;
            width: 100%;
            justify-content: center;
            align-items: center;
            padding: 15px 0;
            margin: 0 0 24px;
        }

        .contact-search__inner {
            width: 100%;
        }

        .contact-search__basic {
            width: 100%;
            border-bottom: 5px solid #808080;
            background: #fff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .contact-search__input-field {
            display: flex;
            width: 100%;
        }

        .contact-search__basic input {
            display: block;
            width: 100%;
            height: 80px;
            margin: 0;
            padding: 10px 20px;
            border: 0;
            border-radius: 3px;
            outline: 0;
            background: #fff;
            color: #555;
            font-size: 18px;
        }

        .contact-search__icon {
            display: inline-block;
            flex: 0 0 auto;
            height: 80px;
            padding: 15px 25px;
            border: 0;
            color: #333;
            text-align: center;
            font-size: 35px;
            line-height: 1.15;
            cursor: pointer;
        }

        .contact-search__icon:hover,
        .contact-search__icon:active {
            color: #000;
            background: #6fb4ff;
        }

        .contact-search__icon--search {
            width: 80px;
            background: #fff;
        }

        .contact-search__icon--toggle {
            width: 102px;
            background: #6fb4ff;
        }

        .contact-search__advanced {
            display: none;
            width: 100%;
            min-height: 200px;
            padding: 25px 30px 20px;
            background: #fff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .contact-search__advanced.is-open {
            display: block;
        }

        .contact-search__grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px 35px;
        }

        .contact-search__grid input,
        .contact-search__grid select {
            width: 100%;
            height: 40px;
            margin: 0;
            padding: 8px 10px;
            border: 1px solid #aaa;
            border-radius: 0;
            background: #fff;
            color: #555;
            font-size: 16px;
            line-height: 1.15;
        }

        .contact-search__actions {
            display: flex;
            justify-content: flex-end;
            gap: 20px;
            margin-top: 15px;
        }

        .contact-search__actions button {
            display: inline-block;
            width: 140px;
            height: 45px;
            padding: 10px;
            border: 2px solid #e6e6e6;
            border-radius: 5px;
            color: #fff;
            font-size: 18px;
            font-weight: 500;
            text-align: center;
            outline: 0;
            box-shadow: 2px 3px 0 rgb(182, 193, 202);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .contact-search__actions button:hover {
            background: #000;
        }

        .contact-search__actions .btn-search {
            background: #006fd8;
        }

        .contact-search__actions .btn-delete {
            background: #828282;
        }

        .contact-table-wrap {
            overflow-x: auto;
            background: #fff;
        }

        .contact-table {
            width: 100%;
            margin: 0;
            border-collapse: collapse;
            table-layout: fixed;
            border: 1px solid gray;
            box-shadow: none;
        }

        .contact-table th,
        .contact-table td {
            border: 1px solid gray;
            padding: 10px;
            text-align: left;
            vertical-align: middle;
        }

        .contact-table th {
            background: #99bcdd;
            color: #fff;
            font-size: 17px;
            font-weight: bold;
            text-align: center;
        }

        .contact-table tbody tr:hover {
            background: #ddd;
        }

        .contact-table a {
            color: inherit;
            text-decoration: none;
        }

        .contact-table tbody td {
            overflow: hidden;
            color: #000;
            font-size: 16px;
            font-weight: normal;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .contact-table tbody td:nth-child(1),
        .contact-table tbody td:nth-child(2),
        .contact-table tbody td:nth-child(5) {
            text-align: center;
        }

        .contact-table th:nth-child(1),
        .contact-table td:nth-child(1) {
            width: 15%;
        }

        .contact-table th:nth-child(2),
        .contact-table td:nth-child(2) {
            width: 15%;
        }

        .contact-table th:nth-child(3),
        .contact-table td:nth-child(3) {
            width: 35%;
        }

        .contact-table th:nth-child(4),
        .contact-table td:nth-child(4) {
            width: 25%;
        }

        .contact-table th:nth-child(5),
        .contact-table td:nth-child(5) {
            width: 10%;
        }

        .contact-empty,
        .contact-warning {
            padding: 18px;
            border: 1px solid #d7dce1;
            background: #fff;
        }

        .contact-warning {
            border-color: #f0c36d;
            background: #fff8e5;
        }

        @media (max-width: 900px) {
            .contact-search__grid {
                grid-template-columns: repeat(2, minmax(150px, 1fr));
            }
        }

        @media (max-width: 576px) {
            .contact-search__icon--toggle {
                width: 70px;
            }

            .contact-search__grid {
                grid-template-columns: 1fr;
            }

            .contact-search__actions {
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    @php
        $advancedValues = [
            $filters['id'] ?? '',
            $filters['name'] ?? '',
            $filters['corp_name'] ?? '',
            $filters['tel'] ?? '',
            $filters['date_from'] ?? '',
            $filters['date_to'] ?? '',
            $filters['inquiry_type'] ?? '',
            $filters['status'] ?? '',
        ];
        $advancedOpen = collect($advancedValues)->contains(fn ($value) => filled($value));
    @endphp

    <main class="container-fluid py-3 contact-page">
        @if (! $contactTablesReady)
            <div class="contact-warning mb-3">
                The legacy contact tables are not available in the current database. Run the contact migration or import the original HM_contact_* tables first.
            </div>
        @endif

        <form method="GET" action="{{ route('admin.contact.index') }}" class="contact-search">
            <div class="contact-search__inner">
                <div class="contact-search__basic">
                    <div class="contact-search__input-field">
                        <input
                            type="text"
                            name="email"
                            value="{{ $filters['email'] ?? '' }}"
                            placeholder="Email"
                            aria-label="Email"
                        >
                        <button type="submit" class="contact-search__icon contact-search__icon--search" aria-label="Search">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="contact-search__icon contact-search__icon--toggle" data-contact-search-toggle aria-label="Toggle advanced search">
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

                <div class="contact-search__advanced {{ $advancedOpen ? 'is-open' : '' }}" data-contact-search-advanced>
                    <div class="contact-search__grid">
                        <input type="text" name="id" value="{{ $filters['id'] ?? '' }}" placeholder="ID">
                        <input type="text" name="name" value="{{ $filters['name'] ?? '' }}" placeholder="Name">
                        <input type="text" name="corp_name" value="{{ $filters['corp_name'] ?? '' }}" placeholder="corp_name">
                        <input type="text" name="tel" value="{{ $filters['tel'] ?? '' }}" placeholder="Tel">
                        <input type="text" name="date_from" value="{{ $filters['date_from'] ?? '' }}" placeholder="Date first" aria-label="Date first">
                        <input type="text" name="date_to" value="{{ $filters['date_to'] ?? '' }}" placeholder="Date last" aria-label="Date last">
                        <select name="inquiry_type">
                            <option value="">Inquiry Type</option>
                            <option value="query" @selected(($filters['inquiry_type'] ?? '') === 'query')>お問い合わせのみ</option>
                            <option value="sample" @selected(($filters['inquiry_type'] ?? '') === 'sample')>無料サンプル希望</option>
                        </select>
                        <select name="status">
                            <option value="">Status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}" @selected((string) ($filters['status'] ?? '') === (string) $status->id)>
                                    {{ $status->details }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="contact-search__actions">
                        <button type="submit" class="btn-search">Search</button>
                        <button type="button" class="btn-delete" data-contact-search-clear>Clear</button>
                    </div>
                </div>
            </div>
        </form>

        @if ($contacts->isEmpty())
            <div class="contact-empty">No inquiries found.</div>
        @else
            <div class="contact-table-wrap">
                <table class="contact-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>ID</th>
                            <th>Inquiry</th>
                            <th>Email</th>
                            <th>status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $contact)
                            <tr>
                                <td>{{ $contact->date_create ?: '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.contact.show', ['contact' => $contact->id]) }}">
                                        {{ $contact->id }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.contact.show', ['contact' => $contact->id]) }}">
                                        {{ $contact->inquiry ?: '-' }}
                                    </a>
                                </td>
                                <td>{{ $contact->email ?: '-' }}</td>
                                <td>{{ $contact->status_details ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.querySelector('[data-contact-search-toggle]');
            const advanced = document.querySelector('[data-contact-search-advanced]');

            if (toggle && advanced) {
                toggle.addEventListener('click', function () {
                    advanced.classList.toggle('is-open');
                });
            }

            const clear = document.querySelector('[data-contact-search-clear]');
            const form = clear ? clear.closest('form') : null;

            if (clear && form) {
                clear.addEventListener('click', function () {
                    form.querySelectorAll('input, select').forEach(function (field) {
                        if (field.type === 'submit' || field.type === 'button') {
                            return;
                        }

                        field.value = '';
                    });

                    form.submit();
                });
            }
        });
    </script>
@endpush
