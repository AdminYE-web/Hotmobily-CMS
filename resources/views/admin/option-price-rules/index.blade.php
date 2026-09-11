@extends('admin.layouts.app')

@section('title', 'Option Price Rules')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Option Price Rules</h1>
                <p class="text-muted mb-0">Product-specific additional pricing by option conditions and quantity.</p>
            </div>

            <a href="{{ route('admin.option-price-rules.create') }}" class="btn btn-primary">+ Add Option Price Rule</a>
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
                                <th>Price Type</th>
                                <th>Replace Option</th>
                                <th>Conditions</th>
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
                                    <td><span class="badge badge-info">{{ $rule->price_type === 'per_piece' ? 'Per piece' : 'Per order' }}</span></td>
                                    <td>
                                        {{ $rule->targetOption?->option_name ?? '-' }}
                                        <div class="small text-muted"><code>{{ $rule->targetOption?->option_code }}</code></div>
                                    </td>
                                    <td>
                                        @forelse ($rule->conditions as $condition)
                                            <span class="badge badge-light border mr-1 mb-1">{{ $condition->productOption?->option_name ?? '-' }}</span>
                                        @empty
                                            <span class="text-muted">Any</span>
                                        @endforelse
                                    </td>
                                    <td>{{ number_format((float) $rule->tax_rate, 2) }}%</td>
                                    <td>{{ $rule->tiers_count }}</td>
                                    <td>
                                        <a href="{{ route('admin.option-price-rules.edit', $rule) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="text-center text-muted py-4">No Option Price Rules created yet.</td></tr>
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
