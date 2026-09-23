@extends('admin.layouts.app')

@section('title', $definition['label'])

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">{{ $definition['label'] }}</h1>
                <p class="text-muted mb-0">Manage customer product examples.</p>
            </div>

            <div class="d-flex">
                <a href="{{ route('gallery.show', $galleryPage->public_slug) }}" class="btn btn-outline-secondary mr-2" target="_blank" rel="noopener">Public page</a>
                <a href="{{ route('admin.gallery-pages.edit', $galleryPage) }}" class="btn btn-outline-primary mr-2">Page settings</a>
                <a href="{{ route('admin.gallery-items.create', $galleryPage) }}" class="btn btn-success">Create</a>
            </div>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Gallery list</strong>
                <span class="text-muted small">{{ $galleries->total() }} item(s)</span>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0 acrylic-gallery-table">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 90px;">ID</th>
                                <th>Images</th>
                                <th style="width: 130px;">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($galleries as $gallery)
                                @php($images = $gallery->imageNames())
                                <tr>
                                    <td class="align-middle">
                                        <a href="{{ route('admin.gallery-items.edit', [$galleryPage, $gallery]) }}">
                                            {{ $gallery->id }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($images !== [])
                                            <div class="d-flex flex-wrap align-items-center acrylic-gallery-previews">
                                                @foreach ($images as $image)
                                                    <a href="{{ $gallery->imageUrl($image, $definition['media_directory'], $definition['legacy_extension']) }}" target="_blank" rel="noopener">
                                                        <img
                                                            src="{{ $gallery->imageUrl($image, $definition['media_directory'], $definition['legacy_extension']) }}"
                                                            alt="{{ $definition['label'] }} #{{ $gallery->id }}"
                                                            loading="lazy"
                                                        >
                                                    </a>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <form
                                            method="POST"
                                            action="{{ route('admin.gallery-items.destroy', [$galleryPage, $gallery]) }}"
                                            onsubmit="return confirm('Do you want to delete this gallery item?');"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-5">No gallery items found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($galleries->hasPages())
            <div class="mt-3">{{ $galleries->links() }}</div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .acrylic-gallery-table th { white-space: nowrap; }
        .acrylic-gallery-previews { gap: .5rem; }
        .acrylic-gallery-previews img {
            display: block;
            width: 200px;
            height: 200px;
            object-fit: contain;
            border: 1px solid #dee2e6;
            background: #fff;
        }
    </style>
@endpush
