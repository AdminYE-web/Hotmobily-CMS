@extends('admin.layouts.app')

@section('title', 'Meeting Date detail')

@push('styles')
    <style>
        .meeting-date-detail {
            width: 100%;
            padding: 15px 9px 30px;
        }

        .meeting-date-detail__actions {
            display: flex;
            gap: 8px;
            margin-bottom: 15px;
        }

        .meeting-date-detail__back {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 4px;
            background: #808080;
            color: #fff;
            text-decoration: none;
        }

        .meeting-date-detail__back:hover {
            background: #000;
            color: #fff;
            text-decoration: none;
        }

        .meeting-date-detail h1 {
            margin: 0 0 15px;
            padding: 10px 0;
            border-bottom: 3px solid #808080;
            font-size: 28px;
            line-height: 1.25;
        }

        .meeting-date-detail h2 {
            margin: 22px 0 10px;
            font-size: 22px;
        }

        .meeting-date-detail__alert {
            width: min(80%, 900px);
            margin-bottom: 12px;
            padding: 10px 12px;
        }

        .meeting-date-detail__alert--success {
            border: 1px solid #c3e6cb;
            background: #d4edda;
            color: #155724;
        }

        .meeting-date-detail__alert--error {
            border: 1px solid #f5c6cb;
            background: #f8d7da;
            color: #721c24;
        }

        .meeting-date-detail__table {
            width: min(80%, 1100px);
            margin: 0;
            border: 1px solid #808080;
            border-collapse: collapse;
            table-layout: fixed;
            background: #fff;
        }

        .meeting-date-detail__table th,
        .meeting-date-detail__table td {
            border: 1px solid #808080;
            padding: 8px;
            vertical-align: top;
            overflow-wrap: anywhere;
            text-align: left;
        }

        .meeting-date-detail__table th {
            width: 25%;
            background: #6fb4ff;
            color: #000;
            font-weight: 600;
        }

        .meeting-date-detail__table td {
            width: 75%;
        }

        .meeting-date-detail__table pre {
            margin: 0;
            white-space: pre-wrap;
            overflow-wrap: anywhere;
            font: inherit;
        }

        .meeting-date-detail__status {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
        }

        .meeting-date-detail__status select {
            width: auto;
            min-width: 170px;
            height: 35px;
            padding: 4px 8px;
            border: 1px solid #808080;
            border-radius: 0;
        }

        .meeting-date-detail__status button {
            padding: 6px 15px;
            border: 0;
            border-radius: 4px;
            background: #d82234;
            color: #fff;
            cursor: pointer;
        }

        .meeting-date-detail__status button:hover {
            background: #a91a28;
        }

        .meeting-date-detail__mail-error {
            color: #a40000;
            white-space: pre-wrap;
        }

        @media (max-width: 640px) {
            .meeting-date-detail {
                padding-right: 10px;
                padding-left: 10px;
            }

            .meeting-date-detail__table,
            .meeting-date-detail__alert {
                width: 100%;
            }

            .meeting-date-detail h1 {
                font-size: 24px;
            }

            .meeting-date-detail h2 {
                font-size: 20px;
            }

            .meeting-date-detail__table th {
                width: 34%;
            }

            .meeting-date-detail__table td {
                width: 66%;
            }
        }
    </style>
@endpush

@section('content')
    @php
        $value = static fn (string $key, string $fallback = '-') => filled(data_get($record, $key))
            ? data_get($record, $key)
            : $fallback;
        $formatDate = static function ($date, string $format = 'Y-m-d H:i'): string {
            if (blank($date)) {
                return '-';
            }

            return \Carbon\Carbon::parse($date)->format($format);
        };
        $rows = [
            'ID' => 'id',
            'Created' => 'date_create',
            'Modified' => 'date_modify',
            'Contact type' => 'cont_type',
            'Company name' => 'company_name',
            'Person name' => 'person_name',
            'Department' => 'department',
            'Postal code' => 'zip',
            'Prefecture' => 'prefc',
            'Address' => 'address',
            'Address / building' => 'address_street',
            'Phone number' => 'phone_number',
            'Email' => 'email',
            'Email confirmation' => 'email_confirm',
            'Expected product' => 'expected_product',
            'Quantity' => 'qty',
            'Expected price' => 'expected_price',
            'Expected delivery date' => 'expected_delivery_date',
            'First preferred date' => 'visit_date_1',
            'First preferred time' => 'visit_time_1',
            'Second preferred date' => 'visit_date_2',
            'Second preferred time' => 'visit_time_2',
        ];
    @endphp

    <main class="meeting-date-detail">
        <div class="meeting-date-detail__actions">
            <a href="{{ route('admin.meeting-date.index') }}" class="meeting-date-detail__back">&lt; back</a>
        </div>

        @if (session('success'))
            <div class="meeting-date-detail__alert meeting-date-detail__alert--success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="meeting-date-detail__alert meeting-date-detail__alert--error">
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1>Meeting Date: {{ $record->id }}</h1>

        <table class="meeting-date-detail__table">
            <tbody>
                <tr>
                    <th>Status</th>
                    <td>
                        <form method="POST" action="{{ route('admin.meeting-date.status.update', ['meetingDate' => $record->id]) }}" class="meeting-date-detail__status">
                            @csrf
                            @method('PUT')
                            <select name="status">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}" @selected($record->status === $status)>{{ $status }}</option>
                                @endforeach
                            </select>
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
                @foreach ($rows as $label => $key)
                    <tr>
                        <th>{{ $label }}</th>
                        <td>
                            @if (in_array($key, ['date_create', 'date_modify'], true))
                                {{ $formatDate($record->{$key}) }}
                            @elseif ($key === 'expected_delivery_date' || str_starts_with($key, 'visit_date_'))
                                {{ $formatDate($record->{$key}, 'Y-m-d') }}
                            @elseif ($key === 'email' && filled($record->{$key}))
                                <a href="mailto:{{ $record->{$key} }}">{{ $record->{$key} }}</a>
                            @else
                                {{ $value($key) }}
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th>Contact detail</th>
                    <td><pre>{{ $value('contact_detail') }}</pre></td>
                </tr>
                <tr>
                    <th>Mail sent at</th>
                    <td>{{ $formatDate($record->mail_sent_at) }}</td>
                </tr>
                @if (filled($record->mail_error))
                    <tr>
                        <th>Mail error</th>
                        <td class="meeting-date-detail__mail-error">{{ $record->mail_error }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </main>
@endsection
