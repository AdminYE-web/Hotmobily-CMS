@extends('admin.layouts.app')

@section('title', $isEditing ? 'Edit Product Option' : 'Add Product Option')

@section('content')
    @php
        $imageNames = collect($productOption->option_images ?? [])
            ->map(static fn ($image): string => basename((string) $image))
            ->filter()
            ->values();
    @endphp

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">{{ $isEditing ? 'Edit Product Option' : 'Add Product Option' }}</h1>
                <p class="text-muted mb-0">Standalone option configuration; no Product is selected at this stage.</p>
            </div>

            <a href="{{ route('admin.product-options.index') }}" class="btn btn-outline-secondary">&larr; Back</a>
        </div>

        @if ($optionGroups->isEmpty())
            <div class="alert alert-warning">Create an active <a href="{{ route('admin.option-groups.create') }}">Option Group</a> before adding Product Options.</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" action="{{ $isEditing ? route('admin.product-options.update', $productOption) : route('admin.product-options.store') }}">
                    @csrf
                    @if ($isEditing)
                        @method('PUT')
                    @endif

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="option_group_id">Option Group <span class="text-danger">*</span></label>
                            <select id="option_group_id" name="option_group_id" class="form-control @error('option_group_id') is-invalid @enderror" required>
                                <option value="">-- Select Option Group --</option>
                                @foreach ($optionGroups as $optionGroup)
                                    <option value="{{ $optionGroup->id }}" @selected((string) old('option_group_id', $productOption->option_group_id) === (string) $optionGroup->id)>
                                        {{ $optionGroup->group_name }} ({{ $optionGroup->group_code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('option_group_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="option_code">Option Code <span class="text-danger">*</span></label>
                            <input id="option_code" name="option_code" type="text" value="{{ old('option_code', $productOption->option_code) }}" class="form-control @error('option_code') is-invalid @enderror" maxlength="100" pattern="[A-Za-z0-9_-]+" required>
                            <small class="form-text text-muted">Unique within the selected Option Group.</small>
                            @error('option_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="option_name">Option Name <span class="text-danger">*</span></label>
                            <input id="option_name" name="option_name" type="text" value="{{ old('option_name', $productOption->option_name) }}" class="form-control @error('option_name') is-invalid @enderror" maxlength="255" required>
                            @error('option_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="color_code">Color Code</label>
                            <input id="color_code" name="color_code" type="text" value="{{ old('color_code', $productOption->color_code) }}" class="form-control @error('color_code') is-invalid @enderror" placeholder="#FF0000" maxlength="20" pattern="#[0-9A-Fa-f]{3}([0-9A-Fa-f]{3})?">
                            @error('color_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="option_detail">Option Detail</label>
                        <textarea id="option_detail" name="option_detail" rows="5" class="form-control @error('option_detail') is-invalid @enderror" maxlength="10000">{{ old('option_detail', $productOption->option_detail) }}</textarea>
                        @error('option_detail')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    @if ($imageNames->isNotEmpty())
                        <div class="form-group">
                            <label>Current Option Images</label>
                            <div class="d-flex flex-wrap">
                                @foreach ($imageNames as $imageName)
                                    <a href="{{ asset('product-options/'.rawurlencode($imageName)) }}" target="_blank" rel="noopener" class="mr-2 mb-2">
                                        <img src="{{ asset('product-options/'.rawurlencode($imageName)) }}" alt="Option image" style="width: 90px; height: 90px; object-fit: cover;">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="option_images">Option Images</label>
                        <input id="option_images" name="option_images[]" type="file" accept="image/*" multiple class="form-control-file @error('option_images.*') is-invalid @enderror">
                        <small class="form-text text-muted">You can select multiple images. New uploads are added to current images.</small>
                        @error('option_images.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="custom-control custom-checkbox mb-4">
                        <input id="is_active" name="is_active" type="checkbox" value="1" class="custom-control-input" @checked(old('is_active', $productOption->is_active))>
                        <label class="custom-control-label" for="is_active">Active</label>
                    </div>

                    <button type="submit" class="btn btn-primary" @disabled($optionGroups->isEmpty())>{{ $isEditing ? 'Update Product Option' : 'Add Product Option' }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
