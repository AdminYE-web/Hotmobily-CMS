@extends('admin.layouts.app')

@section('title', $isEditing ? 'Edit Product Data Menu Item' : 'Add Product Data Menu Item')

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">{{ $isEditing ? 'Edit menu item' : 'Add menu item' }}</h1>
                <p class="text-muted mb-0">Set the link title and select the Product Data page it should open.</p>
            </div>
            <a href="{{ route('admin.product-data-menu.index') }}" class="btn btn-outline-secondary mt-2 mt-md-0">Back to menu settings</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                @if ($pages->isEmpty())
                    <div class="alert alert-warning mb-0">
                        Create a Product Data page first, then return here to add it to the navigation.
                        <a href="{{ route('admin.product-data.index') }}" class="alert-link">Open Product Data</a>
                    </div>
                @else
                    <form method="POST" action="{{ $isEditing ? route('admin.product-data-menu.update', $item) : route('admin.product-data-menu.store') }}">
                        @csrf
                        @if ($isEditing)
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="menu-item-name">Menu title <span class="text-danger">*</span></label>
                            <input
                                id="menu-item-name"
                                name="name"
                                type="text"
                                class="form-control"
                                maxlength="255"
                                required
                                value="{{ old('name', $item->name) }}"
                                placeholder="例：ラバー製品"
                            >
                            <small class="form-text text-muted">This title is displayed as the navigation link text.</small>
                        </div>

                        <div class="form-group">
                            <label for="product-data-page-id">Product Data page <span class="text-danger">*</span></label>
                            <select id="product-data-page-id" name="product_data_page_id" class="form-control" required>
                                <option value="">-- Select a Product Data page --</option>
                                @foreach ($pages as $page)
                                    @php
                                        $isSelected = (string) old('product_data_page_id', $item->product_data_page_id) === (string) $page->id;
                                    @endphp
                                    <option
                                        value="{{ $page->id }}"
                                        @selected($isSelected)
                                        @disabled(in_array((int) $page->id, $usedPageIds, true) && ! $isSelected)
                                    >
                                        {{ $page->name }} — /products/{{ $page->slug }} ({{ $page->status }}){{ in_array((int) $page->id, $usedPageIds, true) && ! $isSelected ? ' — already added' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Draft or inactive pages can be prepared here, but only active pages with published content appear in the customer navigation.</small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.product-data-menu.index') }}" class="btn btn-outline-secondary mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">{{ $isEditing ? 'Save changes' : 'Add menu item' }}</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
