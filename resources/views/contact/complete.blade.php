@extends('layouts.product')

@section('head')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="robots" content="noindex,nofollow">
    <title>お問い合わせありがとうございます | HOTMOBILY</title>
    @include('partials.legacy-head-products')

    <style>
        .contact-complete {
            width: 100%;
            color: #281600;
            font-size: 14px;
            line-height: 1.8;
        }

        .contact-complete__box {
            padding: 28px 24px 32px;
            border: 1px solid #f07800;
            background: #fff;
            text-align: center;
        }

        .contact-complete h1 {
            margin: 0 0 22px;
            padding: 0;
            background: transparent;
            color: #111;
            font-size: 28px;
            line-height: 1.35;
        }

        .contact-complete p {
            margin: 10px 0;
            text-align: left;
        }

        .contact-complete__id {
            margin: 22px 0;
            padding: 10px 12px;
            background: #fff3e7;
            color: #7a3d00;
            font-weight: bold;
            text-align: center;
        }

        .contact-complete__warning {
            margin: 14px 0;
            padding: 8px 10px;
            border: 1px solid #e6a6a6;
            background: #fff0f0;
            color: #b40000;
            text-align: left;
        }

        .contact-complete__home {
            display: inline-block;
            min-width: 260px;
            margin-top: 18px;
            padding: 8px 18px;
            border-radius: 4px;
            background: #f58216;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
        }

        @media screen and (max-width: 768px) {
            .contact-complete__box {
                padding: 20px 14px 24px;
            }

            .contact-complete h1 {
                font-size: 23px;
            }

            .contact-complete__home {
                width: 100%;
                min-width: 0;
                box-sizing: border-box;
            }
        }
    </style>
@endsection

@section('content')
    <div class="contact-complete">
        <div class="contact-complete__box">
            <h1>お問い合わせありがとうございます</h1>
            <p>お問い合わせを受け付けました。</p>
            <p>ご入力いただいたメールアドレスに受付内容をお送りいたします。</p>
            <p>確認メールが届かない場合は、迷惑メールフォルダをご確認のうえ、<a href="mailto:contact@hotmobily.jp">contact@hotmobily.jp</a>までご連絡ください。</p>

            @if ($mailError)
                <div class="contact-complete__warning">{{ $mailError }}</div>
            @endif

            <div class="contact-complete__id">受付番号：{{ $contactId }}</div>
            <p>この受付番号は、お問い合わせ内容についてご連絡いただく際にご利用ください。</p>
            <a class="contact-complete__home" href="{{ url('/') }}">トップページへ</a>
        </div>
    </div>
@endsection
