@extends('admin.layouts.app')

@section('title', $isEditing ? 'Edit User Manual Menu Item' : 'Add User Manual Menu Item')

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">{{ $isEditing ? 'Edit User Manual link' : 'Add User Manual link' }}</h1>
                <p class="text-muted mb-0">This link appears after the fixed ご利用ガイド link.</p>
            </div>
            <a href="{{ route('admin.user-manual-menu.index') }}" class="btn btn-outline-secondary mt-2 mt-md-0">Back to User Manual</a>
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
                        Create a Custom Page first, then return here to add it to User Manual.
                        <a href="{{ route('admin.custom-pages.index') }}" class="alert-link">Open Custom Pages</a>
                    </div>
                @else
                    <form method="POST" action="{{ $isEditing ? route('admin.user-manual-menu.update', $item) : route('admin.user-manual-menu.store') }}">
                        @csrf
                        @if ($isEditing)
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="user-manual-menu-name">Menu title <span class="text-danger">*</span></label>
                            <input
                                id="user-manual-menu-name"
                                name="name"
                                type="text"
                                class="form-control"
                                maxlength="255"
                                required
                                value="{{ old('name', $item->name) }}"
                                placeholder="学校・塾向けノベルティ"
                            >
                        </div>

                        <div class="form-group">
                            <label for="user-manual-page-id">Custom Page <span class="text-danger">*</span></label>
                            <select id="user-manual-page-id" name="custom_page_id" class="form-control" required>
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
                            <a href="{{ route('admin.user-manual-menu.index') }}" class="btn btn-outline-secondary mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">{{ $isEditing ? 'Save changes' : 'Add menu item' }}</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
