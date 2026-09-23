@extends('admin.layouts.app')

@section('title', $summary->order_id.' | HMご注文')

@section('content')
    <div class="container-fluid table_php admin-order-detail-page">
        <a href="{{ route('admin.orders.index') }}" class="admin-order-back">← BACK</a>

        <div class="row admin-order-detail-columns">
            <div class="col-lg-6 p-2 pl-lg-0">
                <div class="card mb-2">
                    <div class="card-body table-responsive p-2">
                        <table class="table table-bordered mb-0 admin-order-detail-table">
                            <tbody>
                                <tr>
                                    <td class="td-left">No.</td>
                                    <td class="td-right">{{ $summary->order_id }}</td>
                                </tr>
                                @php
                                    $strapType = $legacyLines->first()?->itemtype ?: ($summary->product ?: '-');
                                @endphp
                                <tr>
                                    <td class="td-left">ストラップ紐の種類</td>
                                    <td class="td-right">{{ $strapType }}</td>
                                </tr>
                                @foreach ($adminDetailSummaryRows as $row)
                                    <tr>
                                        <td class="td-left">{{ $row['label'] ?? '-' }}</td>
                                        <td class="td-right">{{ $row['value'] ?? '-' }}</td>
                                    </tr>
                                @endforeach

                                @foreach ($adminDetailPriceRows as $row)
                                    @php
                                        $priceValue = trim((string) ($row['value'] ?? ''));
                                        $priceAmount = $row['amount'] ?? null;
                                    @endphp
                                    <tr>
                                        <td class="td-left">{{ $row['label'] ?? '-' }}</td>
                                        <td class="td-right text-right">
                                            {{ $priceValue !== '' ? $priceValue : (is_numeric($priceAmount) ? number_format((float) $priceAmount) : '-') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mb-2">
                    <div class="card-header text-center">ご注文内容詳細</div>
                    <div class="card-body table-responsive p-2">
                        <table class="table table-bordered mb-0 admin-order-detail-table">
                            <tbody>
                                <tr>
                                    <td class="td-left">お客様メールアドレス</td>
                                    <td class="td-right">{{ $orderSubmission?->customer_email ?: ($summary->email ?: '-') }}</td>
                                </tr>
                                @php
                                    $customerLabels = [
                                        'name' => 'お客様氏名',
                                        'furigana' => 'お客様氏名（フリガナ）',
                                        'tel' => '電話番号',
                                        'newsletter' => 'メルマガ',
                                        'address_method' => 'お客様・配送先情報',
                                        'contact_detail' => '会社名やご住所の入ったメール',
                                        'contact_detail_2' => 'ご連絡事項',
                                        'payment' => 'お支払い情報',
                                        'customer_type' => 'お客様区分',
                                        'company' => '法人名',
                                        'company_furigana' => '法人名（フリガナ）',
                                        'department' => 'お客様部署名',
                                        'postal_code' => '郵便番号',
                                        'prefecture' => '都道府県',
                                        'address' => '以降の住所',
                                        'address_street' => '番地、建物名、部屋番号',
                                        'showcase' => '製品の本WEBサイトへの掲載',
                                        'delivery_destination' => '商品送付先',
                                    ];
                                @endphp
                                @foreach (($orderSubmission?->customer_data ?? []) as $key => $value)
                                    @if ($key !== 'email' && is_scalar($value) && filled($value))
                                        <tr>
                                            <td class="td-left">{{ $customerLabels[$key] ?? $key }}</td>
                                            <td class="td-right">{!! nl2br(e((string) $value)) !!}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                @if (!$orderSubmission?->customer_data && filled($summary->payment))
                                    <tr>
                                        <td class="td-left">お支払い情報</td>
                                        <td class="td-right">{{ $summary->payment }}</td>
                                    </tr>
                                @endif
                                @if (filled($summary->transaction_id))
                                    <tr>
                                        <td class="td-left">Transaction</td>
                                        <td class="td-right">{{ $summary->transaction_id }}</td>
                                    </tr>
                                @endif
                                @if ($eventData)
                                    <tr><td class="td-left" colspan="2">コミケ会場直接搬入サービス</td></tr>
                                    <tr><td class="td-left">参加日</td><td class="td-right">{{ $eventData->event_date ?? '-' }}</td></tr>
                                    <tr><td class="td-left">ホール名</td><td class="td-right">{{ $eventData->hall_name ?? '-' }}</td></tr>
                                    <tr><td class="td-left">ホール番号</td><td class="td-right">{{ $eventData->hall_number ?? '-' }}</td></tr>
                                    <tr><td class="td-left">スペース番号</td><td class="td-right">{{ $eventData->space_number ?? '-' }}</td></tr>
                                    <tr><td class="td-left">サークル名</td><td class="td-right">{{ $eventData->team_name ?? '-' }}</td></tr>
                                    <tr><td class="td-left">代表者名</td><td class="td-right">{{ $eventData->event_representative_name ?? '-' }}</td></tr>
                                    <tr><td class="td-left">当日連絡先の電話番号</td><td class="td-right">{{ $eventData->event_phone ?? '-' }}</td></tr>
                                @endif
                                @if ($orderSubmission?->customer_files)
                                    <tr>
                                        <td class="td-left">Uploaded files</td>
                                        <td class="td-right">
                                            @foreach ($orderSubmission->customer_files as $file)
                                                {{ $file['name'] ?? ($file['path'] ?? '-') }}<br>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 p-2 pr-lg-0">
                <div class="card mb-2">
                    <div class="card-header text-center">Order Management</div>
                    <div class="card-body table-responsive p-2">
                        <table class="table table-bordered mb-0 admin-order-detail-table">
                            <tbody>
                                <tr>
                                    <td class="td-left">Design Data</td>
                                    <td class="td-right">
                                        @if ($designRequest)
                                            Registered ({{ $designRequest->id ?? '-' }})
                                        @else
                                            <span class="text-muted">Not registered</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mb-2">
                    <div class="card-header text-center">Design Data information</div>
                    <div class="card-body table-responsive p-2">
                        <table class="table table-bordered mb-0 admin-order-detail-table">
                            <tbody>
                                @if ($designRequest || $designMaking)
                                    <tr><td class="td-left">Coordinator</td><td class="td-right">{{ $designMaking->co_name ?? $designRequest->co_name ?? '-' }}</td></tr>
                                    <tr><td class="td-left">Designer</td><td class="td-right">{{ $designMaking->designer_name ?? '-' }}</td></tr>
                                    <tr><td class="td-left">Status</td><td class="td-right">{{ $designRequest->status ?? '-' }}</td></tr>
                                    <tr><td class="td-left">カスタマーデザインです</td><td class="td-right">{{ $designMaking->cd_files ?? '-' }}</td></tr>
                                    <tr><td class="td-left">Designs uploaded</td><td class="td-right">{{ $designMaking->cd_files_uploaded ?? '-' }}</td></tr>
                                    <tr><td class="td-left">入稿データからの変更点</td><td class="td-right">{{ $designMaking->cd_files_details ?? '-' }}</td></tr>
                                @else
                                    <tr><td class="td-left">Status</td><td class="td-right"><span class="text-muted">Not registered</span></td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mb-2">
                    <div class="card-header text-center">Production Management</div>
                    <div class="card-body table-responsive p-2">
                        <table class="table table-bordered mb-0 admin-order-detail-table">
                            <tbody>
                                @if ($productionRequest)
                                    <tr><td class="td-left">Reference ID[order id]</td><td class="td-right">{{ $productionRequest->ref_id ?? $summary->order_id }}</td></tr>
                                    <tr><td class="td-left">PO Type</td><td class="td-right">{{ $productionRequest->po_type ?? '-' }}</td></tr>
                                    <tr><td class="td-left">Product Name</td><td class="td-right">{{ $productionRequest->prd_type ?? '-' }}</td></tr>
                                    <tr><td class="td-left">青海着希望納期</td><td class="td-right">{{ $productionRequest->shipping_date ?? '-' }}</td></tr>
                                    <tr><td class="td-left">顧客着希望納期</td><td class="td-right">{{ $productionRequest->customer_delivery_date ?? '-' }}</td></tr>
                                    <tr><td class="td-left">対象図面番号・PO番号</td><td class="td-right">{{ $productionRequest->po_data ?? '-' }}</td></tr>
                                    <tr><td class="td-left">Remarks</td><td class="td-right">{{ $productionRequest->remark ?? '-' }}</td></tr>
                                    <tr><td class="td-left">変更点</td><td class="td-right">{{ $productionRequest->changed_details ?? '-' }}</td></tr>
                                @else
                                    <tr><td class="td-left">Status</td><td class="td-right"><span class="text-muted">Not registered</span></td></tr>
                                    <tr><td class="td-left">Order status</td><td class="td-right">{{ $summary->status ?: 'legacy' }}</td></tr>
                                    <tr><td class="td-left">Total Price</td><td class="td-right">{{ number_format((float) ($summary->price ?? 0), 0) }}</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .admin-order-detail-page { padding-bottom: 2rem; }
        .admin-order-back { display: inline-block; margin: 0 0 .5rem; }
        .admin-order-detail-columns { margin-right: -.5rem; margin-left: -.5rem; }
        .admin-order-detail-table { table-layout: unset; width: 100%; }
        .admin-order-detail-table td { overflow-wrap: anywhere; vertical-align: top; }
        .admin-order-detail-table .td-left {
            width: 30%;
            background: #d9f1ff;
            color: #000;
            padding-left: 5px;
            text-align: left;
            white-space: normal;
        }
        .admin-order-detail-table .td-right { width: 70%; }
        .admin-order-detail-danger { color: red !important; }
        .admin-order-detail-page .card-header { font-weight: 600; }

        @media (max-width: 991.98px) {
            .admin-order-detail-columns { margin-right: 0; margin-left: 0; }
            .admin-order-detail-columns > [class*="col-"] { padding-right: 0 !important; padding-left: 0 !important; }
        }
    </style>
@endpush
