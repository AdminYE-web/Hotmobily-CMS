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

                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input id="is_disabled" name="is_disabled" type="checkbox" value="1" class="custom-control-input" @checked(old('is_disabled', $productOption->is_disabled))>
                            <label class="custom-control-label" for="is_disabled">Disable when selected</label>
                        </div>
                        <small class="form-text text-muted">Users can select this option to see the notice, but they cannot continue to the next step while it is selected.</small>
                    </div>

                    <div class="form-group product-option-disable-text-editor">
                        <label for="disable_text">Disable Text</label>
                        <textarea id="disable_text" name="disable_text" rows="4" class="form-control @error('disable_text') is-invalid @enderror" maxlength="10000" placeholder="Example: 今週の受付数量を越えております為、ご注文停止中です">{{ old('disable_text', $productOption->disable_text) }}</textarea>
                        <small class="form-text text-muted">Displayed below the option when it is selected. Use the toolbar to format the text and change its color.</small>
                        @error('disable_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    @if ($imageNames->isNotEmpty())
                        <div class="form-group">
                            <label>Current Option Images</label>
                            <div class="d-flex flex-wrap">
                                @foreach ($imageNames as $imageName)
                                    <div class="mr-2 mb-2 text-center" data-option-image="{{ $imageName }}">
                                        <a href="{{ asset('product-options/'.rawurlencode($imageName)) }}" target="_blank" rel="noopener" class="d-block mb-1">
                                            <img src="{{ asset('product-options/'.rawurlencode($imageName)) }}" alt="Option image" style="width: 90px; height: 90px; object-fit: cover;">
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-option-image" data-image-name="{{ $imageName }}">Remove</button>
                                    </div>
                                @endforeach
                            </div>
                            <small class="form-text text-muted">Click Remove, then click Update Product Option to permanently remove the selected image.</small>
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

@push('styles')
    <style>
        .product-option-disable-text-editor .ck-editor__editable_inline { min-height: 130px; }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form[enctype="multipart/form-data"]');
            if (!form) return;

            const textarea = document.querySelector('#disable_text');
            const Editor = window.CKEDITOR && window.CKEDITOR.ClassicEditor;

            if (textarea && Editor) {
                Editor.create(textarea, {
                    licenseKey: 'GPL',
                    toolbar: {
                        items: [
                            'bold', 'italic', 'underline', '|',
                            'fontColor', '|',
                            'bulletedList', 'numberedList', '|',
                            'undo', 'redo',
                        ],
                        shouldNotGroupWhenFull: true,
                    },
                    fontColor: {
                        colors: [
                            { color: '#000000', label: 'Black' },
                            { color: '#e60000', label: 'Red' },
                            { color: '#ff8c00', label: 'Orange' },
                            { color: '#f7b516', label: 'Yellow' },
                            { color: '#008000', label: 'Green' },
                            { color: '#1e90ff', label: 'Blue' },
                            { color: '#800080', label: 'Purple' },
                        ],
                        columns: 4,
                    },
                    removePlugins: [
                        'AIAssistant',
                        'CKBox',
                        'CKFinder',
                        'EasyImage',
                        'ExportPdf',
                        'ExportWord',
                        'MultiLevelList',
                        'RealTimeCollaborativeComments',
                        'RealTimeCollaborativeTrackChanges',
                        'RealTimeCollaborativeRevisionHistory',
                        'PresenceList',
                        'Comments',
                        'TrackChanges',
                        'TrackChangesData',
                        'RevisionHistory',
                        'Pagination',
                        'WProofreader',
                        'MathType',
                        'SlashCommand',
                        'Template',
                        'DocumentOutline',
                        'FormatPainter',
                        'TableOfContents',
                        'PasteFromOfficeEnhanced',
                        'CaseChange',
                    ],
                }).catch(function (error) {
                    console.error('Product Option Disable Text CKEditor error:', error);
                });
            }

            document.querySelectorAll('.remove-option-image').forEach(function (button) {
                button.addEventListener('click', function () {
                    const imageName = button.dataset.imageName;
                    if (!imageName) return;

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'remove_images[]';
                    input.value = imageName;
                    form.appendChild(input);
                    button.closest('[data-option-image]')?.remove();
                });
            });
        });
    </script>
@endpush
