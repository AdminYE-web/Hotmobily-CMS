@extends('admin.layouts.app')

@section('title', 'Gallery Pages')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">Gallery Pages</h1>
                <p class="text-muted mb-0">Create gallery pages while keeping all items in the legacy hm_acrylic_gallery table.</p>
            </div>
            <a href="{{ route('admin.gallery-pages.create') }}" class="btn btn-success">Add gallery page</a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Order</th>
                                <th>Page</th>
                                <th>Database type</th>
                                <th>Image directory</th>
                                <th>Items</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($galleryPages as $page)
                                <tr>
                                    <td>{{ $page->sort_order }}</td>
                                    <td>
                                        <strong>{{ $page->name }}</strong>
                                        <div class="small text-muted">Admin: /admin/galleries/{{ $page->slug }}</div>
                                        <div class="small text-muted">Public: /gallery/{{ $page->public_slug }}</div>
                                    </td>
                                    <td><code>{{ $page->gallery_type }}</code></td>
                                    <td><code>{{ $page->media_directory }}</code></td>
                                    <td>{{ $page->items_count }}</td>
                                    <td>
                                        <span class="badge badge-{{ $page->is_active ? 'success' : 'secondary' }}">
                                            {{ $page->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('admin.gallery-items.index', $page) }}" class="btn btn-sm btn-outline-success">Items</a>
                                        <a href="{{ route('gallery.show', $page->public_slug) }}" class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener">Public</a>
                                        <a href="{{ route('admin.gallery-pages.edit', $page) }}" class="btn btn-sm btn-outline-primary">Settings</a>
                                        @if ($page->items_count === 0)
                                            <form method="POST" action="{{ route('admin.gallery-pages.destroy', $page) }}" class="d-inline" onsubmit="return confirm('Delete this empty gallery page?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted py-5">No gallery pages found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
