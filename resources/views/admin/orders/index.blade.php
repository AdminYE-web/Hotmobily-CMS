@extends('admin.layouts.app')

@section('title', 'HMご注文 | Hotmobily')

@section('content')
    <div class="container-fluid admin-orders-page">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">HMご注文</h1>
                <p class="text-muted mb-0">注文履歴を検索・確認できます。</p>
            </div>

            <a
                href="{{ route('admin.orders.export', array_merge(request()->query(), ['export' => 1])) }}"
                class="btn btn-success"
            >
                Export
            </a>
        </div>

        @if (isset($errors) && $errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form
            method="GET"
            action="{{ route('admin.orders.index') }}"
            class="card card-body shadow-sm mb-3 admin-orders-filter"
        >
            <div class="form-row align-items-end">
                <div class="form-group col-lg-4 col-md-6">
                    <label for="order-search">Search</label>
                    <input
                        id="order-search"
                        type="search"
                        name="q"
                        value="{{ request('q') }}"
                        class="form-control"
                        placeholder="Order ID / email / product"
                    >
                </div>

                <div class="form-group col-lg-2 col-md-3">
                    <label for="order-date-from">Date from</label>
                    <input
                        id="order-date-from"
                        type="date"
                        name="date_from"
                        value="{{ request('date_from') }}"
                        class="form-control"
                    >
                </div>

                <div class="form-group col-lg-2 col-md-3">
                    <label for="order-date-to">Date to</label>
                    <input
                        id="order-date-to"
                        type="date"
                        name="date_to"
                        value="{{ request('date_to') }}"
                        class="form-control"
                    >
                </div>

                <div class="form-group col-lg-2 col-md-4">
                    <label for="order-payment">Payment</label>
                    <select id="order-payment" name="payment" class="form-control">
                        <option value="">All payments</option>
                        @foreach ($payments as $payment)
                            <option value="{{ $payment }}" @selected(request('payment') === $payment)>
                                {{ $payment }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-lg-2 col-md-4 d-flex mb-lg-3">
                    <button type="submit" class="btn btn-primary mr-2">Search</button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">Clear</a>
                </div>
            </div>
        </form>

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Order list</strong>
                <span class="text-muted small">{{ number_format($orders->total()) }} order(s)</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="hm-orders-table" class="table table-bordered table-hover mb-0 admin-orders-table">
                        <thead class="thead-light">
                            <tr>
                                <th>Date</th>
                                <th>Orders ID</th>
                                <th>Price</th>
                                <th>Payment</th>
                                <th>Email</th>
                                <th>シミュレーター</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                @php
                                    $payment = trim((string) ($order->payment ?? ''));
                                    $transaction = trim((string) ($order->transaction_id ?? ''));
                                    $paymentDisplay = $transaction !== '' && str_contains($payment, 'クレジット')
                                        ? $transaction
                                        : $payment;
                                    $isSimulator = str_contains((string) ($order->file_upload_cus ?? ''), 'sim_');
                                @endphp
                                <tr>
                                    <td class="text-nowrap">
                                        {{ $order->order_date ? \Illuminate\Support\Carbon::parse($order->order_date)->format('Y-m-d') : '-' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', ['order' => $order->order_id]) }}">
                                            {{ $order->order_id }}
                                        </a>
                                        @if (!empty($order->product))
                                            <small class="d-block text-muted">{{ $order->product }}</small>
                                        @endif
                                    </td>
                                    <td class="text-right text-nowrap">
                                        {{ number_format((float) ($order->price ?? 0), 0) }}
                                    </td>
                                    <td>{{ $paymentDisplay !== '' ? $paymentDisplay : '-' }}</td>
                                    <td class="text-nowrap">{{ $order->email ?: '-' }}</td>
                                    <td class="text-center text-nowrap">
                                        {{ $isSimulator ? 'シミュレーター使用' : '不使用' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No orders found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($orders->hasPages())
            <div class="mt-3">{{ $orders->links() }}</div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .admin-orders-page { padding-bottom: 2rem; }
        .admin-orders-filter label { font-size: .85rem; font-weight: 600; margin-bottom: .25rem; }
        .admin-orders-table th { white-space: nowrap; }
        .admin-orders-table td { vertical-align: middle; }

        @media (max-width: 767.98px) {
            .admin-orders-page > .d-flex { align-items: flex-start !important; gap: .75rem; }
            .admin-orders-page > .d-flex .btn { flex-shrink: 0; }
        }
    </style>
@endpush
