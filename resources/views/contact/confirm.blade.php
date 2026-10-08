@extends('layouts.product')

@section('head')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="robots" content="noindex,nofollow">
    <title>ご入力内容確認::お問い合わせフォーム::オリジナル携帯ストラップ製作ホットモバイリー</title>
    @include('partials.legacy-head-products')
    <link rel="stylesheet" href="{{ asset('css/contact_2nd.css') }}" type="text/css">

    <style>
        .contact-confirm {
            width: 100%;
            color: #281600;
            font-size: 13.6px;
            line-height: normal;
        }

        .contact-confirm h1 {
            width: 100%;
            height: 35px;
            margin: 0;
            padding: 3px 3px 3px 10px;
            border: 0;
            background: #f58904;
            color: #fff;
            font-size: 20px;
            line-height: 29px;
            box-sizing: border-box;
        }

        .contact-confirm h2 {
            margin: 3px 0 8px;
            padding: 0;
            border: 0;
            color: #000;
            font-size: 14px;
            font-weight: normal;
            line-height: 22px;
        }

        .contact-confirm__table {
            width: 100%;
            margin: 0 0 10px;
            padding: 0;
            border: 1px solid lightgray;
            border-collapse: separate;
            border-spacing: 2px;
            background: #fff;
            table-layout: fixed;
        }

        .contact-confirm__table th,
        .contact-confirm__table td {
            padding: 5px 10px;
            border: 0;
            vertical-align: middle;
            text-align: left;
            font-weight: normal;
            line-height: 200%;
            box-sizing: border-box;
            overflow-wrap: anywhere;
        }

        .contact-confirm__table th {
            width: 30%;
            background: #f0f0f0;
            color: #000;
        }

        .contact-confirm__table td {
            width: 70%;
            background: #fff;
            color: #000;
        }

        .contact-confirm__multiline {
            white-space: normal;
        }

        .contact-confirm__reference-image {
            margin-top: 10px;
            text-align: center;
        }

        .contact-confirm__reference-image img {
            width: 250px;
            max-width: 100%;
            height: auto;
        }

        .contact-confirm__actions {
            display: flex;
            align-items: stretch;
            justify-content: space-between;
            gap: 0;
            width: 100%;
            margin: 24px 0 8px;
        }

        .contact-confirm__actions form {
            display: flex;
            flex: 0 0 35%;
            margin: 0;
        }

        .contact-confirm__button {
            display: inline-flex;
            flex: 0 0 35%;
            align-items: center;
            justify-content: center;
            width: 35%;
            height: 49px;
            min-width: 0;
            padding: 0;
            border: 1px solid #000;
            border-radius: 4px;
            cursor: pointer;
            font: inherit;
            font-size: 12px;
            font-weight: bold;
            line-height: 1;
            text-align: center;
            text-decoration: none;
            box-sizing: border-box;
        }

        .contact-confirm__actions form .contact-confirm__button {
            width: 100%;
            flex-basis: 100%;
        }

        .contact-confirm__button--back {
            background: linear-gradient(#fff, #ededed);
            color: #000;
        }

        .contact-confirm__button--send {
            border-color: #1e6077;
            background: #1e6077;
            color: #fff;
        }

        .contact-confirm__button:hover {
            opacity: .86;
        }

        @media screen and (max-width: 768px) {
            .contact-confirm {
                font-size: 13px;
            }

            .contact-confirm h1 {
                font-size: 19px;
            }

            .contact-confirm h2 {
                font-size: 14px;
            }

            .contact-confirm__table th,
            .contact-confirm__table td {
                padding: 5px 7px;
            }
        }

        @media screen and (max-width: 576px) {
            .contact-confirm__actions {
                flex-direction: row;
                gap: 4%;
            }

            .contact-confirm__actions form,
            .contact-confirm__button {
                flex-basis: 48%;
                width: 48%;
            }

            .contact-confirm__actions form .contact-confirm__button {
                width: 100%;
                flex-basis: 100%;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $isSample = (string) ($form['sndKBN'] ?? '0') === '1';
        $customerType = match ($form['cstKBN'] ?? 'Corp') {
            'Personal' => '個人のお客様',
            'Other' => 'その他の区分のお客様',
            default => '法人のお客様',
        };
        $inquiryType = $isSample
            ? trim((string) ($form['ItemType'] ?? '')).'の無料サンプル希望'
            : '問い合わせ';
        $uploadedFiles = is_array($form['uploaded_files'] ?? null) ? $form['uploaded_files'] : [];
    @endphp

    <div class="contact-confirm">
        <h1>お問い合わせ・サンプル請求</h1>

        <h2>1.お問い合わせ区分</h2>
        <table class="contact-confirm__table">
            <tbody>
                <tr>
                    <th>問い合わせ区分を選択</th>
                    <td>{{ $inquiryType }}</td>
                </tr>
            </tbody>
        </table>

        <h2>2.お客様情報の入力</h2>
        <table class="contact-confirm__table">
            <tbody>
                <tr>
                    <th>メールアドレス</th>
                    <td>{{ $form['email'] ?? '' }}</td>
                </tr>
                <tr>
                    <th>お名前</th>
                    <td>{{ $form['Name_S'] ?? '' }}</td>
                </tr>
                <tr>
                    <th>フリガナ</th>
                    <td>{{ $form['Name_S_K'] ?? '' }}</td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td>{{ $form['tel'] ?? '' }}</td>
                </tr>
                <tr>
                    <th>お客様区分</th>
                    <td>{{ $customerType }}</td>
                </tr>
                <tr>
                    <th>法人名</th>
                    <td>{{ $form['Corp_Name'] ?? '' }}</td>
                </tr>
                <tr>
                    <th>法人名（フリガナ）</th>
                    <td>{{ $form['Corp_Name_K'] ?? '' }}</td>
                </tr>
                <tr>
                    <th>お客様部署名</th>
                    <td>{{ $form['dev'] ?? '' }}</td>
                </tr>
                <tr>
                    <th>お問い合わせ内容</th>
                    <td class="contact-confirm__multiline">
                        {!! nl2br(e((string) ($form['contactDetail'] ?? ''))) !!}
                        @if (filled($form['sample_pic'] ?? null))
                            <div class="contact-confirm__reference-image">
                                <img src="{{ $form['sample_pic'] }}" alt="お問い合わせ対象の参考画像">
                            </div>
                        @endif
                    </td>
                </tr>
                @forelse ($uploadedFiles as $file)
                    <tr>
                        <th>お客様ファイル名</th>
                        <td>{{ $file['name'] ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>当店管理ファイル名</th>
                        <td>{{ $file['stored_name'] ?? '' }}</td>
                    </tr>
                @empty
                    <tr>
                        <th>お客様ファイル名</th>
                        <td>なし</td>
                    </tr>
                    <tr>
                        <th>当店管理ファイル名</th>
                        <td>なし</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if ($isSample)
            <h2>3.サンプル送付先情報の入力</h2>
            <table class="contact-confirm__table">
                <tbody>
                    <tr>
                        <th>郵便番号</th>
                        <td>{{ $form['zip'] ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>都道府県</th>
                        <td>{{ $form['prefc'] ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>以降の住所</th>
                        <td>{{ $form['address'] ?? '' }}</td>
                    </tr>
                    <tr>
                        <th>番地、建物名、部屋番号</th>
                        <td>{{ $form['address_street'] ?? '' }}</td>
                    </tr>
                </tbody>
            </table>
        @endif

        <div class="contact-confirm__actions">
            <a class="contact-confirm__button contact-confirm__button--back" href="{{ route('contact.index', ['mode' => 'MODE_MOD']) }}">戻る</a>
            <form action="{{ route('contact.complete') }}" method="post">
                @csrf
                <button class="contact-confirm__button contact-confirm__button--send" type="submit">送信</button>
            </form>
        </div>
    </div>
@endsection
