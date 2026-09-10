@extends('admin.layouts.app')

@section('title', $isEditing ? 'Edit Option Group' : 'Add Option Group')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">{{ $isEditing ? 'Edit Option Group' : 'Add Option Group' }}</h1>
                <p class="text-muted mb-0">Standalone shared configuration; product assignment will be added later.</p>
            </div>

            <a href="{{ route('admin.option-groups.index') }}" class="btn btn-outline-secondary">&larr; Back</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ $isEditing ? route('admin.option-groups.update', $optionGroup) : route('admin.option-groups.store') }}">
                    @csrf
                    @if ($isEditing)
                        @method('PUT')
                    @endif

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="group_code">Group Code <span class="text-danger">*</span></label>
                            <input id="group_code" name="group_code" type="text" value="{{ old('group_code', $optionGroup->group_code) }}" class="form-control @error('group_code') is-invalid @enderror" maxlength="100" pattern="[A-Za-z0-9_-]+" required>
                            <small class="form-text text-muted">Letters, numbers, underscores, and hyphens only. Must be unique.</small>
                            @error('group_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="group_name">Group Name <span class="text-danger">*</span></label>
                            <input id="group_name" name="group_name" type="text" value="{{ old('group_name', $optionGroup->group_name) }}" class="form-control @error('group_name') is-invalid @enderror" maxlength="255" required>
                            @error('group_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="display_type">Display Type <span class="text-danger">*</span></label>
                        <select id="display_type" name="display_type" class="form-control @error('display_type') is-invalid @enderror">
                            <option value="button" @selected(old('display_type', $optionGroup->display_type) === 'button')>Button</option>
                            <option value="image_card" @selected(old('display_type', $optionGroup->display_type) === 'image_card')>Image card</option>
                        </select>
                        <small class="form-text text-muted">This setting is saved now and will control storefront rendering in a later iteration.</small>
                        @error('display_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="help_text">Help Text</label>
                        <textarea id="help_text" name="help_text" rows="4" class="form-control @error('help_text') is-invalid @enderror" maxlength="2000">{{ old('help_text', $optionGroup->help_text) }}</textarea>
                        @error('help_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="custom-control custom-checkbox">
                                <input id="is_main_price_group" name="is_main_price_group" type="checkbox" value="1" class="custom-control-input" @checked(old('is_main_price_group', $optionGroup->is_main_price_group))>
                                <label class="custom-control-label" for="is_main_price_group">Main Price Group</label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-2 mb-md-0">
                            <div class="custom-control custom-checkbox">
                                <input id="is_required" name="is_required" type="checkbox" value="1" class="custom-control-input" @checked(old('is_required', $optionGroup->is_required))>
                                <label class="custom-control-label" for="is_required">Required</label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox">
                                <input id="is_active" name="is_active" type="checkbox" value="1" class="custom-control-input" @checked(old('is_active', $optionGroup->is_active))>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">{{ $isEditing ? 'Update Option Group' : 'Add Option Group' }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
