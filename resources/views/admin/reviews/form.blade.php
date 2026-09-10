@extends('admin.layouts.app')

@section('title', $isEditing ? 'Edit review' : 'Add review')

@section('content')
    @php
        $imageNames = collect(explode(',', (string) $review->images))
            ->map(static fn (string $name): string => basename(trim($name)))
            ->filter()
            ->values();
    @endphp

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">{{ $isEditing ? 'Edit review' : 'Add review' }}</h1>
                <p class="text-muted mb-0">口コミ(参照)</p>
            </div>
            <a href="{{ route('admin.reviews.index') }}" class="btn btn-outline-secondary">&larr; Back</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="{{ $isEditing ? route('admin.reviews.update', $review) : route('admin.reviews.store') }}">
                    @csrf
                    @if ($isEditing)
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea id="comment" name="comment" rows="6" class="form-control @error('comment') is-invalid @enderror">{{ old('comment', $review->comment) }}</textarea>
                        @error('comment')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="date_reviews">Date</label>
                            <input id="date_reviews" type="datetime-local" name="date_reviews" value="{{ old('date_reviews', $review->date_reviews?->format('Y-m-d\\TH:i')) }}" class="form-control @error('date_reviews') is-invalid @enderror" required>
                            @error('date_reviews')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group col-md-2">
                            <label for="service">Service</label>
                            <input id="service" type="number" min="1" max="5" name="service" value="{{ old('service', $review->service) }}" class="form-control @error('service') is-invalid @enderror">
                            @error('service')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group col-md-2">
                            <label for="product">Product</label>
                            <input id="product" type="number" min="1" max="5" name="product" value="{{ old('product', $review->product) }}" class="form-control @error('product') is-invalid @enderror">
                            @error('product')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="sale_name">Sales person</label>
                            <input id="sale_name" type="text" name="sale_name" value="{{ old('sale_name', $review->sale_name) }}" class="form-control @error('sale_name') is-invalid @enderror">
                            @error('sale_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="product_type">Product type</label>
                        <input id="product_type" type="text" name="product_type" value="{{ old('product_type', $review->product_type) }}" class="form-control @error('product_type') is-invalid @enderror">
                        @error('product_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    @if ($imageNames->isNotEmpty())
                        <div class="form-group">
                            <label>Current images</label>
                            <div class="d-flex flex-wrap">
                                @foreach ($imageNames as $imageName)
                                    <a class="mr-2 mb-2" href="{{ asset('reviews/upload/'.rawurlencode($imageName)) }}" target="_blank" rel="noopener">
                                        <img src="{{ asset('reviews/upload/'.rawurlencode($imageName)) }}" alt="Review image" class="admin-review-image">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="images">Upload images</label>
                        <input id="images" type="file" name="images[]" accept="image/*" multiple class="form-control-file @error('images.*') is-invalid @enderror">
                        <small class="form-text text-muted">New files are added to the existing images. Maximum size: 5 MB per file.</small>
                        @error('images.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary">{{ $isEditing ? 'Update' : 'Add' }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>.admin-review-image { width: 90px; height: 90px; object-fit: cover; }</style>
@endpush
