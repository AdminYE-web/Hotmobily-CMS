@extends('admin.layouts.app')

@section('title', $isEditing ? 'Edit Side Menu Link' : 'Add Side Menu Link')

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">{{ $isEditing ? 'Edit Side Menu link' : 'Add Side Menu link' }}</h1>
                <p class="text-muted mb-0">Set the image, accessible title, and destination for a sidebar banner.</p>
            </div>
            <a href="{{ route('admin.side-menu.links.index') }}" class="btn btn-outline-secondary mt-2 mt-md-0">Back to Side Menu links</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="{{ $isEditing ? route('admin.side-menu.links.update', $item) : route('admin.side-menu.links.store') }}">
                    @csrf
                    @if ($isEditing) @method('PUT') @endif

                    <div class="form-group">
                        <label for="side-menu-link-name">Name / image description <span class="text-danger">*</span></label>
                        <input id="side-menu-link-name" name="name" type="text" class="form-control" maxlength="255" required value="{{ old('name', $item->name) }}">
                        <small class="form-text text-muted">Used as the image alt text and link title.</small>
                    </div>

                    <div class="form-group">
                        <label for="side-menu-link-url">Link <span class="text-danger">*</span></label>
                        <input id="side-menu-link-url" name="url" type="text" class="form-control" maxlength="2048" required value="{{ old('url', $item->url) }}" placeholder="/meeting_date/ or https://example.com">
                        <small class="form-text text-muted">Use a path starting with / for this website, or a complete http(s) URL.</small>
                    </div>

                    <div class="form-group">
                        <label for="side-menu-link-image">Image @unless($isEditing)<span class="text-danger">*</span>@endunless</label>
                        <input id="side-menu-link-image" name="image" type="file" class="form-control-file" accept=".jpg,.jpeg,.png,.webp,.avif,image/*" @required(! $isEditing)>
                        <small class="form-text text-muted">JPG, PNG, WebP, or AVIF; maximum 10 MB. Sidebar banners display at up to 225 px wide, preserving their aspect ratio.</small>
                        @if ($isEditing)
                            <div class="mt-2">
                                <img src="{{ Storage::disk('public')->url($item->image_path) }}" alt="{{ $item->name }}" style="max-width:225px;max-height:225px;width:auto;height:auto;border:1px solid #ddd">
                                <div class="small text-muted mt-1">Current image. Upload a replacement to change it.</div>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.side-menu.links.index') }}" class="btn btn-outline-secondary mr-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">{{ $isEditing ? 'Save changes' : 'Add link' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
