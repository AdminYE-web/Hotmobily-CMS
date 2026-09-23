@extends('layouts.product')

@php
    $customer = is_array($orderPayload['customer'] ?? null) ? $orderPayload['customer'] : [];
    $summaryRows = collect($summaryRows ?? [])
        ->filter(static fn ($row): bool => is_array($row) && trim((string) ($row['label'] ?? '')) !== '')
        ->values();
    $priceRows = collect($priceRows ?? [])
        ->filter(static fn ($row): bool => is_array($row) && trim((string) ($row['label'] ?? '')) !== '')
        ->values();
    $customerFiles = collect($orderPayload['customer_files'] ?? [])
        ->filter(static fn ($file): bool => is_array($file) && trim((string) ($file['name'] ?? '')) !== '')
        ->values();
    $quantity = max(1, (int) ($orderPayload['quantity'] ?? 1));
    $totalAmount = (int) ($orderPayload['total_amount'] ?? 0);
    $subtotalAmount = (int) ($orderPayload['subtotal_amount'] ?? $totalAmount);
    $discountAmount = (int) ($orderPayload['discount_amount'] ?? 0);
    $addressMethod = (string) ($customer['address_method'] ?? '');
    $deliveryType = (string) ($customer['delivery_type'] ?? 'same');
    $customerType = (string) ($customer['cstKBN'] ?? '');
    $showcase = (string) ($customer['showcase'] ?? '');
    $showcaseLabel = [
        'allow' => '制作実績の掲載を許可する（当Webサイト、SNS、Youtube等）',
        'deny' => '製作実績の掲載を許可しない',
    ][$showcase] ?? null;
    $addressMethodLabel = [
        'add_form' => '詳細情報を全て入力する',
        'none' => '入力省略(営業より連絡します)',
        'message_box' => 'メールの署名等をコピーする',
    ][$addressMethod] ?? '-';
    $customerTypeLabel = [
        'Corp' => '法人のお客様',
        'Personal' => '個人のお客様',
        'Other' => 'その他の区分のお客様',
    ][$customerType] ?? '-';
    $displayValue = static function ($value): string {
        $value = trim((string) $value);

        return $value === '' ? '-' : $value;
    };
    $formatAmount = static fn ($amount): string => number_format((int) $amount).'円';
    $summaryLabels = $summaryRows
        ->map(static fn (array $row): string => trim((string) ($row['label'] ?? '')))
        ->filter()
        ->all();
    $quantityValue = $product->slug === 'rubberstrap' ? $quantity.'本' : (string) $quantity;
    $specificationRows = collect([
        [
            'label' => 'ご注文商品',
            'value' => $product->name,
        ],
    ])
        ->concat($summaryRows->map(static fn (array $row): array => [
            'label' => trim((string) ($row['label'] ?? '')),
            'value' => (string) ($row['value'] ?? ''),
        ]))
        ->when(! in_array('ご注文本数', $summaryLabels, true), static fn ($rows) => $rows->push([
            'label' => 'ご注文本数',
            'value' => $quantityValue,
        ]))
        ->when($showcaseLabel !== null && ! in_array('ご注文製品の写真・動画掲載', $summaryLabels, true), static fn ($rows) => $rows->push([
            'label' => 'ご注文製品の写真・動画掲載',
            'value' => $showcaseLabel,
        ]))
        ->values();
    $displayPriceRows = collect();
    if ($priceRows->isEmpty()) {
        $displayPriceRows = collect([
            ['label' => '商品代金', 'amount' => 0, 'kind' => 'product'],
            ['label' => '小計(税込)', 'amount' => $subtotalAmount, 'kind' => 'subtotal'],
            ['label' => 'お値引き', 'amount' => $discountAmount, 'kind' => 'discount'],
            ['label' => '送料計', 'amount' => 0, 'kind' => 'charge'],
            ['label' => '合計(税込)', 'amount' => $totalAmount, 'kind' => 'total'],
        ]);
    } else {
        $shippingInserted = false;
        foreach ($priceRows as $row) {
            $isTotalRow = ($row['kind'] ?? '') === 'total'
                || trim((string) ($row['label'] ?? '')) === '合計(税込)';

            if ($isTotalRow && ! $shippingInserted) {
                $displayPriceRows->push(['label' => '送料計', 'amount' => 0, 'kind' => 'charge']);
                $shippingInserted = true;
            }

            $displayPriceRows->push($row);
        }

        if (! $shippingInserted) {
            $displayPriceRows->push(['label' => '送料計', 'amount' => 0, 'kind' => 'charge']);
        }
    }
@endphp

@section('head')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>ご注文内容確認 - {{ $product->name }}</title>
    <meta name="robots" content="noindex,nofollow">
    <link rel="canonical" href="{{ route('products.confirm', ['productPath' => $product->slug]) }}">
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
        #content_wrapper .order-confirm-page {
            box-sizing: border-box;
            width: 771px;
            max-width: 100%;
            margin: 0 0 40px;
            color: #281600;
            font-size: 13.6px;
            line-height: 1.45;
        }

        #content_wrapper .order-confirm-page .confirm-title {
            margin: 12px 0 5px;
            padding: 0;
            color: #f00;
            font-size: 16px;
            line-height: 1.45;
        }

        #content_wrapper .order-confirm-page .confirm-table {
            box-sizing: border-box;
            width: 100%;
            margin: 0 0 10px;
            border: 1px solid #b3b3b3;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
        }

        #content_wrapper .order-confirm-page .confirm-table td {
            box-sizing: border-box;
            padding: 0;
            border: 0;
            vertical-align: middle;
            overflow-wrap: anywhere;
        }

        #content_wrapper .order-confirm-page .confirm-table .confirm-label {
            width: 200px;
            padding: 0 5px;
            background: #8c8c8c !important;
            color: #fff !important;
            font-weight: 400;
            line-height: 200%;
            text-align: left !important;
            border:1px solid ;
        }

        #content_wrapper .order-confirm-page .confirm-table .confirm-value {
            width: 490px;
            min-height: 24px;
            padding: 3px 6px 3px 10px;
            border-bottom: 1px dotted #6e6d6d;
            white-space: pre-wrap;
        }

        #content_wrapper .order-confirm-page .confirm-table tr:last-child .confirm-value {
            border-bottom: 0;
        }

        #content_wrapper .order-confirm-page .confirm-table .confirm-value--muted {
            color: #666;
        }

        #content_wrapper .order-confirm-page .confirm-table .confirm-amount {
            width: 90px;
            padding: 3px 0;
            text-align: right;
            white-space: nowrap;
        }

        #content_wrapper .order-confirm-page .confirm-table .confirm-price-spacer {
            width: 400px;
            padding: 3px 0;
            border-bottom: 1px dotted #6e6d6d;
        }

        #content_wrapper .order-confirm-page .confirm-price-table tr:last-child .confirm-price-spacer,
        #content_wrapper .order-confirm-page .confirm-price-table tr:last-child .confirm-amount {
            border-bottom: 0;
        }

        #content_wrapper .order-confirm-page .confirm-table .confirm-total-label,
        #content_wrapper .order-confirm-page .confirm-table .confirm-total-value {
            font-weight: 700;
        }

        #content_wrapper .order-confirm-page .confirm-table .confirm-total-value {
            color: #d00;
            font-size: 15px;
            text-align: right;
            white-space: nowrap;
        }

        #content_wrapper .order-confirm-page .confirm-files {
            margin: 0;
            padding-left: 18px;
        }

        #content_wrapper .order-confirm-page .confirm-files li + li {
            margin-top: 2px;
        }

        #content_wrapper .order-confirm-page .confirm-empty {
            color: #666;
        }

        #content_wrapper .order-confirm-page .confirm-error {
            margin: 0 0 12px;
            padding: 8px 10px;
            border: 1px solid #d88;
            background: #fff0f0;
            color: #b00020;
        }

        #content_wrapper .order-confirm-page .confirm-submit-form {
            margin: 0;
        }

        #content_wrapper .order-confirm-page .confirm-actions {
            display: flex;
            flex-flow: row nowrap;
            justify-content: center;
            align-items: stretch;
            gap: 8px;
            margin: 18px 0 8px;
            text-align: center;
        }

        #content_wrapper .order-confirm-page .confirm-action {
            box-sizing: border-box;
            display: inline-flex;
            flex: 0 0 15%;
            width: 15% !important;
            min-width: 0;
            max-width: 15%;
            height: 42px;
            min-height: 42px;
            margin-bottom: 0;
            padding: 10px 0;
            border: 1px solid transparent;
            border-radius: 5px;
            background-image: none;
            background: #1e6077;
            color: #fff !important;
            cursor: pointer;
            font-size: 12px;
            font-weight: 700;
            line-height: 1.42857143;
            text-align: center;
            text-decoration: none;
            touch-action: manipulation;
            vertical-align: middle;
            white-space: nowrap;
            user-select: none;
            transition: all .3s ease;
            outline: 0;
            align-items: center;
            justify-content: center;
        }

        #content_wrapper .order-confirm-page .confirm-action.btn-back {
            background: linear-gradient(to bottom, #f7f8fa, #e7e9ec);
            color: #000 !important;
            border-color: #000;
        }

        #content_wrapper .order-confirm-page .confirm-action:hover,
        #content_wrapper .order-confirm-page .confirm-action:focus {
            text-decoration: none;
            opacity: .7;
        }

        #content_wrapper .order-confirm-page .confirm-action--final {
            border-color: transparent;
            background: #1e6077;
            color: #fff !important;
        }

        #content_wrapper .order-confirm-page .confirm-action--final:hover,
        #content_wrapper .order-confirm-page .confirm-action--final:focus {
            border-color: #1e6077;
            background: #fff;
            color: #1e6077 !important;
            font-weight: 700;
            opacity: 1;
        }

        #content_wrapper .order-confirm-page .confirm-action.btn-back:hover,
        #content_wrapper .order-confirm-page .confirm-action.btn-back:focus {
            border-color: #000;
            background: #fff;
            color: #000 !important;
            opacity: 1;
        }

        #content_wrapper .order-confirm-page .confirm-action--final:disabled {
            cursor: not-allowed;
            opacity: .5;
        }

        #content_wrapper .order-confirm-page .confirm-footnote {
            margin: 0;
            color: #666;
            font-size: 12px;
            text-align: center;
        }

        @media screen and (max-width: 768px) {
            #content_wrapper .order-confirm-page .confirm-action {
                flex: 1 1 0;
                width: auto !important;
                min-width: 0;
                max-width: none;
                height: 42px;
                min-height: 42px;
                padding-right: 2px;
                padding-left: 2px;
                font-size: 12px;
            }

            #content_wrapper .order-confirm-page .confirm-table .confirm-label {
                width: 20%;
            }

            #content_wrapper .order-confirm-page .confirm-table .confirm-value {
                width: 80%;
            }

            #content_wrapper .order-confirm-page .confirm-table .confirm-amount {
                width: 90px;
            }

            #content_wrapper .order-confirm-page .confirm-table .confirm-price-spacer {
                width: auto;
            }

        }
    </style>
@endsection

@section('content')
    <main class="order-confirm-page tableAllOrder">
        @if (session('error'))
            <div class="confirm-error" role="alert">{{ session('error') }}</div>
        @endif

        <h3 class="confirm-title red">ご注文製品の仕様</h3>
        <table class="confirm-table TableAllL">
            <tbody>
                @foreach ($specificationRows as $row)
                    <tr>
                        <td class="confirm-label TableLeft">{{ $row['label'] }}</td>
                        <td class="confirm-value TableRight">{{ $displayValue($row['value']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3 class="confirm-title red">製作料金</h3>
        <table class="confirm-table confirm-price-table TableAllL">
            <tbody>
                @foreach ($displayPriceRows as $row)
                    @php
                        $isTotalRow = ($row['kind'] ?? '') === 'total' || trim((string) ($row['label'] ?? '')) === '合計(税込)';
                    @endphp
                    <tr>
                        <td class="confirm-label TableLeft @if ($isTotalRow) confirm-total-label @endif">{{ $row['label'] }}</td>
                        <td class="confirm-value confirm-amount TableRightPrice1 @if ($isTotalRow) confirm-total-value @endif">{{ $formatAmount($row['amount']) }}</td>
                        <td class="confirm-price-spacer TableRightPrice2">&nbsp;</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3 class="confirm-title red">ご入稿データ</h3>
        <table class="confirm-table TableAllL">
            <tbody>
                @forelse ($customerFiles as $file)
                    <tr>
                        <td class="confirm-label TableLeft">お客様ご入稿データ</td>
                        <td class="confirm-value TableRight">{{ $displayValue($file['name'] ?? '') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="confirm-label TableLeft">お客様ご入稿データ</td>
                        <td class="confirm-value confirm-value--muted TableRight">-</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h3 class="confirm-title red">お客様情報</h3>
        <table class="confirm-table TableAllL">
            <tbody>
                <tr>
                    <td class="confirm-label TableLeft">E-mail</td>
                    <td class="confirm-value TableRight">{{ $displayValue($customer['email'] ?? '') }}</td>
                </tr>
                <tr>
                    <td class="confirm-label TableLeft">お名前</td>
                    <td class="confirm-value TableRight">{{ $displayValue($customer['name'] ?? '') }}</td>
                </tr>
                <tr>
                    <td class="confirm-label TableLeft">お名前（フリカナ）</td>
                    <td class="confirm-value TableRight">{{ $displayValue($customer['furigana'] ?? '') }}</td>
                </tr>
                <tr>
                    <td class="confirm-label TableLeft">TEL</td>
                    <td class="confirm-value TableRight">{{ $displayValue($customer['tel'] ?? '') }}</td>
                </tr>
                <tr>
                    <td class="confirm-label TableLeft">お客様・配送先情報</td>
                    <td class="confirm-value TableRight">{{ $addressMethodLabel }}</td>
                </tr>
            </tbody>
        </table>

        @if ($addressMethod === 'add_form')
            <table class="confirm-table TableAllL">
                <tbody>
                    <tr>
                        <td class="confirm-label TableLeft">お客様区分</td>
                        <td class="confirm-value TableRight">{{ $customerTypeLabel }}</td>
                    </tr>
                    <tr>
                        <td class="confirm-label TableLeft">法人名</td>
                        <td class="confirm-value TableRight">{{ $displayValue($customer['company'] ?? '') }}</td>
                    </tr>
                    <tr>
                        <td class="confirm-label TableLeft">法人名（フリガナ）</td>
                        <td class="confirm-value TableRight">{{ $displayValue($customer['company_kana'] ?? '') }}</td>
                    </tr>
                    <tr>
                        <td class="confirm-label TableLeft">お客様部署名</td>
                        <td class="confirm-value TableRight">{{ $displayValue($customer['department'] ?? '') }}</td>
                    </tr>
                    <tr>
                        <td class="confirm-label TableLeft">郵便番号</td>
                        <td class="confirm-value TableRight">{{ $displayValue($customer['postal_code'] ?? '') }}</td>
                    </tr>
                    <tr>
                        <td class="confirm-label TableLeft">都道府県</td>
                        <td class="confirm-value TableRight">{{ $displayValue($customer['prefecture'] ?? '') }}</td>
                    </tr>
                    <tr>
                        <td class="confirm-label TableLeft">以降の住所</td>
                        <td class="confirm-value TableRight">{{ $displayValue($customer['address'] ?? '') }}</td>
                    </tr>
                    <tr>
                        <td class="confirm-label TableLeft">番地、建物名、部屋番号</td>
                        <td class="confirm-value TableRight">{{ $displayValue($customer['address_street'] ?? '') }}</td>
                    </tr>
                </tbody>
            </table>

            @if ($deliveryType === 'different')
                <table class="confirm-table TableAllL">
                    <tbody>
                        <tr>
                            <td class="confirm-label TableLeft">配送先名称<br>（会社名、表札）</td>
                            <td class="confirm-value TableRight">{{ $displayValue($customer['delivery_name'] ?? '') }}</td>
                        </tr>
                        <tr>
                            <td class="confirm-label TableLeft">郵便番号</td>
                            <td class="confirm-value TableRight">{{ $displayValue($customer['delivery_postal_code'] ?? '') }}</td>
                        </tr>
                        <tr>
                            <td class="confirm-label TableLeft">都道府県</td>
                            <td class="confirm-value TableRight">{{ $displayValue($customer['delivery_prefecture'] ?? '') }}</td>
                        </tr>
                        <tr>
                            <td class="confirm-label TableLeft">以降の住所</td>
                            <td class="confirm-value TableRight">{{ $displayValue($customer['delivery_address'] ?? '') }}</td>
                        </tr>
                        <tr>
                            <td class="confirm-label TableLeft">番地、建物名、部屋番号</td>
                            <td class="confirm-value TableRight">{{ $displayValue($customer['delivery_address_street'] ?? '') }}</td>
                        </tr>
                        <tr>
                            <td class="confirm-label TableLeft">配送先TEL<br>ハイフンなし</td>
                            <td class="confirm-value TableRight">{{ $displayValue($customer['delivery_tel'] ?? '') }}</td>
                        </tr>
                    </tbody>
                </table>
            @else
                <table class="confirm-table TableAllL">
                    <tbody>
                        <tr>
                            <td class="confirm-label TableLeft" colspan="2">連絡先住所と同じ</td>
                        </tr>
                    </tbody>
                </table>
            @endif
        @elseif ($addressMethod === 'message_box')
            <table class="confirm-table TableAllL">
                <tbody>
                    <tr>
                        <td class="confirm-label TableLeft">メール署名</td>
                        <td class="confirm-value TableRight">{{ $displayValue($customer['contact_detail'] ?? '') }}</td>
                    </tr>
                </tbody>
            </table>
        @endif

        <table class="confirm-table TableAllL">
            <tbody>
                <tr>
                    <td class="confirm-label TableLeft">ご連絡事項</td>
                    <td class="confirm-value TableRight">{{ $displayValue($customer['contact_detail_2'] ?? '特記事項なし') }}</td>
                </tr>
            </tbody>
        </table>

        <table class="confirm-table TableAllL">
            <tbody>
                <tr>
                    <td class="confirm-label TableLeft">お支払い情報</td>
                    <td class="confirm-value TableRight">{{ $displayValue($customer['payment'] ?? '') }}</td>
                </tr>
                <tr>
                    <td class="confirm-label TableLeft">メルマガ</td>
                    <td class="confirm-value TableRight">{{ ! empty($customer['newsletter']) ? 'メルマガを受け取る' : 'メルマガを受け取らない' }}</td>
                </tr>
            </tbody>
        </table>

        <form method="POST" action="{{ route('products.complete', ['productPath' => $product->slug]) }}" class="confirm-submit-form">
            @csrf
            <div class="confirm-actions">
                <a class="confirm-action btn btn-back" href="{{ route('products.show', ['productPath' => $product->slug]) }}">ご注文情報修正</a>
                <a class="confirm-action btn btn-back" href="{{ route('products.customer', ['productPath' => $product->slug]) }}">お客様情報修正</a>
                <button type="submit" class="confirm-action confirm-action--final btn btn-next">ご注文確定</button>
            </div>
        </form>
    </main>
@endsection
