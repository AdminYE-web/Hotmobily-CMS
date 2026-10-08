@extends('admin.layouts.app')

@section('title', 'Meeting Date')

@push('styles')
    <style>
        .meeting-date-admin {
            padding: 15px 9px 30px;
        }

        .meeting-date-admin__search {
            margin-bottom: 24px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .12);
        }

        .meeting-date-admin__search h1 {
            margin: 0 0 18px;
            font-size: 24px;
            font-weight: 500;
        }

        .meeting-date-admin__grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px 20px;
        }

        .meeting-date-admin__grid input,
        .meeting-date-admin__grid select {
            width: 100%;
            height: 40px;
            padding: 6px 10px;
            border: 1px solid #aaa;
            border-radius: 0;
            background: #fff;
            color: #333;
        }

        .meeting-date-admin__actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 16px;
        }

        .meeting-date-admin__button {
            min-width: 120px;
            padding: 9px 18px;
            border: 0;
            border-radius: 3px;
            color: #fff;
            cursor: pointer;
        }

        .meeting-date-admin__button--search {
            background: #0879d1;
        }

        .meeting-date-admin__button--clear {
            background: #858585;
        }

        .meeting-date-admin__warning,
        .meeting-date-admin__empty {
            padding: 18px;
            border: 1px solid #d7dce1;
            background: #fff;
        }

        .meeting-date-admin__warning {
            margin-bottom: 18px;
            border-color: #f0c36d;
            background: #fff8e5;
        }

        .meeting-date-admin__table-wrap {
            overflow-x: auto;
            background: #fff;
        }

        .meeting-date-admin__table {
            width: 100%;
            margin: 0;
            border: 1px solid #808080;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .meeting-date-admin__table th,
        .meeting-date-admin__table td {
            border: 1px solid #808080;
            padding: 9px 10px;
            vertical-align: middle;
            text-align: left;
        }

        .meeting-date-admin__table th {
            background: #99bcdd;
            color: #fff;
            text-align: center;
        }

        .meeting-date-admin__table tbody tr:hover {
            background: #eef6ff;
        }

        .meeting-date-admin__table a {
            color: #075aa6;
            text-decoration: none;
        }

        .meeting-date-admin__table a:hover {
            text-decoration: underline;
        }

        .meeting-date-admin__table td {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        @media (max-width: 900px) {
            .meeting-date-admin__grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 576px) {
            .meeting-date-admin__grid {
                grid-template-columns: 1fr;
            }

            .meeting-date-admin__actions {
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    @php
        $formatDate = static function ($date): string {
            if (blank($date)) {
                return '-';
            }

            return \Carbon\Carbon::parse($date)->format('Y-m-d H:i');
        };
    @endphp

    <main class="meeting-date-admin">
        @if (! $tableReady)
            <div class="meeting-date-admin__warning">
                The meeting date table is not available. Run <code>php artisan migrate</code> first.
            </div>
        @endif

        <form method="GET" action="{{ route('admin.meeting-date.index') }}" class="meeting-date-admin__search">
            <h1>Meeting Date</h1>

            <div class="meeting-date-admin__grid">
                <input type="text" name="id" value="{{ $filters['id'] ?? '' }}" placeholder="ID">
                <input type="text" name="email" value="{{ $filters['email'] ?? '' }}" placeholder="Email">
                <input type="text" name="company_name" value="{{ $filters['company_name'] ?? '' }}" placeholder="Company name">
                <input type="text" name="person_name" value="{{ $filters['person_name'] ?? '' }}" placeholder="Person name">
                <input type="text" name="cont_type" value="{{ $filters['cont_type'] ?? '' }}" placeholder="Contact type">
                <select name="status">
                    <option value="">Status</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" aria-label="Date from">
                <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" aria-label="Date to">
            </div>

            <div class="meeting-date-admin__actions">
                <button type="submit" class="meeting-date-admin__button meeting-date-admin__button--search">Search</button>
                <button type="submit" name="clear" value="1" class="meeting-date-admin__button meeting-date-admin__button--clear">Clear</button>
            </div>
        </form>

        @if ($meetingDates->isEmpty())
            <div class="meeting-date-admin__empty">No meeting date requests found.</div>
        @else
            <div class="meeting-date-admin__table-wrap">
                <table class="meeting-date-admin__table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>ID</th>
                            <th>Company</th>
                            <th>Person</th>
                            <th>Contact type</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($meetingDates as $meetingDate)
                            <tr>
                                <td>{{ $formatDate($meetingDate->date_create) }}</td>
                                <td>
                                    <a href="{{ route('admin.meeting-date.show', ['meetingDate' => $meetingDate->id]) }}">
                                        {{ $meetingDate->id }}
                                    </a>
                                </td>
                                <td>{{ $meetingDate->company_name ?: '-' }}</td>
                                <td>{{ $meetingDate->person_name ?: '-' }}</td>
                                <td>{{ $meetingDate->cont_type ?: '-' }}</td>
                                <td>{{ $meetingDate->email ?: '-' }}</td>
                                <td>{{ $meetingDate->status ?: '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </main>
@endsection
