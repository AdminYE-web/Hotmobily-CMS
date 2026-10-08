@extends('admin.layouts.app')

@section('title', $isEditing ? 'Edit Gallery Menu Item' : 'Add Gallery Menu Item')

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">{{ $isEditing ? 'Edit Gallery menu item' : 'Add Gallery menu item' }}</h1>
                <p class="text-muted mb-0">Set the navigation label and select the Gallery page it opens.</p>
            </div>
            <a href="{{ route('admin.gallery-menu.index') }}" class="btn btn-outline-secondary mt-2 mt-md-0">Back to Gallery menu</a>
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
                        Create a Gallery page first, then return here to add it to navigation.
                        <a href="{{ route('admin.gallery-pages.index') }}" class="alert-link">Open Gallery pages</a>
                    </div>
                @else
                    <form method="POST" action="{{ $isEditing ? route('admin.gallery-menu.update', $item) : route('admin.gallery-menu.store') }}">
                        @csrf
                        @if ($isEditing)
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="gallery-menu-name">Menu title <span class="text-danger">*</span></label>
                            <input
                                id="gallery-menu-name"
                                name="name"
                                type="text"
                                class="form-control"
                                maxlength="255"
                                required
                                value="{{ old('name', $item->name) }}"
                                placeholder="ラバーストラップ"
                            >
                        </div>

                        <div class="form-group">
                            <label for="gallery-page-id">Gallery page <span class="text-danger">*</span></label>
                            <select id="gallery-page-id" name="gallery_page_id" class="form-control" required>
                                <option value="">-- Select a Gallery page --</option>
                                @foreach ($pages as $page)
                                    @php($isSelected = (string) old('gallery_page_id', $item->gallery_page_id) === (string) $page->id)
                                    <option
                                        value="{{ $page->id }}"
                                        @selected($isSelected)
                                        @disabled(in_array((int) $page->id, $usedPageIds, true) && ! $isSelected)
                                    >
                                        {{ $page->name }} — /gallery/{{ $page->public_slug }}{{ $page->is_active ? '' : ' — inactive' }}{{ in_array((int) $page->id, $usedPageIds, true) && ! $isSelected ? ' — already added' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Inactive Gallery pages can be configured, but are hidden from the storefront navigation until activated.</small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.gallery-menu.index') }}" class="btn btn-outline-secondary mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">{{ $isEditing ? 'Save changes' : 'Add menu item' }}</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
