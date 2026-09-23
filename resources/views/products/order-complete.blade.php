@extends('layouts.product')

@section('head')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>ご注文完了 - {{ $product->name }}</title>
    <meta name="robots" content="noindex,nofollow">
    @include('partials.legacy-head-products')
    <link rel="stylesheet" href="/css/order_2nd.css?v=1.01" type="text/css">
    <style>
        #content_wrapper .order-complete-page {
            box-sizing: border-box;
            width: 771px;
            max-width: 100%;
            margin: 15px 0 40px;
            border: 1px solid #ff8000;
            border-radius: 5px;
            padding: 10px;
            color: #281600;
        }

        #content_wrapper .order-complete-page h2 {
            margin: 0 0 12px !important;
            color: #000;
            font-size: 25px;
            text-align: center;
        }

        #content_wrapper .order-complete-page p {
            margin: 0 0 12px;
            padding: 0 10px;
        }

        #content_wrapper .order-complete-page .complete-home-link {
            display: block;
            width: 50%;
            box-sizing: border-box;
            margin: 16px auto 0;
            padding: 5px;
            border-radius: 5px;
            background: #ff8000;
            color: #fff;
            font-size: 20px;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
        }
    </style>
@endsection

@section('content')
    <main class="order-complete-page" id="inq">
        <h2>ご注文ありがとうございます</h2>
        <p>ご注文ありがとうございます。</p>
        <p>ご注文内容をご登録のメールアドレスにお送り致しました。</p>
        <p>確認メールが届かない場合、迷惑メールに分類されていないかご確認の上、</p>
        <p><a href="mailto:contact@hotmobily.jp">contact@hotmobily.jp</a>にその旨をご連絡頂くか、TEL: <a href="tel:+8105068655591">050-6865-5591</a>まで</p>
        <p>お電話にてお知らせください。</p>
        <p>ご注文番号：{{ $orderNumber }}</p>
        <p>データ入稿がお済でない場合、<a href="mailto:contact@hotmobily.jp">contact@hotmobily.jp</a>までデータをお送りください。</p>
        <a class="complete-home-link" href="{{ route('home') }}">トップページへ</a>
    </main>
@endsection
