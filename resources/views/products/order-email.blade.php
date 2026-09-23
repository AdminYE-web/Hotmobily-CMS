@php
    $display = static function ($value): string {
        $value = trim((string) $value);

        return $value === '' ? '-' : $value;
    };
    $formatAmount = static fn ($amount): string => number_format((int) $amount).'円';
    $orderPayload = is_array($orderPayload ?? null) ? $orderPayload : [];
    $customer = is_array($customer ?? null) ? $customer : [];
    $completeHeadHtml = trim((string) (app(\App\Support\RichTextSanitizer::class)->sanitize($product->complete_head_text ?? '') ?? ''));

    $normalizeRows = static function ($rows): \Illuminate\Support\Collection {
        return collect(is_array($rows) ? $rows : [])
            ->filter(static fn ($row): bool => is_array($row) && trim((string) ($row['label'] ?? '')) !== '')
            ->map(static fn (array $row): array => [
                'label' => trim((string) ($row['label'] ?? '')),
                'value' => (string) ($row['value'] ?? ''),
                'amount' => (int) ($row['amount'] ?? 0),
                'kind' => (string) ($row['kind'] ?? ''),
            ])
            ->values();
    };

    $summaryRows = $normalizeRows($summaryRows ?? []);
    if ($summaryRows->isEmpty() && ! array_key_exists('complete_summary_present', $orderPayload)) {
        foreach (['order_summary', 'summary'] as $fallbackKey) {
            $fallbackRows = $normalizeRows($orderPayload[$fallbackKey] ?? []);
            if ($fallbackRows->isNotEmpty()) {
                $summaryRows = $fallbackRows;
                break;
            }
        }
    }

    $priceRows = $normalizeRows($priceRows ?? []);
    if ($priceRows->isEmpty() && ! array_key_exists('complete_price_rows_present', $orderPayload)) {
        $priceRows = $normalizeRows($orderPayload['price_rows'] ?? []);
    }

    $orderValues = collect(is_array($orderValues ?? null) ? $orderValues : [])
        ->filter(static fn ($field): bool => is_array($field) && trim((string) ($field['name'] ?? '')) !== '')
        ->map(static fn (array $field): array => [
            'name' => trim((string) ($field['name'] ?? '')),
            'value' => (string) ($field['value'] ?? ''),
        ])
        ->values();
    $customerFiles = collect(is_array($customerFiles ?? null) ? $customerFiles : [])
        ->filter(static fn ($file): bool => is_array($file) && trim((string) ($file['name'] ?? '')) !== '')
        ->values();

    $quantity = max(1, (int) ($orderPayload['quantity'] ?? 1));
    $totalAmount = (int) ($orderPayload['total_amount'] ?? 0);
    $subtotalAmount = (int) ($orderPayload['subtotal_amount'] ?? $totalAmount);
    $discountAmount = (int) ($orderPayload['discount_amount'] ?? 0);
    $shippingAmount = (int) ($orderPayload['shipping_amount'] ?? 0);

    if ($priceRows->isEmpty()) {
        $priceRows = collect([
            ['label' => '商品代金', 'amount' => 0, 'kind' => 'product'],
            ['label' => '小計(税込)', 'amount' => $subtotalAmount, 'kind' => 'subtotal'],
            ['label' => 'お値引き', 'amount' => $discountAmount, 'kind' => 'discount'],
            ['label' => '送料計', 'amount' => $shippingAmount, 'kind' => 'charge'],
            ['label' => '合計(税込)', 'amount' => $totalAmount, 'kind' => 'total'],
        ]);
    }

    // The legacy template always shows shipping immediately before the total.
    $displayPriceRows = collect();
    $shippingInserted = false;
    foreach ($priceRows as $row) {
        $label = trim((string) ($row['label'] ?? ''));
        $isShippingRow = $label === '送料計';
        $isTotalRow = ($row['kind'] ?? '') === 'total' || $label === '合計(税込)';

        if ($isShippingRow) {
            $shippingInserted = true;
        }

        if ($isTotalRow && ! $shippingInserted) {
            $displayPriceRows->push([
                'label' => '送料計',
                'amount' => $shippingAmount,
                'kind' => 'charge',
            ]);
            $shippingInserted = true;
        }

        $displayPriceRows->push($row);
    }
    if (! $shippingInserted) {
        $displayPriceRows->push([
            'label' => '送料計',
            'amount' => $shippingAmount,
            'kind' => 'charge',
        ]);
    }

    $addressMethod = (string) ($customer['address_method'] ?? '');
    $deliveryType = (string) ($customer['delivery_type'] ?? 'same');
    $customerType = (string) ($customer['cstKBN'] ?? '');
    $payment = trim((string) ($customer['payment'] ?? ''));
    $addressMethodLabel = [
        'add_form' => '詳細情報を全て入力する',
        'none' => '入力省略(営業より連絡します)',
        'message_box' => 'メールの署名等をコピーする',
        'event_calling' => 'コミケ直接搬入サービスを利用する',
    ][$addressMethod] ?? '-';
    $customerTypeLabel = [
        'Corp' => '法人のお客様',
        'Personal' => '個人のお客様',
        'Other' => 'その他の区分のお客様',
    ][$customerType] ?? '-';
    $deliveryTypeLabel = $deliveryType === 'different'
        ? '下記住所へ送付する'
        : '連絡先住所と同じ';
    $showcaseLabel = [
        'allow' => '制作実績の掲載を許可する（当Webサイト、SNS、Youtube等）',
        'deny' => '製作実績の掲載を許可しない',
    ][$customer['showcase'] ?? ''] ?? '-';
    $newsletterLabel = ! empty($customer['newsletter'])
        ? 'メルマガを受け取る'
        : 'メルマガを受け取らない';

    $summaryLabels = $summaryRows
        ->map(static fn (array $row): string => trim((string) ($row['label'] ?? '')))
        ->filter()
        ->all();
    $quantityLabel = ($product->slug ?? '') === 'rubberstrap'
        ? $quantity.'本'
        : (string) $quantity;
    $specificationRows = collect([
        ['label' => 'ご注文商品', 'value' => $product->name],
    ])->concat($summaryRows->map(static fn (array $row): array => [
        'label' => trim((string) ($row['label'] ?? '')),
        'value' => (string) ($row['value'] ?? ''),
    ]));
    if (! in_array('ご注文本数', $summaryLabels, true)) {
        $specificationRows->push([
            'label' => 'ご注文本数',
            'value' => $quantityLabel,
        ]);
    }
    if (! in_array('ご注文製品の写真・動画掲載', $summaryLabels, true)) {
        $specificationRows->push([
            'label' => 'ご注文製品の写真・動画掲載',
            'value' => $showcaseLabel,
        ]);
    }

    $previousDesignNumber = '';
    $previousDesignField = $orderValues->first(static function (array $field): bool {
        return str_contains($field['name'], 'previous_order_number')
            && trim($field['value']) !== '';
    });
    if (is_array($previousDesignField)) {
        $previousDesignNumber = trim($previousDesignField['value']);
    }

    $tableStyle = 'background-color:#F3F3F3; text-align:left; width:550px; border:1px solid #d0d0d0; border-collapse:collapse; font-family:Arial, "MS PGothic", "Verdana", sans-serif;';
    $sectionHeaderStyle = 'padding:5px 10px; background-color:#CC0000; color:#FFFFFF; font-size:14px; font-weight:bold; line-height:150%;';
    $labelStyle = 'padding:5px 10px; width:130px; font-weight:bold; background-color:#E5E5E5; border-bottom:1px solid #FFFFFF; vertical-align:top;';
    $valueStyle = 'padding:5px 10px; width:400px; background-color:#F3F3F3; border-bottom:1px solid #FFFFFF; white-space:pre-wrap; overflow-wrap:anywhere; vertical-align:top;';
    $priceLabelStyle = 'padding:5px 10px; width:130px; font-weight:bold; background-color:#E5E5E5; border-bottom:1px solid #FFFFFF; vertical-align:top;';
    $priceAmountStyle = 'padding:5px 10px; width:80px; background-color:#F3F3F3; border-bottom:1px solid #FFFFFF; text-align:right; white-space:nowrap; vertical-align:top;';
    $priceSpacerStyle = 'padding:5px 10px; width:320px; background-color:#F3F3F3; border-bottom:1px solid #FFFFFF;';
@endphp

<div style="width:550px; font-size:12px; line-height:150%; font-weight:bold; font-family:Arial, 'MS PGothic', 'Verdana', sans-serif; color:#281600;">
    {{ $display($customer['name'] ?? '') }} 様<br>
    @if ($completeHeadHtml !== '')
        <div style="font-weight:normal;">{!! $completeHeadHtml !!}</div>
    @else
        この度はホットモバイリーのショッピングサイトのご利用誠にありがとうございます。<br>
        {{ $product->name }} の製作開始までにお願いしたい事項がございます。大変お手数ですが、下記内容をご一読頂きますようお願い致します。
    @endif
</div>

@if ($completeHeadHtml === '')
<div style="width:550px; font-size:12px; line-height:150%; color:#666666; font-family:Arial, 'MS PGothic', 'Verdana', sans-serif;">
    <br>
    <b>【1．ご注文内容のご確認】</b><br>
    本メールにご注文内容を記載しておりますので、お間違いないかご確認ください。
    <br><br>

    <b>【2．製品完成図（完成イメージ）のご確認】</b><br>
    ご入稿デザインを元に製品完成図を作成します。製品完成図はご入稿デザインをご送付頂いた日の翌営業日までにメールにてお送りいたしますので、ご確認ください。
    <br><br>

    <b>【3．製作料金のお振込み】</b><br>
    製品完成図をご確認いただき、間違いなければ製作料金をご入金ください。<br>
    （※ご入金後は、メールにてご連絡ください。）<br>
    （※クレジットカードで決済頂いた方は、ご入金は不要です。）
    <br><br>

    <b>【４．製作開始】</b><br>
    弊社にてお支払いの確認ができましたら、製作を進行させていただきます。
    <br><br>
</div>
@endif

    <table border="0" cellpadding="0" cellspacing="0" style="{{ $tableStyle }}">
        <tr>
            <td colspan="3" style="{{ $sectionHeaderStyle }}">ご注文内容詳細</td>
        </tr>
        <tr>
            <td style="{{ $labelStyle }}">No.</td>
            <td colspan="2" style="{{ $valueStyle }}">{{ $display($orderNumber ?? '') }}</td>
        </tr>
        @foreach ($specificationRows as $row)
            <tr>
                <td style="{{ $labelStyle }}">{{ $row['label'] }}</td>
                <td colspan="2" style="{{ $valueStyle }}">{{ $display($row['value'] ?? '') }}</td>
            </tr>
        @endforeach
    </table>

    <br>
    <table border="0" cellpadding="0" cellspacing="0" style="{{ $tableStyle }}">
        <tr>
            <td colspan="3" style="{{ $sectionHeaderStyle }}">製作料金</td>
        </tr>
        @foreach ($displayPriceRows as $row)
            <tr>
                <td style="{{ $priceLabelStyle }}">{{ $row['label'] }}</td>
                <td style="{{ $priceAmountStyle }}">{{ $formatAmount($row['amount'] ?? 0) }}</td>
                <td style="{{ $priceSpacerStyle }}">&nbsp;</td>
            </tr>
        @endforeach
    </table>

    <br>
    <table border="0" cellpadding="0" cellspacing="0" style="{{ $tableStyle }}">
        <tr>
            <td colspan="3" style="{{ $sectionHeaderStyle }}">ご入稿デザイン</td>
        </tr>
        @forelse ($customerFiles as $file)
            @php
                $fileReference = trim((string) ($file['design_number'] ?? $file['reference'] ?? ''));
            @endphp
            <tr>
                <td style="{{ $labelStyle }}">お客様ご入稿データ</td>
                <td colspan="2" style="{{ $valueStyle }}">{{ $display($file['name'] ?? '') }}</td>
            </tr>
            <tr>
                <td style="{{ $labelStyle }}">ご入稿デザイン番号</td>
                <td colspan="2" style="{{ $valueStyle }}">{{ $display($fileReference) }}</td>
            </tr>
        @empty
            <tr>
                <td style="{{ $labelStyle }}">お客様ご入稿データ</td>
                <td colspan="2" style="{{ $valueStyle }}">-</td>
            </tr>
            <tr>
                <td style="{{ $labelStyle }}">ご入稿デザイン番号</td>
                <td colspan="2" style="{{ $valueStyle }}">-</td>
            </tr>
        @endforelse
    </table>

    @if ($previousDesignNumber !== '')
        <br>
        <table border="0" cellpadding="0" cellspacing="0" style="{{ $tableStyle }}">
            <tr>
                <td style="{{ $labelStyle }}">過去と同じデザイン</td>
                <td colspan="2" style="{{ $valueStyle }}">{{ $previousDesignNumber }}</td>
            </tr>
        </table>
    @endif

    <br>
    <table border="0" cellpadding="0" cellspacing="0" style="{{ $tableStyle }}">
        <tr>
            <td colspan="3" style="{{ $sectionHeaderStyle }}">お客様情報</td>
        </tr>
        <tr>
            <td style="{{ $labelStyle }}">お客様メールアドレス</td>
            <td colspan="2" style="{{ $valueStyle }}">{{ $display($customer['email'] ?? '') }}</td>
        </tr>
        <tr>
            <td style="{{ $labelStyle }}">お客様氏名</td>
            <td colspan="2" style="{{ $valueStyle }}">{{ $display($customer['name'] ?? '') }}</td>
        </tr>
        <tr>
            <td style="{{ $labelStyle }}">お客様氏名（フリガナ）</td>
            <td colspan="2" style="{{ $valueStyle }}">{{ $display($customer['furigana'] ?? '') }}</td>
        </tr>
        <tr>
            <td style="{{ $labelStyle }}">電話番号</td>
            <td colspan="2" style="{{ $valueStyle }}">{{ $display($customer['tel'] ?? '') }}</td>
        </tr>
        <tr>
            <td style="{{ $labelStyle }}">お客様・配送先情報</td>
            <td colspan="2" style="{{ $valueStyle }}">{{ $addressMethodLabel }}</td>
        </tr>

        @if ($addressMethod === 'add_form')
            <tr>
                <td style="{{ $labelStyle }}">お客様区分</td>
                <td colspan="2" style="{{ $valueStyle }}">{{ $customerTypeLabel }}</td>
            </tr>
            <tr>
                <td style="{{ $labelStyle }}">お客様法人名</td>
                <td colspan="2" style="{{ $valueStyle }}">{{ $display($customer['company'] ?? '') }}</td>
            </tr>
            <tr>
                <td style="{{ $labelStyle }}">お客様法人名（フリガナ）</td>
                <td colspan="2" style="{{ $valueStyle }}">{{ $display($customer['company_kana'] ?? '') }}</td>
            </tr>
            <tr>
                <td style="{{ $labelStyle }}">お客様部署名</td>
                <td colspan="2" style="{{ $valueStyle }}">{{ $display($customer['department'] ?? '') }}</td>
            </tr>
            <tr>
                <td style="{{ $labelStyle }}">郵便番号</td>
                <td colspan="2" style="{{ $valueStyle }}">{{ $display($customer['postal_code'] ?? '') }}</td>
            </tr>
            <tr>
                <td style="{{ $labelStyle }}">都道府県</td>
                <td colspan="2" style="{{ $valueStyle }}">{{ $display($customer['prefecture'] ?? '') }}</td>
            </tr>
            <tr>
                <td style="{{ $labelStyle }}">以降の住所</td>
                <td colspan="2" style="{{ $valueStyle }}">{{ $display($customer['address'] ?? '') }}</td>
            </tr>
            <tr>
                <td style="{{ $labelStyle }}">番地、建物名、部屋番号</td>
                <td colspan="2" style="{{ $valueStyle }}">{{ $display($customer['address_street'] ?? '') }}</td>
            </tr>
            <tr>
                <td style="{{ $labelStyle }}">商品送付先</td>
                <td colspan="2" style="{{ $valueStyle }}">{{ $deliveryTypeLabel }}</td>
            </tr>

            @if ($deliveryType === 'different')
                <tr>
                    <td style="{{ $labelStyle }}">配送先名称（会社名、表札）</td>
                    <td colspan="2" style="{{ $valueStyle }}">{{ $display($customer['delivery_name'] ?? '') }}</td>
                </tr>
                <tr>
                    <td style="{{ $labelStyle }}">配送先郵便番号</td>
                    <td colspan="2" style="{{ $valueStyle }}">{{ $display($customer['delivery_postal_code'] ?? '') }}</td>
                </tr>
                <tr>
                    <td style="{{ $labelStyle }}">配送先都道府県</td>
                    <td colspan="2" style="{{ $valueStyle }}">{{ $display($customer['delivery_prefecture'] ?? '') }}</td>
                </tr>
                <tr>
                    <td style="{{ $labelStyle }}">配送先以降の住所</td>
                    <td colspan="2" style="{{ $valueStyle }}">{{ $display($customer['delivery_address'] ?? '') }}</td>
                </tr>
                <tr>
                    <td style="{{ $labelStyle }}">配送先番地、建物名、部屋番号</td>
                    <td colspan="2" style="{{ $valueStyle }}">{{ $display($customer['delivery_address_street'] ?? '') }}</td>
                </tr>
                <tr>
                    <td style="{{ $labelStyle }}">配送先TEL（ハイフンなし）</td>
                    <td colspan="2" style="{{ $valueStyle }}">{{ $display($customer['delivery_tel'] ?? '') }}</td>
                </tr>
            @endif
        @elseif ($addressMethod === 'message_box')
            <tr>
                <td style="{{ $labelStyle }}">会社名やご住所の入ったメールの署名</td>
                <td colspan="2" style="{{ $valueStyle }}">{{ $display($customer['contact_detail'] ?? '') }}</td>
            </tr>
        @endif

        <tr>
            <td style="{{ $labelStyle }}">ご連絡事項</td>
            <td colspan="2" style="{{ $valueStyle }}">{{ $display($customer['contact_detail_2'] ?? '') }}</td>
        </tr>
        <tr>
            <td style="{{ $labelStyle }}">お支払い情報</td>
            <td colspan="2" style="{{ $valueStyle }}">{{ $display($payment) }}</td>
        </tr>
        <tr>
            <td style="{{ $labelStyle }}">メルマガ</td>
            <td colspan="2" style="{{ $valueStyle }}">{{ $newsletterLabel }}</td>
        </tr>
    </table>

    <br>
    <table border="0" cellpadding="0" cellspacing="0" style="{{ $tableStyle }}">
        <tr>
            <td colspan="2" style="{{ $sectionHeaderStyle }}">振込先銀行口座</td>
        </tr>
        <tr>
            <td colspan="2" style="{{ $valueStyle }}">■■■■■■■■■■■■■■■■■■■■■■■■■■■</td>
        </tr>
        <tr><td style="{{ $labelStyle }}">銀行名</td><td style="{{ $valueStyle }}">三菱UFJ銀行</td></tr>
        <tr><td style="{{ $labelStyle }}">口座名義</td><td style="{{ $valueStyle }}">ユーアンドアースカブシキガイシャ</td></tr>
        <tr><td style="{{ $labelStyle }}">店番</td><td style="{{ $valueStyle }}">119</td></tr>
        <tr><td style="{{ $labelStyle }}">支店名</td><td style="{{ $valueStyle }}">長原支店</td></tr>
        <tr><td style="{{ $labelStyle }}">口座番号</td><td style="{{ $valueStyle }}">1103739 (普通)</td></tr>
        <tr><td colspan="2" style="{{ $valueStyle }}">■■■■■■■■■■■■■■■■■■■■■■■■■■■</td></tr>
        <tr><td style="{{ $labelStyle }}">銀行名</td><td style="{{ $valueStyle }}">りそな銀行</td></tr>
        <tr><td style="{{ $labelStyle }}">口座名義</td><td style="{{ $valueStyle }}">ユー・アンド・アース株式会社</td></tr>
        <tr><td style="{{ $labelStyle }}">店番</td><td style="{{ $valueStyle }}">315</td></tr>
        <tr><td style="{{ $labelStyle }}">支店名</td><td style="{{ $valueStyle }}">錦糸町支店</td></tr>
        <tr><td style="{{ $labelStyle }}">口座番号</td><td style="{{ $valueStyle }}">0201584 (普通)</td></tr>
        <tr><td colspan="2" style="{{ $valueStyle }}">■■■■■■■■■■■■■■■■■■■■■■■■■■■</td></tr>
        <tr><td style="{{ $labelStyle }}">銀行名</td><td style="{{ $valueStyle }}">三井住友銀行</td></tr>
        <tr><td style="{{ $labelStyle }}">口座名義</td><td style="{{ $valueStyle }}">ユー・アンド・アース株式会社</td></tr>
        <tr><td style="{{ $labelStyle }}">店番</td><td style="{{ $valueStyle }}">026</td></tr>
        <tr><td style="{{ $labelStyle }}">支店名</td><td style="{{ $valueStyle }}">銀座支店</td></tr>
        <tr><td style="{{ $labelStyle }}">口座番号</td><td style="{{ $valueStyle }}">8732249 (普通)</td></tr>
        <tr><td colspan="2" style="{{ $valueStyle }}">■■■■■■■■■■■■■■■■■■■■■■■■■■■</td></tr>
        <tr><td style="{{ $labelStyle }}">銀行名</td><td style="{{ $valueStyle }}">PayPay銀行</td></tr>
        <tr><td style="{{ $labelStyle }}">口座名義</td><td style="{{ $valueStyle }}">ユーアンドアース（カ）ホットモバイリー</td></tr>
        <tr><td style="{{ $labelStyle }}">預金種目</td><td style="{{ $valueStyle }}">普通</td></tr>
        <tr><td style="{{ $labelStyle }}">店番</td><td style="{{ $valueStyle }}">002</td></tr>
        <tr><td style="{{ $labelStyle }}">支店名</td><td style="{{ $valueStyle }}">すずめ支店</td></tr>
        <tr><td style="{{ $labelStyle }}">口座番号</td><td style="{{ $valueStyle }}">6070126</td></tr>
        <tr><td colspan="2" style="{{ $valueStyle }}">■■■■■■■■■■■■■■■■■■■■■■■■■■■</td></tr>
        <tr><td style="{{ $labelStyle }}">銀行名</td><td style="{{ $valueStyle }}">ゆうちょ銀行</td></tr>
        <tr><td style="{{ $labelStyle }}">店名</td><td style="{{ $valueStyle }}">〇一八（読み ゼロイチハチ）</td></tr>
        <tr><td style="{{ $labelStyle }}">口座名義</td><td style="{{ $valueStyle }}">ユーアンドアース（カ）</td></tr>
        <tr><td style="{{ $labelStyle }}">記号</td><td style="{{ $valueStyle }}">10170</td></tr>
        <tr><td style="{{ $labelStyle }}">番号</td><td style="{{ $valueStyle }}">87556861 (普通)</td></tr>
        <tr><td colspan="2" style="{{ $valueStyle }}">■■■■■■■■■■■■■■■■■■■■■■■■■■■</td></tr>
        <tr><td style="{{ $labelStyle }}">銀行名</td><td style="{{ $valueStyle }}">東京ベイ信用金庫</td></tr>
        <tr><td style="{{ $labelStyle }}">口座名義</td><td style="{{ $valueStyle }}">ユー・アンド・アース株式会社</td></tr>
        <tr><td style="{{ $labelStyle }}">店番</td><td style="{{ $valueStyle }}">045</td></tr>
        <tr><td style="{{ $labelStyle }}">支店名</td><td style="{{ $valueStyle }}">豊洲支店</td></tr>
        <tr><td style="{{ $labelStyle }}">口座番号</td><td style="{{ $valueStyle }}">1234601</td></tr>
        <tr><td colspan="2" style="{{ $valueStyle }}">■■■■■■■■■■■■■■■■■■■■■■■■■■■</td></tr>
    </table>

    <br>
    <div style="width:550px; font-size:10px; line-height:120%; color:#888888; font-family:Arial, 'MS PGothic', 'Verdana', sans-serif;">
        <b>ご注文のキャンセルに関しまして</b><br>
        <div style="margin-left:15px;">
            ・ご注文確定前<br>
            <div style="margin-left:15px;">
                キャンセルが可能です。ご入金が完了している場合、製作基本料金及び諸費用（デザインのトレースを行った場合はその費用）を差し引いた金額をご指定の銀行口座にご返金致します。ご返金にかかります振込手数料はご負担下さい。又、銀行振込以外のご返金方法は行っておりません。<br>
            </div>
            <br>
            ・ご注文確定後（キャンセルをご希望される場合、製品の製作作業の進捗状況によりましてご返金金額が異なります。）<br>
            <div style="margin-left:15px;">
                ・量産開始前<br>
                <div style="margin-left:15px;">
                    量産開始前の場合、お振込み金額より製作基本料金、版型代金、試作品送付代金（お申し込みの場合）、デザイントレース料金（お申し込みの場合）を差し引いた金額をご指定の銀行口座にご返金致します。ご返金に必要な振込み手数料はご負担下さい。<br>
                </div>
                ・量産開始後<br>
                <div style="margin-left:15px;">
                    申し訳ございませんが、キャンセルをお受けできません。ご返金のご依頼に対しましても、お受けできません。
                </div>
            </div>
        </div>
    </div>
