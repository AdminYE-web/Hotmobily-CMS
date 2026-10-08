@extends('layouts.product')

@section('head')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="問い合わせ先,無料サンプル,ラバーストラップ,ラバーキーホルダー,ラバーコースター">
    <meta name="description" content="HOTMOBILYオリジナルグッズへのお問い合わせ・連絡。ラバーストラップ、ラバーキーホルダー、ラバーコースターの無料サンプル請求。">
    <meta name="robots" content="index,follow">
    <title>オリジナル製品製作に関するご利用案内 HOTMOBILYオリジナルグッズ</title>

    @include('partials.legacy-head-products')

    <link rel="stylesheet" href="{{ asset('css/contact_2nd.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('contact/css/form.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('order/drag-drop/css/dropzone.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('products/css/box-shadow.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('products/css/product_group.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('products/acrylic/css/renew_products.css') }}" type="text/css">
    <style>
        .contact-page {
            width: 100%;
            color: #281600;
            font-size: 13.6px;
            line-height: normal;
        }

        .contact-page h1 {
            width: 100%;
            margin: 0;
            padding: 3px 3px 3px 10px;
            border-bottom: 0;
            background: #f58904;
            color: #fff;
            font-size: 20px;
            line-height: normal;
            box-sizing: border-box;
        }

        .contact-page h2 {
            margin: 18px 0 8px;
            padding: 7px 10px;
            border-left: 7px solid #fe0000;
            color: #222;
            font-size: 18px;
            line-height: 1.35;
        }

        .contact-page h3 {
            margin: 0 0 8px;
            font-size: 16px;
        }

        .contact-page p {
            margin: 6px 0;
        }

        .contact-page .contact-alert {
            margin: 0 0 12px;
            padding: 9px 12px;
            background: #fff6ed;
            border: 1px solid #f5c28a;
            color: #7a3d00;
        }

        .contact-page .contact-phone {
            display: inline-block;
            margin: 0;
            font-size: 14px;
        }

        .contact-page .contact-section-heading {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0 8px;
            min-height: 47px;
            margin: 15px 0 8px;
        }

        .contact-page .contact-section-title {
            display: inline-flex;
            align-items: center;
            font-size: 18px;
            font-weight: 700;
            line-height: normal;
        }

        .contact-page .contact-section-title::before {
            display: inline-block;
            width: 6px;
            height: 22px;
            margin-right: 5px;
            background: #fe0000;
            content: '';
        }

        .contact-page .contact-table {
            width: 100%;
            margin: 10px 0;
            border: 1px solid #b3b3b3;
            border-collapse: separate;
            border-spacing: 2px;
            background: #fff;
        }

        .contact-page .contact-table th,
        .contact-page .contact-table td {
            padding: 8px 10px;
            border-bottom: 1px dotted #6e6d6d;
            vertical-align: middle;
            text-align: left;
            box-sizing: border-box;
        }

        .contact-page .contact-table tr:last-child th,
        .contact-page .contact-table tr:last-child td {
            border-bottom: 0;
        }

        .contact-page .contact-table th {
            width: 30%;
            background: #8c8c8c;
            color: #fff;
            font-weight: normal;
        }

        .contact-page .contact-table td {
            width: 70%;
        }

        .contact-page .contact-table--wide th {
            width: 22%;
        }

        .contact-page .contact-table--wide td {
            width: 78%;
        }

        .contact-page .contact-table--mode {
            height: 58px;
            margin: 0;
            border-radius: 4px;
            overflow: hidden;
            border-collapse: collapse;
        }

        .contact-page .contact-section-heading--mode {
            margin-bottom: 0;
        }

        .contact-page .contact-table--mode th {
            width: 25%;
            background: #f0f0f0;
            color: #222;
            font-weight: 700;
        }

        .contact-page .contact-table--mode td {
            width: 75%;
            background: #fff;
        }

        .contact-page .contact-table--form th {
            display: none;
        }

        .contact-page .contact-table--form {
            margin: 10px 0;
        }

        .contact-page .contact-table--form td {
            width: 100%;
            padding: 0 5px;
            border-bottom: 0;
        }

        .contact-page .contact-table--form input.contact-field--short {
            width: 51.9% !important;
        }

        .contact-page .contact-table--form .contact-field {
            position: relative;
        }

        .contact-page .contact-table--form .contact-required {
            position: absolute;
            top: 8px;
            right: 3px;
            z-index: 1;
            float: none;
        }

        .contact-page .contact-table--form input[type="text"],
        .contact-page .contact-table--form input[type="email"],
        .contact-page .contact-table--form input[type="tel"] {
            width: 98.9%;
            min-height: 0;
            margin: 3px 0;
            padding: 10px;
            background: #ffffe5;
            font-size: 13.3333px;
            line-height: normal;
        }

        .contact-page .contact-table--form input.contact-field--short {
            width: 51.9% !important;
            font-size: 13.6px;
        }

        .contact-page .contact-table--form input:valid {
            background: #fff;
        }

        .contact-page .contact-table--message th {
            display: none;
        }

        .contact-page .contact-table--message {
            margin: 10px 0;
        }

        .contact-page .contact-table--message td {
            width: 100%;
            padding: 0 5px;
            border-bottom: 0;
        }

        .contact-page .contact-table--message h3 {
            margin-bottom: 0;
        }

        .contact-page .contact-customer-label {
            display: inline-block;
            margin-right: 12px;
            font-weight: normal;
        }

        .contact-page .contact-table--customer-type {
            margin: 10px 0;
        }

        .contact-page .contact-table--customer-type th {
            display: none !important;
        }

        .contact-page .contact-table--customer-type td {
            display: flex;
            align-items: center;
            width: 100%;
            height: 47px;
            padding: 0 8px;
            border: 1px solid #e5e5e5;
            border-radius: 5px;
            background: #fff;
        }

        .contact-page .contact-table--customer-type .contact-radios {
            display: inline-flex;
            flex-wrap: nowrap;
            gap: 18px;
            align-items: center;
        }

        .contact-page .contact-table--mode ~ .contact-secondary-panels > .contact-section-heading {
            margin-top: 0;
        }

        .contact-page .contact-reference-image {
            margin-top: 10px;
            text-align: center;
        }

        .contact-page .contact-reference-image img {
            width: 250px;
            max-width: 100%;
            height: auto;
        }

        .contact-page input[type="text"],
        .contact-page input[type="email"],
        .contact-page input[type="tel"],
        .contact-page textarea,
        .contact-page select {
            width: 100%;
            min-height: 38px;
            padding: 7px 10px;
            border: 1px solid #bdbdbd;
            border-radius: 2px;
            background: #fff;
            color: #333;
            font: inherit;
            box-sizing: border-box;
        }

        .contact-page textarea {
            min-height: 0;
            padding: 0;
            border: 2px solid #f0f0f0;
            border-radius: 5px;
            resize: vertical;
        }

        .contact-page .contact-table--message textarea {
            width: 98.5%;
            min-height: 0;
            padding: 0;
            font-size: 13.3333px;
            line-height: normal;
        }

        .contact-page input:focus,
        .contact-page textarea:focus,
        .contact-page select:focus {
            border-color: #f07800;
            outline: 2px solid rgba(240, 120, 0, .16);
        }

        .contact-page .contact-required {
            display: inline-block;
            float: right;
            margin-left: 8px;
            padding: 1px 7px;
            background: #f1444d;
            color: #fff;
            font-size: 12px;
            line-height: 1.7;
        }

        .contact-page .contact-field {
            display: flow-root;
        }

        .contact-page .contact-field input,
        .contact-page .contact-field textarea,
        .contact-page .contact-field select {
            margin-top: 4px;
        }

        .contact-page .contact-error {
            display: block;
            margin-top: 4px;
            color: #d40000;
            font-size: 12px;
        }

        .contact-page .contact-radios {
            display: flex;
            flex-wrap: wrap;
            gap: 9px 18px;
            align-items: center;
        }

        .contact-page .contact-radio {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            min-height: 28px;
            cursor: pointer;
        }

        .contact-page .contact-radio input {
            width: 27px;
            height: 27px;
            margin: 0;
            border: 1px solid #c9c9c9;
            border-radius: 50%;
            background: #fff;
            appearance: none;
            -webkit-appearance: none;
            box-sizing: border-box;
        }

        .contact-page .contact-radio input:checked {
            background: #f4b719;
            box-shadow: inset 0 0 0 5px #fff;
        }

        .contact-page .sample-product-area {
            margin: 0;
            padding: 0;
            border: 0;
            background: transparent;
        }

        .contact-page .sample-product-area[hidden],
        .contact-page .contact-panel[hidden],
        .contact-page .sample-product-group[hidden] {
            display: none !important;
        }

        .contact-page .sample-product-selector {
            display: flex;
            min-height: 69px;
            margin-top: 10px;
            border: 2px solid #f0f0f0;
            box-sizing: border-box;
        }

        .contact-page .sample-product-selector__label {
            display: flex;
            flex: 0 0 27.5%;
            align-items: center;
            padding: 10px;
            background: #f0f0f0;
            font-weight: 700;
            box-sizing: border-box;
        }

        .contact-page .sample-product-selector__content {
            flex: 1 1 auto;
            min-width: 0;
            padding-left: 10px;
            box-sizing: border-box;
        }

        .contact-page .sample-product-selector__control {
            display: flex;
            height: 55px;
            align-items: flex-start;
            padding: 10px 10px 6px;
            box-sizing: border-box;
        }

        .contact-page .sample-product-selector__control select {
            width: 364px;
            max-width: 100%;
            height: 39px;
            margin: 3px 0;
        }

        .contact-page .sample-product-intro {
            display: none;
        }

        .contact-page .sample-product-group {
            width: 70%;
            margin: 0 0 10px 10px;
            border: 0;
            box-sizing: border-box;
        }

        .contact-page .sample-product-group:last-child {
            margin-bottom: 0;
        }

        .contact-page .sample-product-group__title {
            display: none;
        }

        .contact-page .sample-product-group__items {
            display: flex;
            flex-direction: column;
            gap: 0;
            padding: 0;
        }

        .contact-page .sample-product-group__items .contact-radio {
            width: 100%;
            min-height: 44px;
            padding: 8px 10px;
            align-items: center;
            gap: 12px;
            line-height: 1.2;
            box-sizing: border-box;
        }

        .contact-page .upload-box {
            height: 198px;
            min-height: 150px;
            margin-bottom: -1px;
            padding: 20px 5px;
            border: 2px solid rgba(0, 0, 0, .3);
            background: #fff;
            box-sizing: border-box;
            cursor: pointer;
            transition: background-color .15s ease, border-color .15s ease;
        }

        .contact-page .upload-box.dz-drag-hover {
            border-color: #1e6077;
            background: #f1f8fa;
        }

        .contact-page .contact-panel > .contact-table {
            margin: 10px 0;
        }

        .contact-page .contact-panel > .contact-table th,
        .contact-page .contact-panel > .contact-table td {
            padding: 3px;
        }

        .contact-page .contact-panel > .contact-table > tbody > tr:first-child > td {
            line-height: 19px;
        }

        .contact-page .contact-panel > .contact-table > tbody > tr:nth-child(2) > td {
            padding-top: 3px;
            padding-bottom: 1px;
        }

        .contact-page .upload-box img {
            display: inline-block;
            width: 50px;
            height: 50px;
            margin: 0;
            padding-right: 10px;
            object-fit: contain;
        }

        .contact-page .upload-box input[type="file"] {
            display: inline-block;
            width: auto;
            margin: 0;
            font-size: 13px;
        }

        .contact-page .upload-box .dz-message {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 50px;
            margin: 24px 0;
            padding-left: 5px;
            font-size: 12px;
        }

        .contact-page .upload-box .fallback {
            display: block;
            height: 56px;
            text-align: center;
        }

        .contact-page .upload-box #contact-file {
            width: 253px;
            max-width: 100%;
        }

        .contact-page .upload-note {
            color: #666;
            font-size: 12px;
        }

        .contact-page .file-list {
            margin: 8px 0 0;
            padding: 0;
            list-style: none;
            text-align: left;
        }

        .contact-page .contact-panel .file-list {
            margin: 0;
        }

        .contact-page .contact-panel > .contact-table > tbody > tr.contact-upload-files-row > td {
            padding: 0 !important;
            font-size: 0 !important;
            line-height: 0 !important;
        }

        .contact-page .upload-note {
            margin: 4.5px 0;
        }

        .contact-page .file-list li {
            padding: 3px 0;
            border-bottom: 1px dotted #bbb;
            overflow-wrap: anywhere;
        }

        .contact-page .zip-row {
            display: flex;
            gap: 8px;
            align-items: flex-start;
        }

        .contact-page .zip-row input {
            flex: 1 1 auto;
        }

        .contact-page .zip-row button {
            flex: 0 0 auto;
            min-height: 38px;
            padding: 6px 11px;
            border: 1px solid #777;
            background: #f5f5f5;
            color: #222;
            cursor: pointer;
            font: inherit;
        }

        .contact-page .zip-error {
            color: #d40000;
            font-size: 12px;
        }

        .contact-page .contact-actions {
            display: flex;
            justify-content: space-between;
            gap: 0;
            margin: 10px 0 8px;
        }

        .contact-page .contact-button {
            flex: 0 0 35%;
            min-width: 0;
            height: 49px;
            padding: 0;
            border: 1px solid #000;
            border-radius: 4px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            line-height: 1;
            font-weight: bold;
            box-sizing: border-box;
        }

        .contact-page .contact-button--back {
            background: linear-gradient(#fff, #ededed);
            color: #000;
        }

        .contact-page .contact-button--next {
            border-color: #76a0b0;
            background: #76a0b0;
            color: #fff;
        }

        .contact-page .contact-button:hover {
            opacity: .86;
        }

        .contact-page form {
            display: flow-root;
        }

        @media screen and (max-width: 576px) {
            .contact-page {
                font-size: 13px;
            }

            .contact-page h1 {
                font-size: 20px;
            }

            .contact-page h2 {
                font-size: 16px;
            }

            .contact-page .contact-table,
            .contact-page .contact-table tbody,
            .contact-page .contact-table tr {
                display: block;
                width: 100%;
            }

            .contact-page .contact-table th,
            .contact-page .contact-table td {
                display: block;
                width: 100%;
                border-bottom: 0;
            }

            .contact-page .contact-table th {
                padding-bottom: 4px;
            }

            .contact-page .contact-table td {
                padding-top: 4px;
                padding-bottom: 10px;
                border-bottom: 1px dotted #6e6d6d;
            }

            .contact-page .contact-table tr:last-child td {
                border-bottom: 0;
            }

            .contact-page .sample-product-group__items {
                grid-template-columns: 1fr;
            }

            .contact-page .zip-row {
                display: block;
            }

            .contact-page .zip-row button {
                margin-top: 7px;
            }

            .contact-page .contact-table--form input.contact-field--short {
                width: 96% !important;
            }

            .contact-page .contact-table--customer-type td {
                display: flex;
                align-items: center;
                height: 47px;
                padding: 0 8px;
            }

            .contact-page .contact-actions {
                flex-direction: column-reverse;
                gap: 8px;
            }

            .contact-page .contact-button {
                width: 100%;
                flex-basis: auto;
            }

        }

        @media screen and (max-width: 768px) {
            .contact-page[data-mode-selected="0"] .contact-secondary-panels {
                display: none !important;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $currentType = (string) old('sndKBN', array_key_exists('sndKBN', $form) ? $form['sndKBN'] : '');
        $isSample = $currentType === '1';
        $customerType = old('cstKBN', $form['cstKBN'] ?? 'Corp');
        $inputValue = static fn (string $key, mixed $default = '') => old($key, $form[$key] ?? $default);
        $selectedItemType = (string) $inputValue('ItemType');
        $selectedGroupKey = '';

        foreach ($sampleProductGroups as $group) {
            foreach ($group['items'] as $sampleItem) {
                $sampleItemValue = is_array($sampleItem) ? $sampleItem['value'] : $sampleItem;

                if ($sampleItemValue === $selectedItemType) {
                    $selectedGroupKey = $group['key'] ?? '';
                    break 2;
                }
            }
        }
    @endphp

    <div class="contact-page" data-contact-page data-mode-selected="{{ $currentType !== '' ? '1' : '0' }}">
        <h1>お問い合わせ・サンプル請求</h1>

        @if ($errors->any())
            <div class="contact-alert" role="alert">
                入力内容をご確認ください。必須項目が未入力、または形式が正しくありません。
            </div>
        @endif

        <form action="{{ route('contact.confirm') }}" method="post" enctype="multipart/form-data" id="contact-form">
            @csrf

            <div class="contact-section-heading contact-section-heading--mode">
                <div class="contact-section-title">1.お問い合わせ区分</div>
                <span class="contact-phone">お急ぎの場合、050 -6865 -5591 までお電話ください。(平日10:30-19:30)</span>
            </div>

            <table class="contact-table contact-table--mode">
                <tr>
                    <th>お問い合わせ区分を選択</th>
                    <td>
                        <div class="contact-radios">
                            <label class="contact-radio">
                                <input type="radio" name="sndKBN" value="0" @checked($currentType === '0')>
                                <span>お問い合わせ</span>
                            </label>
                            <label class="contact-radio">
                                <input type="radio" name="sndKBN" value="1" @checked($currentType === '1')>
                                <span>無料サンプル希望</span>
                            </label>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="sample-product-area" data-sample-panel @if (! $isSample) hidden @endif>
                <div class="sample-product-selector" data-sample-selector>
                    <div class="sample-product-selector__label">サンプル請求の商品</div>
                    <div class="sample-product-selector__content">
                        <div class="sample-product-selector__control">
                        <select data-sample-group-select aria-label="製品グループを選択">
                            <option value="">製品グループを選択</option>
                            @foreach ($sampleProductGroups as $group)
                                <option value="{{ $group['key'] }}" @selected($selectedGroupKey === $group['key'])>{{ $group['label'] }}</option>
                            @endforeach
                        </select>
                        </div>
                <p class="sample-product-intro">ご希望の製品を1つ選択してください。</p>

                @foreach ($sampleProductGroups as $group)
                    <section
                        class="sample-product-group"
                        data-sample-group="{{ $group['key'] }}"
                        @if ($selectedGroupKey !== $group['key']) hidden @endif
                    >
                        <h3 class="sample-product-group__title">{{ $group['label'] }}</h3>
                        <div class="sample-product-group__items">
                            @foreach ($group['items'] as $item)
                                @php
                                    $itemValue = is_array($item) ? $item['value'] : $item;
                                    $itemLabel = is_array($item) ? $item['label'] : $item;
                                @endphp
                                <label class="contact-radio">
                                    <input
                                        type="radio"
                                        name="ItemType"
                                        value="{{ $itemValue }}"
                                        data-sample-item
                                        @checked($selectedItemType === $itemValue)
                                    >
                                    <span>{{ $itemLabel }}</span>
                                </label>
                            @endforeach
                        </div>
                    </section>
                @endforeach

                @error('ItemType')
                    <span class="contact-error">{{ $message }}</span>
                @enderror
                    </div>
                </div>
            </div>

            <div class="contact-secondary-panels">
                <div class="contact-section-heading">
                    <div class="contact-section-title">2.お客様情報の入力</div>
                </div>

            <table class="contact-table contact-table--form">
                <tr>
                    <th>メールアドレス</th>
                    <td>
                        <div class="contact-field">
                            <span class="contact-required">必須</span>
                            <input type="email" name="email" maxlength="250" value="{{ $inputValue('email') }}" placeholder="メールアドレス" required>
                            @error('email') <span class="contact-error">{{ $message }}</span> @enderror
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>お名前</th>
                    <td>
                        <div class="contact-field">
                            <span class="contact-required">必須</span>
                            <input type="text" name="Name_S" maxlength="100" value="{{ $inputValue('Name_S') }}" placeholder="お名前" required>
                            @error('Name_S') <span class="contact-error">{{ $message }}</span> @enderror
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>フリガナ</th>
                    <td>
                        <div class="contact-field">
                            <span class="contact-required">必須</span>
                            <input type="text" name="Name_S_K" maxlength="100" value="{{ $inputValue('Name_S_K') }}" placeholder="フリガナ" required>
                            @error('Name_S_K') <span class="contact-error">{{ $message }}</span> @enderror
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td>
                        <div class="contact-field">
                            <span class="contact-required">必須</span>
                            <input class="contact-field--short" type="tel" name="tel" inputmode="numeric" maxlength="30" value="{{ $inputValue('tel') }}" placeholder="電話番号(ハイフン無し)" required>
                            @error('tel') <span class="contact-error">{{ $message }}</span> @enderror
                        </div>
                    </td>
                </tr>
                <tr class="contact-table--customer-type">
                    <th>お客様区分</th>
                    <td>
                        <span class="contact-customer-label">お客様区分</span>
                        <div class="contact-radios">
                            <label class="contact-radio">
                                <input type="radio" name="cstKBN" value="Corp" @checked($customerType === 'Corp')>
                                <span>法人</span>
                            </label>
                            <label class="contact-radio">
                                <input type="radio" name="cstKBN" value="Personal" @checked($customerType === 'Personal')>
                                <span>個人</span>
                            </label>
                        </div>
                        @error('cstKBN') <span class="contact-error">{{ $message }}</span> @enderror
                    </td>
                </tr>
                <tr data-corp-row>
                    <th>法人名</th>
                    <td>
                        <div class="contact-field">
                            <span class="contact-required" data-corp-required>必須</span>
                            <input type="text" name="Corp_Name" maxlength="100" value="{{ $inputValue('Corp_Name') }}" placeholder="法人名" data-corp-field>
                            @error('Corp_Name') <span class="contact-error">{{ $message }}</span> @enderror
                        </div>
                    </td>
                </tr>
                <tr data-corp-row>
                    <th>法人名（フリガナ）</th>
                    <td>
                        <div class="contact-field">
                            <span class="contact-required" data-corp-required>必須</span>
                            <input type="text" name="Corp_Name_K" maxlength="100" value="{{ $inputValue('Corp_Name_K') }}" placeholder="法人名（フリガナ）" data-corp-field>
                            @error('Corp_Name_K') <span class="contact-error">{{ $message }}</span> @enderror
                        </div>
                    </td>
                </tr>
                <tr data-corp-row>
                    <th>お客様部署名</th>
                    <td>
                        <div class="contact-field">
                            <input type="text" name="dev" maxlength="100" value="{{ $inputValue('dev') }}" placeholder="お客様部署名" data-corp-field>
                            @error('dev') <span class="contact-error">{{ $message }}</span> @enderror
                        </div>
                    </td>
                </tr>
            </table>

            <table class="contact-table contact-table--wide contact-table--message">
                <tr>
                    <td colspan="2">
                        <h3>お問い合わせ内容</h3>
                        <textarea name="contactDetail" rows="8" placeholder="お問い合わせ内容をご入力ください。">{{ $inputValue('contactDetail') }}</textarea>
                        @if (filled($inputValue('sample_pic')))
                            <input type="hidden" name="sample_pic" value="{{ $inputValue('sample_pic') }}">
                            <div class="contact-reference-image">
                                <img src="{{ $inputValue('sample_pic') }}" alt="お問い合わせ対象の参考画像">
                            </div>
                        @endif
                        @error('contactDetail') <span class="contact-error">{{ $message }}</span> @enderror
                    </td>
                </tr>
            </table>

            <div class="contact-panel" data-upload-panel @if ($isSample) hidden @endif>
                <table class="contact-table contact-table--wide">
                    <tr>
                        <td colspan="2">
                            データの確認、お写真の確認など、ご希望のお客様はこちらからデータを送信頂けます。
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="upload-box dropzone dz-clickable" id="contact-dropzone">
                                <div class="dz-message">
                                    <img src="{{ asset('contact/img/uploaded-select.webp') }}" width="50" height="50" alt="ファイルを選択">
                                    <span>ここにファイルをドロップするか、スマホの場合ここをタップしてください。</span>
                                </div>
                                <div class="fallback">
                                    <span class="sun">インターネットエクスプローラー（IE）をご利用の場合、ファイルを選択してください。</span><br><br>
                                    <input id="contact-file" name="file[]" type="file" accept=".ai,.pdf,.doc,.xls,.jpeg,.jpg,.psd,.zip">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="contact-upload-files-row">
                        <td colspan="2">
                            <ul class="file-list" data-file-list></ul>
                            @error('file') <span class="contact-error">{{ $message }}</span> @enderror
                            @error('file.*') <span class="contact-error">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <p class="upload-note">
                                ※アップロード可能なファイル形式は、ai, pdf, doc, xls, jpeg, jpg, psd, zipです。<br>
                                ※ご入稿ファイルは1ファイルにつき最大10MBとなります。<br>
                                ※入稿データは別途メールでお送り頂いても構いません。
                            </p>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="contact-panel" data-address-panel @if (! $isSample) hidden @endif>
                <h2>3.サンプル送付先情報の入力</h2>
                <table class="contact-table contact-table--form">
                    <tr>
                        <th>郵便番号</th>
                        <td>
                            <div class="zip-row">
                                <input type="text" id="contact-zip" name="zip" maxlength="8" inputmode="numeric" value="{{ $inputValue('zip') }}" placeholder="郵便番号 ハイフンなし7桁半角数字" data-sample-required>
                                <button type="button" id="contact-zip-button">住所に変換</button>
                            </div>
                            <span class="zip-error" data-zip-error></span>
                            @error('zip') <span class="contact-error">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                    <tr>
                        <th>都道府県</th>
                        <td>
                            <input type="text" id="contact-prefecture" name="prefc" value="{{ $inputValue('prefc') }}" placeholder="都道府県" data-sample-required>
                            @error('prefc') <span class="contact-error">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                    <tr>
                        <th>以降の住所</th>
                        <td>
                            <input type="text" id="contact-address" name="address" value="{{ $inputValue('address') }}" placeholder="以降の住所" data-sample-required>
                            @error('address') <span class="contact-error">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                    <tr>
                        <th>番地、建物名、部屋番号</th>
                        <td>
                            <input type="text" id="contact-address-street" name="address_street" value="{{ $inputValue('address_street') }}" placeholder="番地、建物名、部屋番号" data-sample-required>
                            @error('address_street') <span class="contact-error">{{ $message }}</span> @enderror
                        </td>
                    </tr>
                </table>
            </div>

                <div class="contact-actions">
                    <a class="contact-button contact-button--back" href="{{ route('contact.index', ['mode' => 'MODE_RESET']) }}">リセット</a>
                    <button class="contact-button contact-button--next sub" type="submit">内容を確認</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const page = document.querySelector('[data-contact-page]');
            const form = document.getElementById('contact-form');
            if (!page || !form) return;

            const samplePanel = page.querySelector('[data-sample-panel]');
            const uploadPanel = page.querySelector('[data-upload-panel]');
            const addressPanel = page.querySelector('[data-address-panel]');
            const sampleItems = Array.from(page.querySelectorAll('[data-sample-item]'));
            const sampleGroupSelect = page.querySelector('[data-sample-group-select]');
            const sampleGroups = Array.from(page.querySelectorAll('[data-sample-group]'));
            const sampleRequiredFields = Array.from(page.querySelectorAll('[data-sample-required]'));
            const corpRows = Array.from(page.querySelectorAll('[data-corp-row]'));
            const corpFields = Array.from(page.querySelectorAll('[data-corp-field]'));
            const corpRequiredBadges = Array.from(page.querySelectorAll('[data-corp-required]'));

            function isSample() {
                return form.querySelector('input[name="sndKBN"]:checked')?.value === '1';
            }

            function updateSampleGroup() {
                const selectedGroup = sampleGroupSelect?.value || '';

                sampleGroups.forEach(function (group) {
                    group.hidden = !selectedGroup || group.dataset.sampleGroup !== selectedGroup;
                });

                sampleItems.forEach(function (input) {
                    input.required = false;
                });

                if (!isSample() || !selectedGroup) return;

                const firstGroupItem = sampleItems.find(function (input) {
                    return input.closest('[data-sample-group]')?.dataset.sampleGroup === selectedGroup;
                });

                if (firstGroupItem) firstGroupItem.required = true;
            }

            function updateMode() {
                const sample = isSample();
                page.dataset.modeSelected = form.querySelector('input[name="sndKBN"]:checked') ? '1' : '0';
                samplePanel.hidden = !sample;
                uploadPanel.hidden = sample;
                addressPanel.hidden = !sample;
                updateSampleGroup();

                sampleRequiredFields.forEach(function (input) {
                    input.required = sample;
                });
            }

            function isCorp() {
                return form.querySelector('input[name="cstKBN"]:checked')?.value !== 'Personal';
            }

            function updateCustomerType() {
                const corp = isCorp();
                corpRows.forEach(function (row) {
                    row.hidden = !corp;
                });
                corpFields.forEach(function (input) {
                    input.disabled = !corp;
                    input.required = corp && (input.name === 'Corp_Name' || input.name === 'Corp_Name_K');
                });
                corpRequiredBadges.forEach(function (badge) {
                    badge.hidden = !corp;
                });
            }

            form.querySelectorAll('input[name="sndKBN"]').forEach(function (input) {
                input.addEventListener('change', updateMode);
            });

            if (sampleGroupSelect) {
                sampleGroupSelect.addEventListener('change', updateSampleGroup);
            }

            form.querySelectorAll('input[name="cstKBN"]').forEach(function (input) {
                input.addEventListener('change', updateCustomerType);
            });

            const fileInput = document.getElementById('contact-file');
            const fileList = page.querySelector('[data-file-list]');
            if (fileInput && fileList) {
                fileInput.addEventListener('change', function () {
                    fileList.innerHTML = '';
                    Array.from(fileInput.files).forEach(function (file) {
                        const item = document.createElement('li');
                        item.textContent = file.name + ' (' + Math.ceil(file.size / 1024) + 'KB)';
                        fileList.appendChild(item);
                    });
                });

                const dropzone = document.getElementById('contact-dropzone');
                if (dropzone) {
                    dropzone.addEventListener('click', function (event) {
                        if (!event.target.closest('input, button, a')) fileInput.click();
                    });

                    dropzone.addEventListener('dragover', function (event) {
                        event.preventDefault();
                        dropzone.classList.add('dz-drag-hover');
                    });

                    dropzone.addEventListener('dragleave', function () {
                        dropzone.classList.remove('dz-drag-hover');
                    });

                    dropzone.addEventListener('drop', function (event) {
                        event.preventDefault();
                        dropzone.classList.remove('dz-drag-hover');

                        const droppedFile = Array.from(event.dataTransfer?.files || [])[0];
                        if (!droppedFile) return;

                        try {
                            const transfer = new DataTransfer();
                            transfer.items.add(droppedFile);
                            fileInput.files = transfer.files;
                            fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                        } catch (error) {
                            // Browsers that do not allow assigning FileList still keep click-to-select available.
                        }
                    });
                }
            }

            const zipButton = document.getElementById('contact-zip-button');
            const zipInput = document.getElementById('contact-zip');
            const zipError = page.querySelector('[data-zip-error]');
            const prefectureInput = document.getElementById('contact-prefecture');
            const addressInput = document.getElementById('contact-address');

            if (zipButton && zipInput && prefectureInput && addressInput) {
                zipButton.addEventListener('click', function () {
                    const zipcode = zipInput.value.replace(/[^0-9]/g, '');
                    zipError.textContent = '';

                    if (zipcode.length !== 7) {
                        zipError.textContent = '郵便番号は7桁で入力してください。';
                        return;
                    }

                    zipButton.disabled = true;
                    fetch('https://zipcloud.ibsnet.co.jp/api/search?zipcode=' + encodeURIComponent(zipcode))
                        .then(function (response) { return response.json(); })
                        .then(function (data) {
                            if (!data.results || !data.results.length) {
                                throw new Error('not-found');
                            }
                            const result = data.results[0];
                            prefectureInput.value = (result.address1 || '') + (result.address2 || '');
                            addressInput.value = result.address3 || '';
                        })
                        .catch(function () {
                            zipError.textContent = '住所を取得できませんでした。都道府県と住所を直接入力してください。';
                        })
                        .finally(function () {
                            zipButton.disabled = false;
                        });
                });
            }

            updateMode();
            updateCustomerType();
        });
    </script>
@endpush
