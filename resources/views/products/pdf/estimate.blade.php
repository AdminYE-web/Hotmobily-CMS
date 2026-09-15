@php
    $customerInput = $customer ?? [];
    $customer = [
        'company' => trim((string) ($customerInput['company'] ?? '')),
        'postal_code' => trim((string) ($customerInput['postal_code'] ?? '')),
        'address' => collect([
            $customerInput['prefecture'] ?? '',
            $customerInput['address'] ?? '',
            $customerInput['address_street'] ?? '',
        ])->map(static fn ($part): string => trim((string) $part))->filter()->implode(' '),
        'tel' => trim((string) ($customerInput['tel'] ?? '')),
        'name' => collect([
            $customerInput['last_name'] ?? '',
            $customerInput['first_name'] ?? '',
        ])->map(static fn ($part): string => trim((string) $part))->filter()->implode(' '),
        'memo' => trim((string) ($customerInput['comment'] ?? '')),
    ];

    $lineItems = collect($priceRows)
        ->reject(static fn (array $row): bool => in_array($row['kind'], ['subtotal', 'discount', 'total'], true))
        ->values();
    $productRow = $lineItems->first(static fn (array $row): bool => $row['kind'] === 'product');
    $shippingRow = $lineItems->first(static fn (array $row): bool => str_contains($row['label'], '送料'));
    $numberedRows = $lineItems
        ->reject(static fn (array $row): bool => $row['kind'] === 'product' || str_contains($row['label'], '送料'))
        ->filter(static fn (array $row): bool => (int) $row['amount'] > 0)
        ->values();
    $numberedRowsTotal = (int) $numberedRows->sum('amount');
    $shippingAmount = (int) ($shippingRow['amount'] ?? 0);
    $productAmount = (int) ($productRow['amount'] ?? max(0, $subtotalAmount - $numberedRowsTotal - $shippingAmount));
    $productUnitPrice = $quantity > 0 ? (int) floor($productAmount / $quantity) : $productAmount;

    $deliveryRow = collect($summaryRows)->first(
        static fn (array $row): bool => in_array($row['label'], ['納期', '配送', '配送期間'], true)
    );
    $deliveryText = $deliveryRow['value'] ?? '量産品製作期間：100～300個まで10営業日、配送：2日、300～1,000個まで14営業日、配送：2日、3,000個まで22営業日、配送：2日';

    $bankGroups = [
        [
            ['銀行名 支店名', '三菱UFJ銀行 長原支店 （店番 119）'],
            ['銀行名 支店名', '三井住友銀行 銀座支店 （店番 026）'],
            ['口座番号', '1103739 (普通)'],
            ['口座番号', '8732249 (普通)'],
            ['口座名義', 'ユー・アンド・アース株式会社'],
            ['口座名義', 'ユー・アンド・アース株式会社'],
        ],
        [
            ['銀行名 支店名', 'りそな銀行 錦糸町支店 （店番 315）'],
            ['銀行名 支店名', 'PayPay銀行 すずめ支店 （店番 002）'],
            ['口座番号', '0201584 (普通)'],
            ['口座番号', '6070126 (普通)'],
            ['口座名義', 'ユー・アンド・アース株式会社'],
            ['口座名義', 'ユーアンドアース（カ）ホットモバイリー'],
        ],
        [
            ['銀行名 支店名', 'ゆうちょ銀行 〇一八（読み　ゼロイチハチ）'],
            ['銀行名 支店名', '東京ベイ信用金庫 豊洲支店 （店番 045）'],
            ['口座番号', '10170 - 87556861 (普通)'],
            ['口座番号', '1234601（普通）'],
            ['口座名義', 'ユーアンドアース（カ'],
            ['口座名義', 'ユー・アンド・アース株式会社'],
        ],
    ];
@endphp

<style>
    body {
        line-height: 1.6;
        font-family: "ヒラギノ角ゴ Pro W3", "Hiragino Kaku Gothic Pro", "メイリオ", Meiryo, Osaka, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif;
        -webkit-text-size-adjust: 100%;
        max-width: 595px;
    }
    .img_strap { max-width: 65%; }
    .head { width: 30%; }
    #head p { max-width: 100%; font-size: 8px; text-align: left; margin-top: -5px; }
    .left { max-width: 100%; font-size: 10px; text-align: left; margin-top: 0; }
    p b { font-size: 14px; text-decoration: underline; text-align: center; margin-top: 0; }
    .table_show { width: 100%; border: 1px solid black; border-collapse: collapse; }
    .table_show td { border: 1px solid black; font-size: 10px; }
    .table_show2 { width: 100%; border-collapse: collapse; }
    .table_show2 td { font-size: 10px; }
    table_last { width: 100%; border-spacing: 0; }
    .table_last_td { border: 1px solid black; width: 150px; font-size: 10px; }
    .table_cal { width: 100%; border-collapse: collapse; }
    .table_cal td { font-size: 10px; }
    .tab_bor td, th { border: 1px solid black; }
    .w150 { width: 12.5%; }
    .w528 { width: 50%; }
    .w100 { width: 5%; }
    .w250 { width: 25%; }
    .w365 { width: 35%; }
    .w480 { width: 45%; }
    b { font-size: 10px; }
    .center { text-align: center; }
    .right { text-align: right; }
    #img_hm { width: 25%; }
</style>

<table align="center">
    <tr>
        <td class="img_strap" style="width:45%;text-align:left;font-weight:900;">
            <img src="{{ asset('img/img_hb.png') }}" id="img_hm" width="280px">
        </td>
        <td style="width:55%;">
            <img src="{{ asset('img/stamp_pdf_hm.png') }}" id="image_stamp" style="float:right;border:none;">
        </td>
    </tr>
</table>

<p align="center">
    <span style="font-size:22px;">御見積書</span><br>
    <span style="font-size:10px;">この度はお見積のご請求、誠にありがとうございます。</span>
</p>

<table align="left" class="table_show">
    <tr>
        <th colspan="6"><p align="center" style="font-weight:100;font-size:14px;">お客様情報</p></th>
    </tr>
    <tr>
        <td class="w150"><span>お客様法人名</span></td>
        <td class="w528"><span>{{ $customer['company'] }}</span></td>
        <td class="w150"><span>発行日</span></td>
        <td class="w250"><span>{{ $issuedDate }}</span></td>
    </tr>
    <tr>
        <td rowspan="2"><span>ご住所</span></td>
        <td style="height:12px;"><span>{{ $customer['postal_code'] }}</span></td>
        <td><span>見積番号</span></td>
        <td><span>{{ $estimateNumber }}</span></td>
    </tr>
    <tr>
        <td style="height:12px;"><span>{{ $customer['address'] }}</span></td>
        <td rowspan="4"></td>
        <td rowspan="4"></td>
    </tr>
    <tr>
        <td><span>電話</span></td>
        <td><span>{{ $customer['tel'] }}</span></td>
    </tr>
    <tr>
        <td><span>ご担当者様</span></td>
        <td><span>{{ $customer['name'] }}{{ $customer['name'] !== '' ? ' 様' : '' }}</span></td>
    </tr>
    <tr>
        <td><span>お客様メモ欄</span></td>
        <td><span>{{ $customer['memo'] }}</span></td>
    </tr>
</table>

<div style="clear:both;">&nbsp;</div>

<table align="left" class="table_show">
    <tr>
        <th colspan="2"><p align="center" style="font-weight:100;font-size:14px;">製品の仕様・ご注文内容</p></th>
    </tr>
    <tr>
        <td class="w150" align="center"><span>ご注文商品</span></td>
        <td style="width:87.5%;"><span>{{ $product->name }}</span></td>
    </tr>
    @foreach ($summaryRows as $row)
        <tr>
            <td class="w150" align="center"><span>{{ $row['label'] }}</span></td>
            <td style="width:87.5%;"><span>{!! nl2br(e((string) $row['value'])) !!}</span></td>
        </tr>
    @endforeach
</table>

<div style="clear:both;line-height:0.6;">&nbsp;</div>

<table align="left" class="table_cal">
    <tr>
        <td style="width:20%;background-color:lightgray;border:1px solid black;font-size:18px;" rowspan="2">御見積金額</td>
        <td align="right" style="width:42.5%;font-size:18px;border-top:1px solid black;border-right:1px solid black;">￥{{ number_format($totalAmount) }}(税込)</td>
        <td style="width:37.5%;"></td>
    </tr>
    <tr>
        <td align="right" style="width:42.5%;border-right:1px solid black;border-bottom:1px solid black;">(内消費税 ￥{{ number_format($taxAmount) }})</td>
        <td style="width:37.5%;"></td>
    </tr>
</table>

<div style="clear:both;line-height:0.6;">&nbsp;</div>

<table align="center" class="table_cal" id="table_cal">
    <tr class="tab_bor">
        <th colspan="6"><p align="center" style="font-weight:100;font-size:14px;">製作料金</p></th>
    </tr>
    <tr class="tab_bor" style="background-color:lightgray;">
        <td class="w150" style="text-align:left;">番号:</td>
        <td class="w528"><center>商品</center></td>
        <td class="w150"><center>数量</center></td>
        <td class="w150"><center>単価</center></td>
        <td class="w150"><center>計</center></td>
    </tr>
    <tr class="tab_bor">
        <td class="w150" style="text-align:left;">1</td>
        <td class="w528" style="text-align:left;">{{ $product->name }}製作代金</td>
        <td class="w150"><center>{{ number_format($quantity) }}</center></td>
        <td class="w150"><center>{{ number_format($productUnitPrice) }}</center></td>
        <td class="w150" style="text-align:right;"><right>{{ number_format($productAmount) }}</right></td>
    </tr>
    @foreach ($numberedRows as $row)
        <tr class="tab_bor">
            <td class="w150" style="text-align:left;">{{ $loop->iteration + 1 }}</td>
            <td class="w528" style="text-align:left;">{{ $row['label'] }}</td>
            <td class="w150"><center>1</center></td>
            <td class="w150"><center>{{ number_format($row['amount']) }}</center></td>
            <td class="w150" style="text-align:right;"><right>{{ number_format($row['amount']) }}</right></td>
        </tr>
    @endforeach
    <tr>
        <td class="w150" style="border:1px solid white;"></td>
        <td class="w528"></td>
        <td class="w150"></td>
        <td class="w150" style="text-align:left;"><span>小計(税込)</span></td>
        <td class="w150" align="right" style="border:1px solid black;"><span>{{ number_format($subtotalAmount) }}</span></td>
    </tr>
    <tr>
        <td class="w150" style="border:1px solid white;"></td>
        <td class="w528"></td>
        <td class="w150"></td>
        <td class="w150" style="text-align:left;"><span>お値引き</span></td>
        <td class="w150" align="right" style="border:1px solid black;height:12px;"><span>{{ number_format($discountAmount) }}</span></td>
    </tr>
    <tr>
        <td class="w150" style="border:1px solid white;"></td>
        <td class="w528"></td>
        <td class="w150"></td>
        <td class="w150" style="text-align:left;"><span>送料計</span></td>
        <td class="w150" align="right" style="border:1px solid black;height:12px;"><span>{{ number_format($shippingAmount) }}</span></td>
    </tr>
    <tr>
        <td class="w150" style="border:1px solid white;"></td>
        <td class="w528" style="border:1px solid white;"></td>
        <td class="w150" style="border:1px solid white;"></td>
        <td class="w150" style="border-bottom:1px solid white;text-align:left;"><span>合計(税込)</span></td>
        <td class="w150" align="right" style="border:1px solid black;"><span>{{ number_format($totalAmount) }}</span></td>
    </tr>
</table>

<div style="clear:both;">&nbsp;</div>

<table align="left" class="table_show">
    <tr>
        <th colspan="2"><p align="center" style="font-weight:100;font-size:14px;">その他情報</p></th>
    </tr>
    <tr>
        <td class="w150"><span>お見積有効期限</span></td>
        <td style="width:87.5%;">発行日より30日</td>
    </tr>
    <tr>
        <td class="w150"><span>納期</span></td>
        <td style="width:87.5%;">{{ $deliveryText }}</td>
    </tr>
    <tr>
        <td class="w150"><span>お支払い条件</span></td>
        <td style="width:87.5%;">製作前のお支払をお願い致します。法人様の場合、後払い可能な場合もございます。</td>
    </tr>
    <tr>
        <td class="w150"><span>備考</span></td>
        <td style="width:87.5%;"><span style="color:red;">本見積はWeb上の選択内容をもとに作成されています。</span></td>
    </tr>
    <tr>
        <td class="w150" style="height:12px;"></td>
        <td style="width:87.5%;"></td>
    </tr>
</table>

<span class="left">ご注文はメールにて本見積番号を明記して頂き、contact@hotmobily.jp までご連絡下さいませ。</span>
<br>

<table align="center" class="table_show2">
    <tr>
        <th colspan="5" style="border:solid 1px white;">
            <p align="center" style="font-weight:900;font-size:14px;">製作代金お振込先銀行口座情報 (下記いづれかの口座にお振込み下さい)</p>
        </th>
    </tr>
    <tr>
        <td class="w150" style="height:12px;border-left:1px solid white;"></td>
        <td class="w365"></td>
        <td class="w100" style="border-bottom:1px solid white;"></td>
        <td class="w150"></td>
        <td class="w365" style="border-right:1px solid white;"></td>
    </tr>
    @foreach ($bankGroups as $bankGroup)
        <tr>
            <td class="w150" style="border:1px solid black;text-align:left;">{{ $bankGroup[0][0] }}</td>
            <td class="w365" style="border:1px solid black;text-align:left;">{{ $bankGroup[0][1] }}</td>
            <td class="w100"></td>
            <td class="w150" style="border:1px solid black;text-align:left;">{{ $bankGroup[1][0] }}</td>
            <td class="w365" style="border:1px solid black;text-align:left;">{{ $bankGroup[1][1] }}</td>
        </tr>
        <tr>
            <td class="w150" style="border:1px solid black;text-align:left;">{{ $bankGroup[2][0] }}</td>
            <td class="w365" style="border:1px solid black;text-align:left;">{{ $bankGroup[2][1] }}</td>
            <td class="w100"></td>
            <td class="w150" style="border:1px solid black;text-align:left;">{{ $bankGroup[3][0] }}</td>
            <td class="w365" style="border:1px solid black;text-align:left;">{{ $bankGroup[3][1] }}</td>
        </tr>
        <tr>
            <td class="w150" style="border:1px solid black;text-align:left;">{{ $bankGroup[4][0] }}</td>
            <td class="w365" style="border:1px solid black;text-align:left;">{{ $bankGroup[4][1] }}</td>
            <td class="w100"></td>
            <td class="w150" style="border:1px solid black;text-align:left;">{{ $bankGroup[5][0] }}</td>
            <td class="w365" style="border:1px solid black;text-align:left;">{{ $bankGroup[5][1] }}</td>
        </tr>
        @unless ($loop->last)
            <tr>
                <td class="w150" style="height:12px;border-left:1px solid white;"></td>
                <td class="w365"></td>
                <td class="w100" style="border-bottom:1px solid white;border-top:1px solid white;"></td>
                <td class="w150"></td>
                <td class="w365" style="border-right:1px solid white;"></td>
            </tr>
        @endunless
    @endforeach
</table>

<p class="left" style="margin-left:9.5%;">
    ※大変申し訳ございませんが、お振込み手数料はお客様のご負担とさせて頂きます。<br>
    ※適用税率10％<br>
    ※適格請求書発行事業者登録番号：T4-0106-0104-0555
</p>
