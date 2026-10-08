@extends('admin.layouts.app')

@section('title', $isEditing ? 'Edit Product Side Menu Item' : 'Add Product Side Menu Item')

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">{{ $isEditing ? 'Edit Product side menu item' : 'Add Product side menu item' }}</h1>
                <p class="text-muted mb-0">Set the title and image shown in the storefront sidebar, then choose the Product it opens.</p>
            </div>
            <a href="{{ route('admin.side-menu.products.index') }}" class="btn btn-outline-secondary mt-2 mt-md-0">Back to Product side menu</a>
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
                @if ($products->isEmpty())
                    <div class="alert alert-warning mb-0">Create a Product first, then return here to add it to the sidebar.</div>
                @else
                    <form method="POST" enctype="multipart/form-data" action="{{ $isEditing ? route('admin.side-menu.products.update', $item) : route('admin.side-menu.products.store') }}">
                        @csrf
                        @if ($isEditing)
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="product-side-menu-name">Menu title <span class="text-danger">*</span></label>
                            <input id="product-side-menu-name" name="name" type="text" class="form-control" maxlength="255" required value="{{ old('name', $item->name) }}">
                        </div>

                        <div class="form-group">
                            <label for="product-side-menu-product">Product <span class="text-danger">*</span></label>
                            <select id="product-side-menu-product" name="product_id" class="form-control" required>
                                <option value="">-- Select a Product --</option>
                                @foreach ($products as $product)
                                    @php($isSelected = (string) old('product_id', $item->product_id) === (string) $product->id)
                                    <option value="{{ $product->id }}" @selected($isSelected) @disabled(in_array((int) $product->id, $usedProductIds, true) && ! $isSelected)>
                                        {{ $product->name }} — /products/{{ trim($product->slug, '/') }} ({{ $product->status }}){{ in_array((int) $product->id, $usedProductIds, true) && ! $isSelected ? ' — already added' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">A Product can only be added once. Draft or unpublished Products will not appear in the public sidebar.</small>
                        </div>

                        <div class="form-group">
                            <label for="product-side-menu-image">Sidebar image @unless($isEditing)<span class="text-danger">*</span>@endunless</label>
                            <input id="product-side-menu-image" name="image" type="file" class="form-control-file" accept=".jpg,.jpeg,.png,.webp,.avif,image/*" @required(! $isEditing)>
                            <small class="form-text text-muted">JPG, PNG, WebP, or AVIF; maximum 10 MB. The storefront displays this image at 35 × 35 px.</small>
                            @if ($isEditing && $item->image_path !== '')
                                <div class="mt-2 d-flex align-items-center">
                                    <img src="{{ Storage::disk('public')->url($item->image_path) }}" alt="Current sidebar image" style="width:70px;height:70px;object-fit:cover;border:1px solid #ddd;border-radius:4px">
                                    <span class="ml-3 text-muted">Current image (upload a replacement to change it).</span>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.side-menu.products.index') }}" class="btn btn-outline-secondary mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">{{ $isEditing ? 'Save changes' : 'Add menu item' }}</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
