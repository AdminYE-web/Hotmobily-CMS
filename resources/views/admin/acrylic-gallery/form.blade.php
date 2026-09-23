@extends('admin.layouts.app')

@php
    $images = $gallery->imageNames();
@endphp

@section('title', $isEditing ? 'Edit '.$definition['label'] : 'Create '.$definition['label'])

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">{{ $isEditing ? 'Edit' : 'Add new' }} {{ $definition['label'] }}</h1>
                <p class="text-muted mb-0">The original page supports up to three images per gallery item.</p>
            </div>

            <a href="{{ route('admin.gallery-items.index', $galleryPage) }}" class="btn btn-outline-secondary">Back</a>
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
            <div class="card-header">{{ $isEditing ? 'Edit gallery item #'.$gallery->id : 'Add new gallery item' }}</div>
            <div class="card-body">
                <form
                    method="POST"
                    action="{{ $isEditing ? route('admin.gallery-items.update', [$galleryPage, $gallery]) : route('admin.gallery-items.store', $galleryPage) }}"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @if ($isEditing)
                        @method('PUT')
                    @endif

                    @if (! $isEditing)
                        <div class="form-group">
                            <label for="gallery-files">Images (up to 3)</label>
                            <input
                                id="gallery-files"
                                type="file"
                                name="files[]"
                                class="form-control-file"
                                accept="image/jpeg,image/png,image/webp,image/gif"
                                multiple
                            >
                            <small class="form-text text-muted">Choose up to three image files. JPG, PNG, WebP, or GIF; maximum 10 MB each.</small>
                        </div>
                    @else
                        <div class="form-group">
                            <label>Current images</label>
                            @if ($images !== [])
                                <div class="d-flex flex-wrap acrylic-gallery-existing-images">
                                    @foreach ($images as $image)
                                        <a href="{{ $gallery->imageUrl($image, $definition['media_directory'], $definition['legacy_extension']) }}" target="_blank" rel="noopener">
                                            <img src="{{ $gallery->imageUrl($image, $definition['media_directory'], $definition['legacy_extension']) }}" alt="Gallery image">
                                            <span>{{ $gallery->storedImageName($image, $definition['legacy_extension']) }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-muted">No images attached to this item.</div>
                            @endif
                            <label for="gallery-files" class="mt-3">Replace images (up to 3)</label>
                            <input
                                id="gallery-files"
                                type="file"
                                name="files[]"
                                class="form-control-file"
                                accept="image/jpeg,image/png,image/webp,image/gif"
                                multiple
                            >
                            <small class="form-text text-muted">
                                Leave this blank to keep the current images. Selecting one or more files replaces the complete image set. JPG, PNG, WebP, or GIF; maximum 10 MB each.
                            </small>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="arr-txt1">Tag</label>
                        <input id="arr-txt1" type="text" name="arr_txt1" value="{{ old('arr_txt1', $gallery->arr_txt1) }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="arr-txt2">Customer</label>
                        <input id="arr-txt2" type="text" name="arr_txt2" value="{{ old('arr_txt2', $gallery->arr_txt2) }}" class="form-control">
                    </div>

                    @if ($definition['website'])
                        <div class="form-group">
                            <label for="arr-web">Customer website (optional)</label>
                            <input id="arr-web" type="text" name="arr_web" value="{{ old('arr_web', $gallery->arr_web) }}" class="form-control">
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="arr-txt3">Production month</label>
                        <input id="arr-txt3" type="text" name="arr_txt3" value="{{ old('arr_txt3', $gallery->arr_txt3) }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="arr-txt4">Comment</label>
                        <textarea id="arr-txt4" name="arr_txt4" class="form-control" rows="3">{{ old('arr_txt4', $gallery->arr_txt4) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.gallery-items.index', $galleryPage) }}" class="btn btn-outline-secondary mr-2">Cancel</a>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .acrylic-gallery-existing-images { gap: 1rem; }
        .acrylic-gallery-existing-images a {
            display: inline-flex;
            flex-direction: column;
            width: 200px;
            color: inherit;
        }
        .acrylic-gallery-existing-images img {
            width: 200px;
            height: 200px;
            object-fit: contain;
            border: 1px solid #dee2e6;
            background: #fff;
        }
        .acrylic-gallery-existing-images span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: .8rem;
            margin-top: .25rem;
        }
    </style>
@endpush
