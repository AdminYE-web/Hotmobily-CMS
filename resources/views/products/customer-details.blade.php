@extends('layouts.product')

@php
    $customer = is_array($orderPayload['customer'] ?? null) ? $orderPayload['customer'] : [];
    $addressMethod = old('customer.address_method', $customer['address_method'] ?? '');
    $customerType = old('customer.cstKBN', $customer['cstKBN'] ?? 'Corp');
    $deliveryType = old('customer.delivery_type', $customer['delivery_type'] ?? 'same');
    $customerFiles = collect($orderPayload['customer_files'] ?? [])
        ->filter(static fn ($file): bool => is_array($file) && trim((string) ($file['name'] ?? '')) !== '')
        ->values();
    $prefectures = [
        '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県',
        '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県',
        '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県',
        '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県',
        '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県',
        '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県',
        '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県',
    ];
@endphp

@section('head')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>お客様情報入力 - {{ $product->name }}</title>
    <meta name="robots" content="noindex,nofollow">
    <link rel="canonical" href="{{ route('products.customer', ['productPath' => $product->slug]) }}">
    @include('partials.legacy-head-products')
    <link rel="stylesheet" href="/css/order_2nd.css?v=1.01" type="text/css">
    <link rel="stylesheet" href="/products/css/box-shadow.css" type="text/css">

    @if ($product->slug === 'rubberstrap')
        <link rel="stylesheet" href="/css/homepage_hotstrap.css" type="text/css">
        <link rel="stylesheet" href="/products/css/product_group.css?v=1.14" type="text/css">
        <link rel="stylesheet" href="/products/acrylic/css/renew_products.css?v=1.163" type="text/css">
        <link rel="stylesheet" href="/products/css/box.css" type="text/css">
        <link rel="stylesheet" href="/css/rubber.css?v=1.06" type="text/css">
    @endif

    <style>
        #content_wrapper .customer-details-page {
            box-sizing: border-box;
            width: 771px;
            max-width: 100%;
            margin: 0 0 40px;
            color: #281600;
            font-size: 13.6px;
            line-height: 1.45;
        }

        #content_wrapper .customer-details-page h3.customer-section-title {
            margin: 12px 0 5px;
            padding: 0;
            color: #f00;
            font-size: 16px;
            line-height: 1.45;
        }

        #content_wrapper .customer-details-page .customer-alert {
            box-sizing: border-box;
            margin: 5px;
            padding: 5px 30px;
            background: #f00;
            color: #fff;
            font-size: 15px;
            line-height: 1.5;
        }

        #content_wrapper .customer-details-page .customer-alert p {
            margin: 0;
        }

        #content_wrapper .customer-details-page .customer-alert--saved {
            background: #eaf7ea;
            color: #126b12;
            border: 1px solid #75b975;
            font-size: 14px;
        }

        #content_wrapper .customer-details-page .customer-table {
            width: 100%;
            margin: 10px 0;
            border: 1px solid lightgray;
            border-collapse: collapse;
            background: #fff;
        }

        #content_wrapper .customer-details-page .customer-table td {
            box-sizing: border-box;
            padding: 3px 5px;
            border: 1px solid lightgray;
            vertical-align: middle;
        }

        #content_wrapper .customer-details-page .customer-table .customer-field-cell {
            width: 100%;
            padding: 3px 5px;
            background: #f4f4f4;
        }

        #content_wrapper .customer-details-page .customer-input-wrap {
            position: relative;
            width: 100%;
        }

        #content_wrapper .customer-details-page input[type="text"],
        #content_wrapper .customer-details-page input[type="email"],
        #content_wrapper .customer-details-page input[type="tel"],
        #content_wrapper .customer-details-page input[type="number"],
        #content_wrapper .customer-details-page select,
        #content_wrapper .customer-details-page textarea {
            box-sizing: border-box;
            width: 96%;
            min-height: 32px;
            margin: 0;
            padding: 6px 10px;
            border: 1px solid #999;
            border-radius: 2px;
            outline: none;
            background: #fff;
            color: #281600;
            font: inherit;
            letter-spacing: inherit;
        }

        #content_wrapper .customer-details-page input[type="text"]:focus,
        #content_wrapper .customer-details-page input[type="email"]:focus,
        #content_wrapper .customer-details-page input[type="tel"]:focus,
        #content_wrapper .customer-details-page input[type="number"]:focus,
        #content_wrapper .customer-details-page select:focus,
        #content_wrapper .customer-details-page textarea:focus {
            border-color: #555;
            box-shadow: 0 0 0 1px #555;
        }

        #content_wrapper .customer-details-page input:required:invalid,
        #content_wrapper .customer-details-page select:required:invalid {
            background: #ffe5e5;
        }

        #content_wrapper .customer-details-page input:required:valid,
        #content_wrapper .customer-details-page select:required:valid {
            background: #fff;
        }

        #content_wrapper .customer-details-page .customer-input-wrap input,
        #content_wrapper .customer-details-page .customer-input-wrap select {
            padding-right: 58px;
        }

        #content_wrapper .customer-details-page .customer-required {
            position: absolute;
            top: 3px;
            right: 2%;
            display: block;
            padding: 6px 7px;
            background: #ee4d4d;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            line-height: 20px;
        }

        #content_wrapper .customer-details-page .customer-table--method {
            margin-top: 10px;
        }

        #content_wrapper .customer-details-page .customer-method-cell {
            padding: 7px 10px;
        }

        #content_wrapper .customer-details-page .customer-method-title {
            margin: 0 0 5px;
            color: #281600;
            font-size: 15px;
            font-weight: 700;
        }

        #content_wrapper .customer-details-page .customer-method-help {
            margin: 4px 0 0;
            color: #555;
            font-size: 12px;
        }

        #content_wrapper .customer-details-page .customer-method-help a {
            color: #06c;
        }

        #content_wrapper .customer-details-page .customer-detail-section[hidden],
        #content_wrapper .customer-details-page .customer-message-section[hidden],
        #content_wrapper .customer-details-page .customer-delivery-fields[hidden],
        #content_wrapper .customer-details-page [data-customer-file-list][hidden] {
            display: none !important;
        }

        #content_wrapper .customer-details-page .customer-subtitle {
            margin: 12px 0 5px;
            padding: 0;
            color: #f00;
            font-size: 16px;
            line-height: 1.45;
        }

        #content_wrapper .customer-details-page .customer-radio-row {
            padding: 8px 10px;
            background: #fff;
        }

        #content_wrapper .customer-details-page .customer-radio-group {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px 18px;
        }

        #content_wrapper .customer-details-page .customer-radio-label {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            white-space: nowrap;
        }

        #content_wrapper .customer-details-page input[type="radio"],
        #content_wrapper .customer-details-page input[type="checkbox"] {
            width: 17px;
            height: 17px;
            margin: 0;
        }

        #content_wrapper .customer-details-page .customer-postal-row {
            display: flex;
            align-items: center;
            gap: 5px;
            width: 96%;
        }

        #content_wrapper .customer-details-page .customer-postal-row input {
            flex: 1 1 auto;
            width: auto;
        }

        #content_wrapper .customer-details-page .customer-address-button {
            flex: 0 0 auto;
            min-height: 32px;
            padding: 5px 10px;
            border: 1px solid #777;
            border-radius: 2px;
            background: #eee;
            color: #111;
            cursor: pointer;
            font: inherit;
        }

        #content_wrapper .customer-details-page .customer-address-button:hover {
            background: #ddd;
        }

        #content_wrapper .customer-details-page .customer-address-button:disabled {
            cursor: wait;
            opacity: .65;
        }

        #content_wrapper .customer-details-page .customer-error {
            display: block;
            color: #f00;
            font-size: 12px;
        }

        #content_wrapper .customer-details-page .customer-file-dropzone {
            position: relative;
            box-sizing: border-box;
            min-height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            padding: 20px;
            border: 2px solid #b7b7b7;
            background: #fff;
            color: #281600;
            text-align: center;
            cursor: pointer;
            transition: border-color .2s ease, background-color .2s ease;
        }

        #content_wrapper .customer-details-page .customer-file-dropzone:hover,
        #content_wrapper .customer-details-page .customer-file-dropzone.is-dragging {
            border-color: #5793c7;
            background: #f2f8ff;
        }

        #content_wrapper .customer-details-page .customer-file-dropzone input[type="file"] {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
        }

        #content_wrapper .customer-details-page .customer-upload-folder {
            position: relative;
            flex: 0 0 auto;
            width: 50px;
            height: 37px;
            border-radius: 3px;
            background: linear-gradient(#83b8e3 0 27%, #5d9bd2 28% 100%);
            box-shadow: inset 0 0 0 1px #4c86b9, 0 2px 3px rgba(0, 0, 0, .2);
        }

        #content_wrapper .customer-details-page .customer-upload-folder::before {
            position: absolute;
            top: -5px;
            left: 4px;
            width: 21px;
            height: 8px;
            border-radius: 3px 3px 0 0;
            background: #83b8e3;
            content: "";
        }

        #content_wrapper .customer-details-page .customer-upload-folder-image {
            width: 60px;
            height: auto;
            flex: 0 0 auto;
        }

        #content_wrapper .customer-details-page .customer-upload-text {
            max-width: 500px;
            font-size: 13px;
        }

        #content_wrapper .customer-details-page .customer-file-list {
            margin: 0;
            padding: 7px 10px;
            background: #f4f4f4;
            color: #281600;
            list-style: none;
        }

        #content_wrapper .customer-details-page .customer-file-list li {
            padding: 2px 0;
        }

        #content_wrapper .customer-details-page .customer-file-list li::before {
            margin-right: 6px;
            color: #777;
            content: "・";
        }

        #content_wrapper .customer-details-page .customer-notes {
            margin: 5px 0 10px;
            line-height: 1.55;
        }

        #content_wrapper .customer-details-page .customer-notes .red {
            color: #f00;
        }

        #content_wrapper .customer-details-page textarea {
            width: 98%;
            min-height: 125px;
            resize: vertical;
        }

        #content_wrapper .customer-details-page .customer-button-row {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin: 18px 0 0;
            text-align: center;
        }

        #content_wrapper .customer-details-page .customer-button {
            box-sizing: border-box;
            min-width: 190px;
            min-height: 48px;
            padding: 10px 18px;
            border: 1px solid #1e6077;
            border-radius: 2px;
            color: #fff !important;
            cursor: pointer;
            font: inherit;
            font-weight: 700;
            line-height: 1.2;
            text-align: center;
            text-decoration: none !important;
        }

        #content_wrapper .customer-details-page .customer-button--back {
            border-color: #111;
            background: #fff;
            color: #111 !important;
        }

        #content_wrapper .customer-details-page .customer-button--next {
            background: #cc3f44;
        }

        #content_wrapper .customer-details-page .customer-button:hover {
            opacity: .78;
        }

        #content_wrapper .customer-details-page .customer-small-note {
            margin: 5px 0;
            color: #555;
            font-size: 12px;
        }

        @media screen and (max-width: 768px) {
            #content_wrapper .customer-details-page {
                width: 100%;
            }

            #content_wrapper .customer-details-page .customer-alert {
                margin-right: 0;
                margin-left: 0;
                padding-right: 10px;
                padding-left: 10px;
            }

            #content_wrapper .customer-details-page .customer-postal-row {
                width: 100%;
            }

            #content_wrapper .customer-details-page input[type="text"],
            #content_wrapper .customer-details-page input[type="email"],
            #content_wrapper .customer-details-page input[type="tel"],
            #content_wrapper .customer-details-page input[type="number"],
            #content_wrapper .customer-details-page select {
                width: 100%;
            }

            #content_wrapper .customer-details-page .customer-button {
                min-width: 0;
                flex: 1 1 0;
            }
        }

        /*
         * Legacy parity overrides. These values mirror input2_rubber.php and
         * intentionally win over the generic product-page form styles above.
         */
        #content_wrapper .customer-details-page.tableAllOrder {
            width: 771px;
            max-width: 100%;
            margin: 0;
            padding: 0;
            text-align: left;
        }

        #content_wrapper .customer-details-page h3.customer-section-title,
        #content_wrapper .customer-details-page h3.customer-subtitle {
            margin: 0;
            padding: 0;
            color: #f00;
            font-size: 16px;
            line-height: normal;
        }

        #content_wrapper .customer-details-page .legacy-red-notice {
            margin: 5px;
            padding: 5px 30px;
            background: red;
            color: #fff;
            font-size: 15px;
            line-height: normal;
        }

        #content_wrapper .customer-details-page .customer-table.TableAllL {
            box-sizing: border-box;
            width: 100% !important;
            margin: 10px 0;
            padding: 0;
            border: 1px solid lightgray;
            border-collapse: separate;
            border-spacing: 2px;
            background: transparent;
        }

        #content_wrapper .customer-details-page .customer-table.TableAllL td,
        #content_wrapper .customer-details-page .customer-table td {
            border: 0;
        }

        #content_wrapper .customer-details-page .customer-table .customer-field-cell {
            width: auto;
            padding: 0 0 0 5px;
            background: transparent;
        }

        #content_wrapper .customer-details-page .customer-table .TableRight,
        #content_wrapper .customer-details-page .customer-table .TableRight2 {
            width: auto;
            border-bottom: 0;
            padding-left: 5px;
            text-align: left;
        }

        #content_wrapper .customer-details-page .customer-input-wrap.inputtext {
            position: relative;
            width: 100%;
        }

        #content_wrapper .customer-details-page .customer-input-wrap.inputnum {
            position: relative;
            width: 70%;
        }

        #content_wrapper .customer-details-page input[type="text"],
        #content_wrapper .customer-details-page input[type="email"],
        #content_wrapper .customer-details-page input[type="number"],
        #content_wrapper .customer-details-page input[type="tel"],
        #content_wrapper .customer-details-page select {
            box-sizing: content-box;
            width: 96%;
            min-height: 0;
            margin: 3px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            background: #fff;
            font-family: Arial, sans-serif;
            font-size: 13.3333px;
            line-height: normal;
            outline: none;
            transition: .5s;
        }

        #content_wrapper .customer-details-page input[type="number"],
        #content_wrapper .customer-details-page input[type="tel"],
        #content_wrapper .customer-details-page .inputnum input {
            width: 70% !important;
            margin-left: 0 !important;
            padding: 10px !important;
        }

        #content_wrapper .customer-details-page input:required:invalid,
        #content_wrapper .customer-details-page select:required:invalid {
            background: #ffe5e5;
            color: #757575;
        }

        #content_wrapper .customer-details-page input:required:valid,
        #content_wrapper .customer-details-page select:required:valid {
            background: #fff;
            color: #000;
        }

        #content_wrapper .customer-details-page input:disabled,
        #content_wrapper .customer-details-page select:disabled {
            background: #fff !important;
            color: #757575;
        }

        #content_wrapper .customer-details-page .customer-required {
            top: 8px;
            right: 2%;
            padding: 5px 5px 6px;
            font-size: 12px;
            line-height: normal;
        }

        #content_wrapper .customer-details-page .customer-required.inputtext-label2 {
            right: 27%;
        }

        #content_wrapper .customer-details-page .customer-required.inputtext-label3 {
            right: 8%;
        }

        #content_wrapper .customer-details-page .customer-required[hidden] {
            display: none !important;
        }

        #content_wrapper .customer-details-page .customer-method-cell {
            padding: 0 0 0 10px;
        }

        #content_wrapper .customer-details-page .customer-detail-section select,
        #content_wrapper .customer-details-page .customer-delivery-fields select {
            box-sizing: border-box;
            width: 100%;
        }

        #content_wrapper .customer-details-page .text-address-method select {
            box-sizing: border-box;
            width: 100%;
        }

        #content_wrapper .customer-details-page .customer-method-title,
        #content_wrapper .customer-details-page .customer-method-help {
            display: none;
        }

        #content_wrapper .customer-details-page h3.customer-subtitle.sun {
            color: #281600;
        }

        #content_wrapper .customer-details-page .customer-file-dropzone.dropzone {
            box-sizing: border-box;
            display: block;
            min-height: 150px;
            padding: 20px;
            border: 2px solid rgba(0, 0, 0, .3);
            border-radius: 0;
            background: #fff;
        }

        #content_wrapper .customer-details-page .customer-file-dropzone .dz-message {
            display: flex;
            min-height: 106px;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin: 0;
            text-align: center;
        }

        #content_wrapper .customer-details-page .customer-notes {
            margin: 0;
            line-height: normal;
        }

        #content_wrapper .customer-details-page textarea {
            box-sizing: border-box;
            width: 98.5% !important;
            min-height: 125px;
            padding: 5px;
            border: 2px solid #f0f0f0;
            border-radius: 5px;
        }

        #content_wrapper .customer-details-page .part-container {
            display: grid;
            width: 100%;
            margin-bottom: 10px;
        }

        #content_wrapper .customer-details-page .part-content {
            box-sizing: border-box;
            display: grid;
            width: 99%;
            margin: 10px 0;
            border: 2px solid #f0f0f0;
            border-radius: 5px;
        }

        #content_wrapper .customer-details-page label.part-name {
            position: relative;
            display: flex;
            align-items: center;
            padding: 10px 10px 10px 45px;
            color: #281600;
            font-size: 16px;
            cursor: pointer;
            user-select: none;
        }

        #content_wrapper .customer-details-page label.part-name input[type="radio"] {
            position: absolute;
            width: 0;
            height: 0;
            opacity: 0;
        }

        #content_wrapper .customer-details-page label.part-name .checkmark {
            position: absolute;
            top: 5px;
            left: 5px;
            width: 25px;
            height: 25px;
            border: 1px solid lightgray;
            border-radius: 50%;
            background: #fff;
        }

        #content_wrapper .customer-details-page label.part-name .checkmark::after {
            position: absolute;
            top: 2px;
            left: 2px;
            display: none;
            width: 21px;
            height: 21px;
            border-radius: 50%;
            background: #f7b516;
            content: "";
        }

        #content_wrapper .customer-details-page label.part-name input[type="radio"]:checked ~ .checkmark::after {
            display: block;
        }

        #content_wrapper .customer-details-page .paypal-warning {
            display: none;
            align-items: center;
            gap: 6px;
            margin-top: 5px;
            padding: 5px 8px;
            border: 1px solid #f0d6d6;
            background: #f8eeee;
            color: #555;
            font-size: 12px;
            line-height: 1.4;
        }

        #content_wrapper .customer-details-page .paypal-warning.is-visible {
            display: flex;
        }

        #content_wrapper .customer-details-page .paypal-warning img {
            width: 13px;
            height: 13px;
            object-fit: contain;
            flex-shrink: 0;
        }

        #content_wrapper .customer-details-page .customer-newsletter {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-top: 30px;
        }

        #content_wrapper .customer-details-page .customer-newsletter input[type="checkbox"] {
            width: auto;
            margin: 0 4px 0 0;
        }

        #content_wrapper .customer-details-page .customer-newsletter label {
            padding: 0;
            font-size: 16px;
        }

        #content_wrapper .customer-details-page .copyright-warning {
            margin: 10px 0;
            padding: 10px;
            border: 2px solid red;
        }

        #content_wrapper .customer-details-page .flex-item.textOrderCenter {
            width: 100%;
            max-width: 100%;
        }

        #content_wrapper .customer-details-page .btn-container {
            display: flex;
            justify-content: space-around;
            margin: 10px 0 0;
            text-align: center;
        }

        #content_wrapper .customer-details-page .btn-container .btn-back,
        #content_wrapper .customer-details-page .btn-container .btn-next {
            box-sizing: border-box;
            width: 35%;
            margin: 0;
            padding: 15px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 700;
            line-height: 1;
            text-decoration: none !important;
        }

        #content_wrapper .customer-details-page .btn-container .btn-back {
            border: 1px solid #000;
            background: linear-gradient(to bottom, #f7f8fa, #e7e9ec);
            color: #000 !important;
        }

        #content_wrapper .customer-details-page .btn-container .btn-next {
            border: 1px solid #1e6077;
            background: #1e6077;
            color: #fff !important;
        }

        @media only screen and (max-width: 841px) and (min-device-width: 320px) {
            #content_wrapper .customer-details-page input[type="text"],
            #content_wrapper .customer-details-page input[type="email"],
            #content_wrapper .customer-details-page input[type="number"],
            #content_wrapper .customer-details-page input[type="tel"],
            #content_wrapper .customer-details-page select {
                width: 96%;
            }

            #content_wrapper .customer-details-page .customer-input-wrap.inputnum {
                width: 90%;
            }

            #content_wrapper .customer-details-page input[type="number"],
            #content_wrapper .customer-details-page input[type="tel"],
            #content_wrapper .customer-details-page .inputnum input {
                width: 96% !important;
            }

            #content_wrapper .customer-details-page .customer-required.inputtext-label2 {
                right: 0;
            }

            #content_wrapper .customer-details-page textarea {
                width: 100% !important;
            }
        }
    </style>
@endsection

@section('content')
    <main class="customer-details-page tableAllOrder">
        @if (session('customer_details_saved'))
            <div class="customer-alert customer-alert--saved" role="status">
                {{ session('customer_details_saved') }}
            </div>
        @endif

        <form
            action="{{ route('products.customer.submit', ['productPath' => $product->slug]) }}"
            method="post"
            id="customer-details-form"
            enctype="multipart/form-data"
        >
            @csrf

            <h3 class="customer-section-title red">入稿ファイル（データをお待ちでないお客様は後日送付可。複数ファイル入稿可。）</h3>
            <div class="customer-alert legacy-red-notice">
                <span>※一つのデザインにつき一注文となります。</span><br>
                <span>※複数のデザインがある場合、それぞれのデザインで別々にご注文ください。</span>
            </div>

            <table class="customer-table customer-table--upload TableAllL">
                <tbody>
                    <tr>
                        <td>
                            <label class="customer-file-dropzone dropzone" for="customer-files" data-customer-file-dropzone>
                                <span class="dz-message">
                                    <img class="customer-upload-folder-image" src="{{ asset('order/img/uploaded-select.png') }}" width="60" alt="">
                                    <span class="customer-upload-text">ここにファイルをドロップするか、スマホの場合ここをタップしてください。</span>
                                </span>
                                <input
                                    id="customer-files"
                                    name="customer_files[]"
                                    type="file"
                                    multiple
                                    accept=".ai,.pdf,.doc,.xls,.jpeg,.jpg,.png,.psd,.zip,.eps"
                                    data-customer-files
                                >
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="TableLeft" colspan="2">
                            <ul class="customer-file-list" data-customer-file-list @if ($customerFiles->isEmpty()) hidden @endif>
                                @foreach ($customerFiles as $file)
                                    <li>{{ $file['name'] }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="customer-notes">
                <div class="red" data-customer-file-error></div>
                ※アップロード可能なファイル形式は、ai, pdf, doc, xls, jpeg, jpg, png, psd, zip, epsです。<br>
                ※ご入稿ファイルは1ファイルにつき最大10MBとなります。<br>
                ※入稿データは別途メールでお送り頂いても構いません。
            </div>

            <h3 class="customer-section-title red">お客様情報・配送先情報</h3>
            <div class="customer-alert legacy-red-notice">
                <span>※メールアドレスと電話番号が間違っており、ご連絡がとれない状況が多発しております。</span><br>
                <span>ご連絡に間違いないか十分にご確認ください。</span>
            </div>

            <table class="customer-table customer-table--top TableAllL">
                <tbody>
                    <tr>
                        <td class="customer-field-cell TableRight">
                            <div class="customer-input-wrap inputtext text-mail">
                                <input
                                    type="email"
                                    name="customer[email]"
                                    value="{{ old('customer.email', $customer['email'] ?? '') }}"
                                    maxlength="250"
                                    autocomplete="email"
                                    placeholder="メールアドレス"
                                    required
                                >
                                <span class="customer-required inputtext-label">必須</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="customer-field-cell TableRight">
                            <div class="customer-input-wrap inputtext text-name">
                                <input
                                    type="text"
                                    name="customer[name]"
                                    value="{{ old('customer.name', $customer['name'] ?? '') }}"
                                    maxlength="100"
                                    autocomplete="name"
                                    placeholder="お名前"
                                    required
                                >
                                <span class="customer-required inputtext-label">必須</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="customer-field-cell TableRight">
                            <div class="customer-input-wrap inputtext text-sname">
                                <input
                                    type="text"
                                    name="customer[furigana]"
                                    value="{{ old('customer.furigana', $customer['furigana'] ?? '') }}"
                                    maxlength="100"
                                    autocomplete="off"
                                    placeholder="フリガナ"
                                    required
                                >
                                <span class="customer-required inputtext-label">必須</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="customer-field-cell TableRight">
                            <div class="customer-input-wrap inputnum text-tel">
                                <input
                                    type="tel"
                                    name="customer[tel]"
                                    value="{{ old('customer.tel', $customer['tel'] ?? '') }}"
                                    maxlength="30"
                                    inputmode="tel"
                                    autocomplete="tel"
                                    placeholder="電話番号(ハイフン無し)"
                                    required
                                >
                                <span class="customer-required inputtext-label2">必須</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="customer-method-cell TableRight2">
                            <h3 class="customer-method-title title_payment">お客様・配送先情報の入力方法を選択する</h3>
                            <div class="customer-input-wrap inputtext text-address-method">
                                <span class="customer-required inputtext-label inputtext-label3">必須</span>
                                <select id="customer-address-method" name="customer[address_method]" required data-customer-address-method>
                                    <option value="" @selected($addressMethod === '')>お客様・配送先情報の入力方法選択</option>
                                    <option value="add_form" @selected($addressMethod === 'add_form')>詳細情報を全て入力する</option>
                                    <option value="none" @selected($addressMethod === 'none')>入力省略(営業より連絡します)</option>
                                    <option value="message_box" @selected($addressMethod === 'message_box')>メールの署名等をコピーする</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <section class="customer-detail-section add_form" data-customer-details @if ($addressMethod !== 'add_form') hidden @endif>
                <table class="customer-table TableAllL">
                    <tbody>
                        <tr>
                            <td class="customer-radio-row TableRight">
                                <div class="part-container cus_type">
                                    <div class="part-content" style="display: flex;">
                                    <label class="part-name" style="padding-left: 5px;">お客様区分</label>
                                    <label class="part-name">
                                        <input type="radio" name="customer[cstKBN]" value="Corp" @checked($customerType === 'Corp') data-customer-detail-field data-customer-type>
                                        法人
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="part-name">
                                        <input type="radio" name="customer[cstKBN]" value="Personal" @checked($customerType === 'Personal') data-customer-detail-field data-customer-type>
                                        個人
                                        <span class="checkmark"></span>
                                    </label>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="customer-field-cell TableRight">
                                <div class="customer-input-wrap inputtext text-Corp_Name">
                                    <span class="customer-required inputtext-label crop" data-customer-company-required>必須</span>
                                    <input type="text" name="customer[company]" value="{{ old('customer.company', $customer['company'] ?? '') }}" maxlength="100" placeholder="法人名" data-customer-detail-field data-customer-company>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="customer-field-cell TableRight">
                                <div class="customer-input-wrap inputtext text-Corp_Name_K">
                                    <span class="customer-required inputtext-label crop" data-customer-company-kana-required>必須</span>
                                    <input type="text" name="customer[company_kana]" value="{{ old('customer.company_kana', $customer['company_kana'] ?? '') }}" maxlength="100" placeholder="法人名（フリガナ）" data-customer-detail-field data-customer-company-kana>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="customer-field-cell TableRight">
                                <input type="text" name="customer[department]" value="{{ old('customer.department', $customer['department'] ?? '') }}" maxlength="100" placeholder="お客様部署名" data-customer-detail-field>
                            </td>
                        </tr>
                        <tr>
                            <td class="customer-field-cell TableRight">
                                <div class="customer-postal-row customer-input-wrap inputnum text-zip">
                                    <span class="customer-required inputtext-label2">必須</span>
                                    <input type="text" name="customer[postal_code]" value="{{ old('customer.postal_code', $customer['postal_code'] ?? '') }}" maxlength="8" inputmode="numeric" autocomplete="postal-code" placeholder="郵便番号 ハイフンなし7桁半角数字" required data-customer-detail-field data-customer-postal>
                                    <button type="button" class="customer-address-button" data-customer-address-lookup>住所に変換</button>
                                </div>
                                <span class="customer-error" data-customer-address-error></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="customer-field-cell TableRight">
                                <div class="customer-input-wrap inputtext text-prefc">
                                    <span class="customer-required inputtext-label">必須</span>
                                    <select name="customer[prefecture]" autocomplete="address-level1" required data-customer-detail-field data-customer-prefecture>
                                        <option value="">都道府県を選択</option>
                                        @foreach ($prefectures as $prefecture)
                                            <option value="{{ $prefecture }}" @selected(old('customer.prefecture', $customer['prefecture'] ?? '') === $prefecture)>{{ $prefecture }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="customer-field-cell TableRight">
                                <div class="customer-input-wrap inputtext text-address">
                                    <span class="customer-required inputtext-label">必須</span>
                                    <input type="text" name="customer[address]" value="{{ old('customer.address', $customer['address'] ?? '') }}" maxlength="255" autocomplete="address-line1" placeholder="以降の住所" required data-customer-detail-field data-customer-address>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="customer-field-cell TableRight">
                                <div class="customer-input-wrap inputtext text-address_street">
                                    <span class="customer-required inputtext-label">必須</span>
                                    <input type="text" name="customer[address_street]" value="{{ old('customer.address_street', $customer['address_street'] ?? '') }}" maxlength="255" autocomplete="address-line2" placeholder="番地、建物名、部屋番号" required data-customer-detail-field>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h3 class="customer-subtitle sun">配送先情報</h3>
                <div class="part-container cus_type">
                    <div class="part-content" style="display: flex;">
                        <label class="part-name sameAdd">
                            <input type="radio" name="customer[delivery_type]" value="same" @checked($deliveryType === 'same') data-customer-detail-field data-customer-delivery-type>
                            連絡先住所と同じ
                            <span class="checkmark"></span>
                        </label>
                        <label class="part-name">
                            <input type="radio" name="customer[delivery_type]" value="different" @checked($deliveryType === 'different') data-customer-detail-field data-customer-delivery-type>
                            下記住所へ送付する
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>

                <div class="customer-delivery-fields" data-customer-delivery-fields @if ($deliveryType !== 'different') hidden @endif>
                    <table class="customer-table TableAllL">
                        <tbody>
                            <tr>
                                <td class="customer-field-cell TableRight">
                                    <div class="customer-input-wrap inputtext text-address3">
                                        <span class="customer-required inputtext-label KBN">必須</span>
                                        <input type="text" name="customer[delivery_name]" value="{{ old('customer.delivery_name', $customer['delivery_name'] ?? '') }}" maxlength="100" placeholder="配送先名称（会社名、表札）" required data-customer-detail-field data-customer-delivery-field>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="customer-field-cell TableRight">
                                    <div class="customer-postal-row customer-input-wrap inputnum text-zip2">
                                        <span class="customer-required inputtext-label2 KBN">必須</span>
                                        <input type="text" name="customer[delivery_postal_code]" value="{{ old('customer.delivery_postal_code', $customer['delivery_postal_code'] ?? '') }}" maxlength="8" inputmode="numeric" placeholder="郵便番号" required data-customer-detail-field data-customer-delivery-field data-customer-delivery-postal>
                                        <button type="button" class="customer-address-button" data-customer-delivery-address-lookup>住所に変換</button>
                                    </div>
                                    <span class="customer-error" data-customer-delivery-address-error></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="customer-field-cell TableRight">
                                    <div class="customer-input-wrap inputtext text-prefc2">
                                        <span class="customer-required inputtext-label KBN">必須</span>
                                        <select name="customer[delivery_prefecture]" required data-customer-detail-field data-customer-delivery-field data-customer-delivery-prefecture>
                                            <option value="">都道府県を選択</option>
                                            @foreach ($prefectures as $prefecture)
                                                <option value="{{ $prefecture }}" @selected(old('customer.delivery_prefecture', $customer['delivery_prefecture'] ?? '') === $prefecture)>{{ $prefecture }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="customer-field-cell TableRight">
                                    <div class="customer-input-wrap inputtext text-address2">
                                        <span class="customer-required inputtext-label KBN">必須</span>
                                        <input type="text" name="customer[delivery_address]" value="{{ old('customer.delivery_address', $customer['delivery_address'] ?? '') }}" maxlength="255" placeholder="以降の住所" required data-customer-detail-field data-customer-delivery-field data-customer-delivery-address>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="customer-field-cell TableRight">
                                    <div class="customer-input-wrap inputtext text-address_street2">
                                        <span class="customer-required inputtext-label KBN">必須</span>
                                        <input type="text" name="customer[delivery_address_street]" value="{{ old('customer.delivery_address_street', $customer['delivery_address_street'] ?? '') }}" maxlength="255" placeholder="番地、建物名、部屋番号" required data-customer-detail-field data-customer-delivery-field>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="customer-field-cell TableRight">
                                    <div class="customer-input-wrap inputnum text-tel2">
                                        <span class="customer-required inputtext-label2 KBN">必須</span>
                                        <input type="tel" name="customer[delivery_tel]" value="{{ old('customer.delivery_tel', $customer['delivery_tel'] ?? '') }}" maxlength="30" inputmode="tel" placeholder="配送先TELハイフンなし" required data-customer-detail-field data-customer-delivery-field>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="customer-message-section message_box" data-customer-message @if ($addressMethod !== 'message_box') hidden @endif>
                <table class="customer-table TableAllL">
                    <tbody>
                        <tr>
                            <td class="customer-field-cell TableRight">
                                <textarea class="text_form2" name="customer[contact_detail]" rows="8" data-customer-message-field>{{ old('customer.contact_detail', $customer['contact_detail'] ?? '') }}</textarea><br>
                                会社名やご住所の入ったメールの署名をコピーする<br>
                                (後程営業よりご連絡致しますので、不完全でも構いません。)
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <h3 class="customer-section-title red">ご注文製品の写真・動画掲載</h3>
            <div class="part-container" style="margin-bottom: 10px;">
                <div class="part-content">
                    <label class="part-name">
                        <input type="radio" name="customer[showcase]" value="allow" @checked(old('customer.showcase', $customer['showcase'] ?? 'allow') === 'allow')>
                        制作実績の掲載を許可する（当Webサイト、SNS、Youtube等）
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="part-content">
                    <label class="part-name">
                        <input type="radio" name="customer[showcase]" value="deny" @checked(old('customer.showcase', $customer['showcase'] ?? 'allow') === 'deny')>
                        製作実績の掲載を許可しない
                        <span class="checkmark"></span>
                    </label>
                </div>
                ご希望があれば会社やお店の宣伝やリンクもさせて頂きます。<br>
            </div>

            <h3 class="customer-section-title red">ご連絡事項</h3>
            <table class="customer-table TableAllL">
                <tbody>
                    <tr>
                        <td class="customer-field-cell TableRight2">
                            <textarea class="text_form2" name="customer[contact_detail_2]" rows="8" placeholder="製作実績掲載ご許可のお客様で、ハンドルネームでの掲載をご希望のお客様はこちらに記載してください。">{{ old('customer.contact_detail_2', $customer['contact_detail_2'] ?? '') }}</textarea>
                        </td>
                    </tr>
                </tbody>
            </table>

            <h3 class="customer-section-title red">お支払い情報</h3>
            <div class="part-container" style="margin-bottom: 10px;">
                <div class="part-content">
                    <label class="part-name">
                        <input type="radio" name="customer[payment]" value="銀行振込" @checked(old('customer.payment', $customer['payment'] ?? '銀行振込') === '銀行振込') data-customer-payment>
                        銀行振込
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="part-content">
                    <label class="part-name">
                        <input type="radio" name="customer[payment]" value="PayPalクレジットカード決済" @checked(old('customer.payment', $customer['payment'] ?? '銀行振込') === 'PayPalクレジットカード決済') data-customer-payment>
                        PayPalクレジットカード決済
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="paypal-warning" data-paypal-warning>
                    <img class="warning-icon" src="{{ asset('img/warning.png') }}" alt="警告">
                    <span>
                        PayPalクレジットカード決済をご選択の場合、次の画面でご注文及びお支払い完了となります。
                        製品完成図（完成イメージ図）については、ご注文後、1営業日程度にて提出させて頂きます。
                    </span>
                </div>
                <div class="customer-newsletter">
                    <input type="hidden" name="customer[newsletter]" value="0">
                    <input type="checkbox" id="customer-newsletter" name="customer[newsletter]" value="1" @checked((bool) old('customer.newsletter', $customer['newsletter'] ?? true))>
                    <label for="customer-newsletter">製品やキャンペーンの情報（メルマガ）を受け取る</label>
                </div>
            </div>

            <h3 class="customer-section-title red">ご注文をお受けできない場合がございます。</h3>
            <div class="copyright-warning">
                イラストや写真には著作権や肖像権があり、許可なく使用すると権利侵害となる可能性がございます。当店では、権利侵害のおそれがあるデザインの制作をお断りしております。特に、著名な作品を模したデザインは、1個のみ、自分用、無料配布などであっても正式な許可がない限り受け付けておりません。ご注文前に必ず確認をお願いいたします。
            </div>

            <div class="flex-item textOrderCenter">
                <div class="flex-container btn-container">
                    <a class="btn btn-back" href="{{ route('products.show', ['productPath' => $product->slug]) }}">戻る</a>
                    <button type="submit" class="btn btn-next">最終確認へ</button>
                </div>
            </div>
            <br>
        </form>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('#customer-details-form');
            if (!form) return;

            const addressMethod = form.querySelector('[data-customer-address-method]');
            const detailSection = form.querySelector('[data-customer-details]');
            const messageSection = form.querySelector('[data-customer-message]');
            const detailFields = Array.from(form.querySelectorAll('[data-customer-detail-field]'));
            const messageFields = Array.from(form.querySelectorAll('[data-customer-message-field]'));
            const deliveryFieldsSection = form.querySelector('[data-customer-delivery-fields]');
            const deliveryFields = Array.from(form.querySelectorAll('[data-customer-delivery-field]'));
            const customerTypeInputs = Array.from(form.querySelectorAll('[data-customer-type]'));
            const companyInput = form.querySelector('[data-customer-company]');
            const companyKanaInput = form.querySelector('[data-customer-company-kana]');
            const paypalWarning = form.querySelector('[data-paypal-warning]');

            const setDisabled = function (fields, disabled) {
                fields.forEach(function (field) {
                    field.disabled = disabled;
                });
            };

            const updateCustomerType = function () {
                const corpSelected = form.querySelector('[data-customer-type][value="Corp"]:checked') !== null;
                if (companyInput) companyInput.required = corpSelected;
                if (companyKanaInput) companyKanaInput.required = corpSelected;
                updateRequiredLabels();
            };

            const updateRequiredLabels = function () {
                form.querySelectorAll('.customer-input-wrap').forEach(function (wrapper) {
                    const field = wrapper.querySelector('input:not([type="hidden"]), select, textarea');
                    const badge = wrapper.querySelector('.customer-required');
                    if (!field || !badge) return;

                    const isCompanyField = field === companyInput || field === companyKanaInput;
                    const corpSelected = form.querySelector('[data-customer-type][value="Corp"]:checked') !== null;
                    const isRequired = !isCompanyField || corpSelected;
                    badge.hidden = field.disabled || !isRequired || String(field.value || '').trim() !== '';
                });
            };

            const updateDelivery = function () {
                const isDifferent = form.querySelector('[data-customer-delivery-type][value="different"]:checked') !== null;
                const showDetails = addressMethod?.value === 'add_form';
                const deliveryFieldsEnabled = isDifferent && showDetails;

                if (deliveryFieldsSection) deliveryFieldsSection.hidden = !showDetails;
                deliveryFields.forEach(function (field) {
                    field.disabled = !deliveryFieldsEnabled;
                    field.required = deliveryFieldsEnabled;
                });
                updateRequiredLabels();
            };

            const updateInputSections = function () {
                const method = addressMethod?.value || '';
                const showDetails = method === 'add_form';
                const showMessage = method === 'message_box';

                if (detailSection) detailSection.hidden = !showDetails;
                if (messageSection) messageSection.hidden = !showMessage;
                setDisabled(detailFields, !showDetails);
                setDisabled(messageFields, !showMessage);
                updateCustomerType();
                updateDelivery();
                updateRequiredLabels();
            };

            addressMethod?.addEventListener('change', updateInputSections);
            customerTypeInputs.forEach(function (input) {
                input.addEventListener('change', updateCustomerType);
            });
            form.querySelectorAll('.customer-input-wrap input, .customer-input-wrap select, .customer-input-wrap textarea').forEach(function (field) {
                field.addEventListener('input', updateRequiredLabels);
                field.addEventListener('change', updateRequiredLabels);
            });
            form.querySelectorAll('[data-customer-delivery-type]').forEach(function (input) {
                input.addEventListener('change', updateDelivery);
            });

            const updatePaymentWarning = function () {
                const paypalSelected = form.querySelector('[data-customer-payment][value="PayPalクレジットカード決済"]:checked') !== null;
                paypalWarning?.classList.toggle('is-visible', paypalSelected);
            };
            form.querySelectorAll('[data-customer-payment]').forEach(function (input) {
                input.addEventListener('change', updatePaymentWarning);
            });
            updateInputSections();
            updatePaymentWarning();

            const lookupAddress = async function (config) {
                const postalInput = form.querySelector(config.postal);
                const prefectureInput = form.querySelector(config.prefecture);
                const addressInput = form.querySelector(config.address);
                const error = form.querySelector(config.error);
                const button = form.querySelector(config.button);
                const postalCode = String(postalInput?.value || '').replace(/[^0-9]/g, '');

                if (postalCode.length !== 7) {
                    if (error) error.textContent = '郵便番号を7桁で入力してください。';
                    return;
                }

                if (error) error.textContent = '';
                if (button) button.disabled = true;

                try {
                    const response = await fetch('https://zipcloud.ibsnet.co.jp/api/search?zipcode=' + postalCode);
                    const data = await response.json();
                    const result = data.results?.[0];
                    if (!result) throw new Error('not-found');
                    if (prefectureInput) prefectureInput.value = result.address1 || '';
                    if (addressInput) addressInput.value = (result.address2 || '') + (result.address3 || '');
                    updateRequiredLabels();
                } catch (lookupError) {
                    if (error) error.textContent = '自動変換できませんでした。都道府県、以降の住所を入力してください。';
                } finally {
                    if (button) button.disabled = false;
                }
            };

            form.querySelector('[data-customer-address-lookup]')?.addEventListener('click', function () {
                lookupAddress({
                    postal: '[data-customer-postal]',
                    prefecture: '[data-customer-prefecture]',
                    address: '[data-customer-address]',
                    error: '[data-customer-address-error]',
                    button: '[data-customer-address-lookup]',
                });
            });

            form.querySelector('[data-customer-delivery-address-lookup]')?.addEventListener('click', function () {
                lookupAddress({
                    postal: '[data-customer-delivery-postal]',
                    prefecture: '[data-customer-delivery-prefecture]',
                    address: '[data-customer-delivery-address]',
                    error: '[data-customer-delivery-address-error]',
                    button: '[data-customer-delivery-address-lookup]',
                });
            });

            const fileInput = form.querySelector('[data-customer-files]');
            const fileDropzone = form.querySelector('[data-customer-file-dropzone]');
            const fileList = form.querySelector('[data-customer-file-list]');
            const fileError = form.querySelector('[data-customer-file-error]');
            const allowedExtensions = ['ai', 'pdf', 'doc', 'xls', 'jpeg', 'jpg', 'png', 'psd', 'zip', 'eps'];

            const renderFiles = function () {
                if (!fileInput || !fileList) return;
                fileList.replaceChildren();
                if (fileError) fileError.textContent = '';

                const files = Array.from(fileInput.files || []);
                const invalidFile = files.find(function (file) {
                    const extension = file.name.includes('.') ? file.name.split('.').pop().toLowerCase() : '';
                    return file.size > 10 * 1024 * 1024 || !allowedExtensions.includes(extension);
                });

                if (invalidFile) {
                    if (fileError) fileError.textContent = 'ファイル形式またはサイズ（1ファイル最大10MB）をご確認ください。';
                    fileInput.value = '';
                    fileList.hidden = true;
                    return;
                }

                files.forEach(function (file) {
                    const item = document.createElement('li');
                    item.textContent = file.name;
                    fileList.appendChild(item);
                });
                fileList.hidden = files.length === 0;
            };

            fileInput?.addEventListener('change', renderFiles);
            fileDropzone?.addEventListener('dragover', function (event) {
                event.preventDefault();
                fileDropzone.classList.add('is-dragging');
            });
            fileDropzone?.addEventListener('dragleave', function () {
                fileDropzone.classList.remove('is-dragging');
            });
            fileDropzone?.addEventListener('drop', function (event) {
                event.preventDefault();
                fileDropzone.classList.remove('is-dragging');
                if (fileInput && event.dataTransfer?.files) {
                    fileInput.files = event.dataTransfer.files;
                    renderFiles();
                }
            });
        });
    </script>
@endpush
