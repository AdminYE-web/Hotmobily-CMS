@extends('admin.layouts.app')

@section('title', $isEditing ? 'Edit Production Details Menu Item' : 'Add Production Details Menu Item')

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">{{ $isEditing ? 'Edit Production Details link' : 'Add Production Details link' }}</h1>
                <p class="text-muted mb-0">Set the navigation title and choose the Custom Page it opens.</p>
            </div>
            <a href="{{ route('admin.custom-page-menu.index') }}" class="btn btn-outline-secondary mt-2 mt-md-0">Back to Production Details</a>
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
                        Create a Custom Page first, then return here to add it to Production Details.
                        <a href="{{ route('admin.custom-pages.index') }}" class="alert-link">Open Custom Pages</a>
                    </div>
                @else
                    <form method="POST" action="{{ $isEditing ? route('admin.custom-page-menu.update', $item) : route('admin.custom-page-menu.store') }}">
                        @csrf
                        @if ($isEditing)
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="custom-page-menu-name">Menu title <span class="text-danger">*</span></label>
                            <input
                                id="custom-page-menu-name"
                                name="name"
                                type="text"
                                class="form-control"
                                maxlength="255"
                                required
                                value="{{ old('name', $item->name) }}"
                                placeholder="デザインの壺（ラバー製品）"
                            >
                        </div>

                        <div class="form-group">
                            <label for="custom-page-id">Custom Page <span class="text-danger">*</span></label>
                            <select id="custom-page-id" name="custom_page_id" class="form-control" required>
                                <option value="">-- Select a Custom Page --</option>
                                @foreach ($pages as $page)
                                    @php($isSelected = (string) old('custom_page_id', $item->custom_page_id) === (string) $page->id)
                                    <option
                                        value="{{ $page->id }}"
                                        @selected($isSelected)
                                        @disabled(in_array((int) $page->id, $usedPageIds, true) && ! $isSelected)
                                    >
                                        {{ $page->name }} — /{{ trim($page->slug, '/') }} ({{ $page->status }}){{ in_array((int) $page->id, $usedPageIds, true) && ! $isSelected ? ' — already added' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Only active Custom Pages with published content and a published layout appear in the storefront menu.</small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.custom-page-menu.index') }}" class="btn btn-outline-secondary mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">{{ $isEditing ? 'Save changes' : 'Add menu item' }}</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
