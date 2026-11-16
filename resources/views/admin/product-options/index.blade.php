@extends('admin.layouts.app')

@section('title', 'Product Options')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Product Options</h1>
                <p class="text-muted mb-0">Option definitions grouped by Option Group. Product assignment will be added later.</p>
            </div>

            <div class="d-flex flex-wrap" style="gap:8px">
                <button type="button" class="btn btn-outline-primary" id="toggle-bulk-options" aria-expanded="false" aria-controls="bulk-options-panel">Bulk upload images</button>
                <a href="{{ route('admin.product-options.create') }}" class="btn btn-primary">+ Add Product Option</a>
            </div>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <section class="card shadow-sm mb-4" id="bulk-options-panel" data-upload-url="{{ route('admin.product-options.bulk-upload') }}" hidden>
            <div class="card-header"><strong>Bulk upload: one image creates one Product Option</strong></div>
            <div class="card-body">
                <p class="text-muted">Select an Option Group and up to 200 images. Each filename without its extension becomes the Option Name and Code. Duplicate codes receive _2, _3, etc. Options are created as Active and can be edited afterwards.</p>
                <div class="form-row">
                    <div class="form-group col-md-6"><label for="bulk-option-group">Option Group <span class="text-danger">*</span></label>
                        <select id="bulk-option-group" class="form-control"><option value="">Choose an Option Group...</option>@foreach ($optionGroups as $group)<option value="{{ $group->id }}">{{ $group->group_name }} ({{ $group->group_code }})</option>@endforeach</select>
                    </div>
                    <div class="form-group col-md-6"><label for="bulk-option-images">Images</label><input id="bulk-option-images" type="file" class="form-control-file" accept="image/jpeg,image/png,image/gif,image/webp,image/bmp" multiple><small class="form-text text-muted">JPG, PNG, GIF, WebP or BMP. Maximum 5 MB per image. Files upload one at a time; 50 images create 50 options.</small></div>
                </div>
                <div class="alert alert-danger" id="bulk-option-error" role="alert" hidden></div>
                <div class="table-responsive" style="max-height:450px;overflow:auto" id="bulk-option-queue" hidden>
                    <table class="table table-sm table-bordered" style="min-width:640px"><thead class="thead-light"><tr><th style="width:80px">Image</th><th>Filename / Option Name</th><th>Option Code</th><th>Status</th><th></th></tr></thead><tbody id="bulk-option-rows"></tbody></table>
                </div>
                <p class="small text-muted">Names are limited to 255 characters and codes to 100. Existing options are kept. Selecting files again replaces this queue; options already created remain saved.</p>
                <div class="d-flex flex-wrap align-items-center" style="gap:8px">
                    <button type="button" class="btn btn-primary" id="bulk-option-start" disabled>Upload &amp; Create Options</button>
                    <button type="button" class="btn btn-outline-secondary" id="bulk-option-stop" hidden>Stop after current image</button>
                    <button type="button" class="btn btn-outline-success" id="bulk-option-refresh" hidden>Refresh option list</button>
                    <span id="bulk-option-progress" role="status" aria-live="polite"></span>
                </div>
            </div>
        </section>

        @php($hasFilters = $filters['q'] !== '' || $filters['group'] !== '' || $filters['status'] !== '' || $filters['disabled'] !== '')

        <form method="GET" action="{{ route('admin.product-options.index') }}" class="card shadow-sm mb-3">
            <div class="card-body">
                <div class="form-row align-items-end">
                    <div class="col-md-3 mb-2 mb-md-0">
                        <label for="filter-q" class="small text-muted mb-1">Search</label>
                        <input type="search" id="filter-q" name="q" value="{{ $filters['q'] }}" class="form-control" placeholder="Option code or option name">
                    </div>
                    <div class="col-md-3 mb-2 mb-md-0">
                        <label for="filter-group" class="small text-muted mb-1">Option Group</label>
                        <select id="filter-group" name="group" class="form-control">
                            <option value="">All</option>
                            @foreach ($filterGroups as $group)
                                <option value="{{ $group->id }}" @selected($filters['group'] === (string) $group->id)>{{ $group->group_name }} ({{ $group->group_code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-2 mb-md-0">
                        <label for="filter-disabled" class="small text-muted mb-1">Disabled</label>
                        <select id="filter-disabled" name="disabled" class="form-control">
                            <option value="">All</option>
                            <option value="yes" @selected($filters['disabled'] === 'yes')>Yes</option>
                            <option value="no" @selected($filters['disabled'] === 'no')>No</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2 mb-md-0">
                        <label for="filter-status" class="small text-muted mb-1">Active</label>
                        <select id="filter-status" name="status" class="form-control">
                            <option value="">All</option>
                            <option value="active" @selected($filters['status'] === 'active')>Active</option>
                            <option value="inactive" @selected($filters['status'] === 'inactive')>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex">
                        <button type="submit" class="btn btn-primary flex-fill mr-2">Search</button>
                        @if ($hasFilters)
                            <a href="{{ route('admin.product-options.index') }}" class="btn btn-outline-secondary">Clear</a>
                        @endif
                    </div>
                </div>
            </div>
        </form>

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
                                <th>Disabled</th>
                                <th>Active</th>
                                <th style="width: 160px;">Action</th>
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
                                    <td><span class="badge badge-{{ $productOption->is_disabled ? 'danger' : 'secondary' }}">{{ $productOption->is_disabled ? 'Yes' : 'No' }}</span></td>
                                    <td><span class="badge badge-{{ $productOption->is_active ? 'success' : 'secondary' }}">{{ $productOption->is_active ? 'Active' : 'Inactive' }}</span></td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('admin.product-options.edit', $productOption) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('admin.product-options.destroy', $productOption) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this option?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="text-center text-muted py-4">{{ $hasFilters ? 'No options match your search.' : 'No Product Options created yet.' }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($productOptions->hasPages())
            <div class="mt-3">{{ $productOptions->links('pagination::bootstrap-4') }}</div>
        @endif
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/js/product-options-bulk-upload.js') }}?v={{ filemtime(public_path('admin/js/product-options-bulk-upload.js')) }}"></script>
@endpush
