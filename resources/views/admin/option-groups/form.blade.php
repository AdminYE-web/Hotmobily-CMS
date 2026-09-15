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
                            <option value="button_group" @selected(old('display_type', $optionGroup->display_type) === 'button_group')>Button group</option>
                            <option value="image_card" @selected(old('display_type', $optionGroup->display_type) === 'image_card')>Image card</option>
                            <option value="image_grid" @selected(old('display_type', $optionGroup->display_type) === 'image_grid')>Image grid</option>
                            <option value="paper_preview" @selected(old('display_type', $optionGroup->display_type) === 'paper_preview')>Paper preview</option>
                            <option value="previous_order" @selected(old('display_type', $optionGroup->display_type) === 'previous_order')>Previous order (いいえ / はい)</option>
                            <option value="radio_list" @selected(old('display_type', $optionGroup->display_type) === 'radio_list')>Radio list</option>
                            <option value="switch" @selected(old('display_type', $optionGroup->display_type) === 'switch')>Switch</option>
                            <option value="quantity_input" @selected(old('display_type', $optionGroup->display_type) === 'quantity_input')>Quantity input</option>
                        </select>
                        <small class="form-text text-muted">Button group renders horizontal selectable buttons. Image grid renders selectable images in a grid. Paper preview renders selectable paper-pattern previews. Previous order renders いいえ / はい. Radio list renders a vertical list of radio choices. Switch renders a toggle control. Quantity input renders one product-quantity field and does not need Product Options.</small>
                        @error('display_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="help_text">Help Text</label>
                        <textarea id="help_text" name="help_text" rows="4" class="form-control @error('help_text') is-invalid @enderror" maxlength="2000">{{ old('help_text', $optionGroup->help_text) }}</textarea>
                        @error('help_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="remark_text">Remark Text</label>
                        <textarea id="remark_text" name="remark_text" rows="2" class="form-control @error('remark_text') is-invalid @enderror" maxlength="2000" placeholder="Example: ※プレミアムは裏面印刷が無料">{{ old('remark_text', $optionGroup->remark_text) }}</textarea>
                        <small class="form-text text-muted">Displayed below this Option Group's choices in red on the product page.</small>
                        @error('remark_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-row mb-4">
                        <div class="col-md-3 mb-2 mb-md-0">
                            <div class="custom-control custom-checkbox">
                                <input id="is_main_price_group" name="is_main_price_group" type="checkbox" value="1" class="custom-control-input" @checked(old('is_main_price_group', $optionGroup->is_main_price_group))>
                                <label class="custom-control-label" for="is_main_price_group">Main Price Group</label>
                            </div>
                        </div>

                        <div class="col-md-3 mb-2 mb-md-0">
                            <div class="custom-control custom-checkbox">
                                <input id="is_required" name="is_required" type="checkbox" value="1" class="custom-control-input" @checked(old('is_required', $optionGroup->is_required))>
                                <label class="custom-control-label" for="is_required">Required</label>
                            </div>
                        </div>

                        <div class="col-md-3 mb-2 mb-md-0">
                            <div class="custom-control custom-checkbox">
                                <input id="show_in_order_summary" name="show_in_order_summary" type="checkbox" value="1" class="custom-control-input" @checked(old('show_in_order_summary', $optionGroup->show_in_order_summary))>
                                <label class="custom-control-label" for="show_in_order_summary">Show in order summary</label>
                            </div>
                        </div>

                        <div class="col-md-3">
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

@push('styles')
    <style>
        .ck-editor__editable_inline { min-height: 280px; }
        .ck-content .image-style-align-left { float: left; margin-right: 1.5em; }
        .ck-content .image-style-align-right { float: right; margin-left: 1.5em; }
        .ck-content figure.horizontal-line { clear: both; width: 100%; box-sizing: border-box; margin: 1em 0; }
        .ck-content hr { clear: both; width: 100%; box-sizing: border-box; margin: 1em 0; }
        .ck-content figure.horizontal-line hr,
        .ck-content hr { margin-left: 0; border: 0; border-top: 1px solid #d0d0d0; }
        .option-group-help-preview img { max-width: 100%; height: auto; }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const textarea = document.querySelector('#help_text');
            const Editor = window.CKEDITOR && window.CKEDITOR.ClassicEditor;
            if (!textarea || !Editor) return;

            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            class OptionGroupUploadAdapter {
                constructor(loader) {
                    this.loader = loader;
                    this.controller = new AbortController();
                }

                upload() {
                    return this.loader.file.then(function (file) {
                        const formData = new FormData();
                        formData.append('upload', file);

                        return fetch(@json(url('api/v1/admin/option-groups/upload-image')), {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                Accept: 'application/json',
                                'X-CSRF-TOKEN': csrf,
                            },
                            body: formData,
                        });
                    }).then(async function (response) {
                        const result = await response.json();
                        if (!response.ok) throw result;
                        return { default: result.url };
                    });
                }

                abort() {
                    this.controller.abort();
                }
            }

            Editor.create(textarea, {
                licenseKey: 'GPL',
                toolbar: {
                    items: [
                        'heading', '|', 'bold', 'italic', 'link',
                        'bulletedList', 'numberedList', '|',
                        'uploadImage', 'blockQuote', 'insertTable', 'horizontalLine', '|',
                        'undo', 'redo',
                    ],
                    shouldNotGroupWhenFull: true,
                },
                image: {
                    toolbar: [
                        'imageTextAlternative', '|',
                        'imageStyle:wrapText', 'imageStyle:breakText',
                    ],
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
            }).then(function (editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = function (loader) {
                    return new OptionGroupUploadAdapter(loader);
                };
            }).catch(function (error) {
                console.error('Option Group Help Text CKEditor error:', error);
            });
        });
    </script>
@endpush
