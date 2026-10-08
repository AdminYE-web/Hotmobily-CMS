@extends('admin.layouts.app')

@section('title', $isEditing ? 'Edit Home Banner' : 'Add Home Banner')

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">{{ $isEditing ? 'Edit Home Banner' : 'Add Home Banner' }}</h1>
                <p class="text-muted mb-0">Upload desktop and optional mobile artwork, then set the destination link.</p>
            </div>
            <a href="{{ route('admin.home-settings.banners.index') }}" class="btn btn-outline-secondary mt-2 mt-md-0">Back to Home Banners</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="{{ $isEditing ? route('admin.home-settings.banners.update', $item) : route('admin.home-settings.banners.store') }}">
                    @csrf
                    @if ($isEditing) @method('PUT') @endif

                    <div class="form-group">
                        <label for="home-banner-image">Desktop image @unless($isEditing)<span class="text-danger">*</span>@endunless</label>
                        <input id="home-banner-image" name="image" type="file" class="form-control-file" accept=".jpg,.jpeg,.png,.webp,.avif,image/*" @required(! $isEditing)>
                        <small class="form-text text-muted">JPG, PNG, WebP, or AVIF; maximum 20 MB.</small>
                        @if ($isEditing)
                            <div class="mt-2"><img src="{{ $item->desktop_image_url }}" alt="{{ $item->alt_text }}" style="max-width:100%;width:385px;height:120px;object-fit:contain;border:1px solid #ddd"></div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="home-banner-mobile-image">Mobile image</label>
                        <input id="home-banner-mobile-image" name="mobile_image" type="file" class="form-control-file" accept=".jpg,.jpeg,.png,.webp,.avif,image/*">
                        <small class="form-text text-muted">Optional. If omitted, the desktop image is used on mobile.</small>
                        @if ($isEditing && $item->mobile_image_path)
                            <div class="mt-2"><img src="{{ $item->mobile_image_url }}" alt="" style="max-width:100%;width:192px;height:120px;object-fit:contain;border:1px solid #ddd"></div>
                            <div class="form-check mt-2">
                                <input type="hidden" name="remove_mobile_image" value="0">
                                <input id="remove-mobile-image" name="remove_mobile_image" value="1" type="checkbox" class="form-check-input">
                                <label for="remove-mobile-image" class="form-check-label">Remove mobile image and use the desktop image instead</label>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="home-banner-link">Link URL</label>
                        <input id="home-banner-link" name="link_url" type="text" class="form-control" maxlength="2048" value="{{ old('link_url', $item->link_url) }}" placeholder="/products/example/ or https://example.com">
                        <small class="form-text text-muted">Use a site path beginning with / or a full http/https URL. Leave blank for a non-clickable slide.</small>
                    </div>

                    <div class="form-group">
                        <label for="home-banner-alt">Image alt text</label>
                        <input id="home-banner-alt" name="alt_text" type="text" class="form-control" maxlength="255" value="{{ old('alt_text', $item->alt_text) }}">
                    </div>

                    <div class="form-check mb-4">
                        <input type="hidden" name="is_active" value="0">
                        <input id="home-banner-active" name="is_active" value="1" type="checkbox" class="form-check-input" @checked((bool) old('is_active', $isEditing ? $item->is_active : true))>
                        <label for="home-banner-active" class="form-check-label">Show this banner on the homepage</label>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.home-settings.banners.index') }}" class="btn btn-outline-secondary mr-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">{{ $isEditing ? 'Save changes' : 'Add Home Banner' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
