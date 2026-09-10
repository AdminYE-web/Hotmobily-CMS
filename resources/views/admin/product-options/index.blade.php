@extends('admin.layouts.app')

@section('title', 'Product Options')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Product Options</h1>
                <p class="text-muted mb-0">Option definitions grouped by Option Group. Product assignment will be added later.</p>
            </div>

            <a href="{{ route('admin.product-options.create') }}" class="btn btn-primary">+ Add Product Option</a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Option list</strong>
                <span class="text-muted small">{{ $productOptions->total() }} option(s)</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 70px;">No.</th>
                                <th>Option Group</th>
                                <th>Option Code</th>
                                <th>Option Name</th>
                                <th>Color</th>
                                <th>Images</th>
                                <th>Active</th>
                                <th style="width: 110px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($productOptions as $productOption)
                                <tr>
                                    <td>{{ $productOptions->firstItem() + $loop->index }}</td>
                                    <td>
                                        <code>{{ $productOption->optionGroup?->group_code ?? '-' }}</code>
                                        <div class="small text-muted">{{ $productOption->optionGroup?->group_name }}</div>
                                    </td>
                                    <td><code>{{ $productOption->option_code }}</code></td>
                                    <td>{{ $productOption->option_name }}</td>
                                    <td>
                                        @if ($productOption->color_code)
                                            <span class="d-inline-block border rounded mr-1 align-middle" style="width: 20px; height: 20px; background: {{ $productOption->color_code }};"></span>
                                            <code>{{ $productOption->color_code }}</code>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ count($productOption->option_images ?? []) }}</td>
                                    <td><span class="badge badge-{{ $productOption->is_active ? 'success' : 'secondary' }}">{{ $productOption->is_active ? 'Active' : 'Inactive' }}</span></td>
                                    <td><a href="{{ route('admin.product-options.edit', $productOption) }}" class="btn btn-sm btn-outline-primary">Edit</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center text-muted py-4">No Product Options created yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($productOptions->hasPages())
            <div class="mt-3">{{ $productOptions->links() }}</div>
        @endif
    </div>
@endsection
