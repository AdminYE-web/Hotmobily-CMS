@extends('admin.layouts.app')

@section('title', 'Confirm reply email')

@push('styles')
    <style>
        .contact-reply-confirm {
            padding-top: 10px;
        }

        .contact-reply-confirm__table {
            width: 80%;
            margin: 10px 0;
            border-collapse: collapse;
            border: 1px solid gray;
            table-layout: fixed;
            line-height: 1.5;
            background: #fff;
            box-shadow: 5px 5px 3px grey;
        }

        .contact-reply-confirm__table td {
            border: 1px solid gray;
            padding: 8px;
            background: #fff;
            color: #000;
            vertical-align: top;
            text-align: left !important;
            overflow-wrap: anywhere;
        }

        .contact-reply-confirm__table td:first-child {
            width: 20%;
        }

        .contact-reply-confirm__table pre {
            margin: 0;
            white-space: pre-wrap;
            overflow-wrap: anywhere;
            font: inherit;
        }

        .contact-reply-confirm__actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .contact-reply-confirm__actions form {
            margin: 0;
        }

        .contact-reply-confirm__button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 85px;
            height: 35px;
            padding: 5px;
            border: 2px solid #000;
            border-radius: 5px;
            background: #fff;
            color: #000;
            font-size: 14px;
            line-height: 1;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            box-sizing: border-box;
        }

        .contact-reply-confirm__button:hover,
        .contact-reply-confirm__button:focus {
            background: #f2f2f2;
            color: #000;
            text-decoration: none;
        }

        @media screen and (max-width: 768px) {
            .contact-reply-confirm__table {
                width: 100%;
            }

            .contact-reply-confirm__table td:first-child {
                width: 25%;
            }
        }
    </style>
@endpush

@section('content')
    <main class="container-fluid contact-reply-confirm">
        <table class="contact-reply-confirm__table">
            <tbody>
                <tr>
                    <td>Subject</td>
                    <td>{{ $draft['subject'] }}</td>
                </tr>
                <tr>
                    <td>Sale's name</td>
                    <td>{{ $draft['sale'] }}</td>
                </tr>
                <tr>
                    <td>Content</td>
                    <td><pre>{{ $body }}</pre></td>
                </tr>
                <tr>
                    <td>file upload</td>
                    <td>
                        @if (! empty($draft['attachments']))
                            @foreach ($draft['attachments'] as $attachment)
                                <div>{{ $attachment['original_name'] ?? basename($attachment['path'] ?? '') }}</div>
                            @endforeach
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="contact-reply-confirm__actions">
                            <a href="{{ route('admin.contact.show', ['contact' => $contact->id]) }}" class="contact-reply-confirm__button">BACK</a>
                            <form method="POST" action="{{ route('admin.contact.reply.send', ['contact' => $contact->id]) }}">
                                @csrf
                                <button type="submit" class="contact-reply-confirm__button">NEXT</button>
                            </form>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>
@endsection
