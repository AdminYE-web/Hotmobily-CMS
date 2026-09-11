@extends('admin.layouts.app')

@section('title', 'Product Price Rules')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Product Price Rules</h1>
                <p class="text-muted mb-0">Base product pricing by required options and quantity tiers.</p>
            </div>

            <a href="{{ route('admin.product-price-rules.create') }}" class="btn btn-primary">+ Add Product Price Rule</a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Rule list</strong>
                <span class="text-muted small">{{ $rules->total() }} rule(s)</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 70px;">No.</th>
                                <th>Product</th>
                                <th>Rule Name</th>
                                <th>Required Options</th>
                                <th>Tax</th>
                                <th>Tiers</th>
                                <th style="width: 90px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rules as $rule)
                                <tr>
                                    <td>{{ $rules->firstItem() + $loop->index }}</td>
                                    <td>
                                        {{ $rule->product?->name ?? '-' }}
                                        <div class="small text-muted">{{ $rule->product?->slug }}</div>
                                    </td>
                                    <td>{{ $rule->rule_name }}</td>
                                    <td>
                                        @foreach ($rule->conditions as $condition)
                                            <span class="badge badge-light border mr-1 mb-1">{{ $condition->productOption?->option_name ?? '-' }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ number_format((float) $rule->tax_rate, 2) }}%</td>
                                    <td>{{ $rule->tiers_count }}</td>
                                    <td><a href="{{ route('admin.product-price-rules.edit', $rule) }}" class="btn btn-sm btn-outline-primary">Edit</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted py-4">No Product Price Rules created yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($rules->hasPages())
            <div class="mt-3">{{ $rules->links() }}</div>
        @endif
    </div>
@endsection
