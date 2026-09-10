@extends('admin.layouts.app')

@section('title', '口コミ(参照)')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">口コミ(参照)</h1>
                <p class="text-muted mb-0">Customer reviews stored in this Laravel system.</p>
            </div>

        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="GET" action="{{ route('admin.reviews.index') }}" id="review-filter-form" class="admin-review-filter mb-3" autocomplete="off">
            <a href="{{ route('admin.reviews.create') }}" class="btn btn-info admin-review-filter-add">Add New</a>

            <div class="admin-review-filter-range">
                <input
                    id="daterange"
                    type="text"
                    name="daterange"
                    value="{{ request('daterange') }}"
                    placeholder="Date range"
                    class="form-control @error('daterange') is-invalid @enderror"
                >
                @error('daterange')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <select id="sale_name" name="sale_name" class="form-control admin-review-filter-sales">
                <option value="">---</option>
                @foreach ($saleNames as $saleName)
                    <option value="{{ $saleName }}" @selected(request('sale_name') === $saleName)>{{ $saleName }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary admin-review-filter-button">Search</button>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-danger admin-review-filter-button">Clear</a>
            <button type="submit" name="export" value="1" class="btn btn-success admin-review-filter-button">Export Excel</button>
        </form>

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Review list</strong>
                <span class="text-muted small">{{ $reviews->total() }} review(s)</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0 admin-review-table">
                        <thead class="thead-light">
                            <tr>
                                <th>Date</th>
                                <th>Comment</th>
                                <th>Service</th>
                                <th>Product</th>
                                <th>Product type</th>
                                <th>Sales person</th>
                                <th>Reply</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reviews as $review)
                                <tr>
                                    <td class="text-nowrap">{{ $review->date_reviews?->format('Y-m-d H:i') ?? '-' }}</td>
                                    <td class="review-comment">{!! nl2br(e($review->comment ?: '-')) !!}</td>
                                    <td>{{ $review->service ?? '-' }}</td>
                                    <td>{{ $review->product ?? '-' }}</td>
                                    <td>{{ $review->product_type ?: '-' }}</td>
                                    <td>{{ $review->sale_name ?: '-' }}</td>
                                    <td class="text-center">{{ $review->answers_count ?? 0 }}</td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('admin.reviews.edit', $review) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        @if (($review->answers_count ?? 0) === 0)
                                            <a href="{{ route('admin.review-answers.create', $review) }}" class="btn btn-sm btn-outline-success">Answer</a>
                                        @else
                                            <a href="{{ route('admin.review-answers.index') }}" class="btn btn-sm btn-outline-secondary">Reply list</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">No reviews found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($reviews->hasPages())
            <div class="mt-3">{{ $reviews->links() }}</div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .admin-review-filter { display: flex; align-items: flex-start; gap: .45rem; width: 100%; }
        .admin-review-filter-add, .admin-review-filter-button { flex: 0 0 10%; min-height: 38px; }
        .admin-review-filter-range { flex: 1 1 35%; }
        .admin-review-filter-sales { flex: 1 1 30%; min-width: 180px; }
        .admin-review-table th { white-space: nowrap; }
        .admin-review-table .review-comment { min-width: 280px; white-space: normal; }

        @media (max-width: 991.98px) {
            .admin-review-filter { flex-wrap: wrap; }
            .admin-review-filter-add, .admin-review-filter-button { flex: 1 1 calc(33.333% - .45rem); }
            .admin-review-filter-range, .admin-review-filter-sales { flex: 1 1 calc(50% - .45rem); }
        }

        @media (max-width: 575.98px) {
            .admin-review-filter-add, .admin-review-filter-button, .admin-review-filter-range, .admin-review-filter-sales { flex-basis: 100%; }
        }
    </style>
@endpush

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(function () {
            $('#daterange').daterangepicker({
                autoUpdateInput: false,
                locale: { cancelLabel: 'Clear' },
            });

            $('#daterange').on('apply.daterangepicker', function (event, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));
            });

            $('#daterange').on('cancel.daterangepicker', function () {
                $(this).val('');
            });
        });
    </script>
@endpush
