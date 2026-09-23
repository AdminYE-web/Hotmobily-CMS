@extends('admin.layouts.app')

@section('title', $isEditing ? 'Gallery Page Settings' : 'Add Gallery Page')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">{{ $isEditing ? 'Gallery Page Settings' : 'Add Gallery Page' }}</h1>
                <p class="text-muted mb-0">The database type connects this page to existing rows in hm_acrylic_gallery.</p>
            </div>
            <a href="{{ route('admin.gallery-pages.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ $isEditing ? route('admin.gallery-pages.update', $galleryPage) : route('admin.gallery-pages.store') }}">
                    @csrf
                    @if ($isEditing) @method('PUT') @endif

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Page name</label>
                            <input id="name" name="name" class="form-control" required maxlength="150" value="{{ old('name', $galleryPage->name) }}" placeholder="Acrylic Keyholder Gallery">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="slug">Admin slug</label>
                            <input id="slug" name="slug" class="form-control" required maxlength="100" value="{{ old('slug', $galleryPage->slug) }}" placeholder="acrylic-keyholder">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="public-slug">Public slug</label>
                            <input id="public-slug" name="public_slug" class="form-control" required maxlength="100" value="{{ old('public_slug', $galleryPage->public_slug) }}" placeholder="acrylic_key">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="gallery-type">Database type</label>
                            <input id="gallery-type" name="gallery_type" class="form-control" required maxlength="50" value="{{ old('gallery_type', $galleryPage->gallery_type) }}" placeholder="keyholder" @readonly($hasItems)>
                            <small class="form-text text-muted">
                                @if ($hasItems)
                                    Locked because this page already has legacy data.
                                @else
                                    New and old rows are selected by this value.
                                @endif
                            </small>
                        </div>
                        <div class="form-group col-md-5">
                            <label for="media-directory">Image directory</label>
                            <input id="media-directory" name="media_directory" class="form-control" required maxlength="255" value="{{ old('media_directory', $galleryPage->media_directory) }}" placeholder="gallery/img-acrylic">
                            <small class="form-text text-muted">Must be inside public/gallery.</small>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="legacy-extension">Legacy extension</label>
                            <input id="legacy-extension" name="legacy_extension" class="form-control" maxlength="10" value="{{ old('legacy_extension', $galleryPage->legacy_extension) }}" placeholder="webp">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="heading">Public heading (H1)</label>
                            <input id="heading" name="heading" class="form-control" maxlength="255" value="{{ old('heading', $galleryPage->heading ?? '') }}" placeholder="製作事例紹介">
                            <small class="form-text text-muted">ข้อความหัวข้อสีส้มด้านบนของหน้าสาธารณะ</small>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="description">Public description</label>
                            <textarea id="description" name="description" rows="3" class="form-control" maxlength="65535">{{ old('description', $galleryPage->description) }}</textarea>
                            <small class="form-text text-muted">จัดรูปแบบข้อความและแนบลิงก์ได้</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="sort-order">Menu order</label>
                            <input id="sort-order" type="number" name="sort_order" class="form-control" required value="{{ old('sort_order', $galleryPage->sort_order) }}">
                        </div>
                    </div>

                    <div class="form-group form-check">
                        <input type="hidden" name="show_website" value="0">
                        <input id="show-website" type="checkbox" name="show_website" value="1" class="form-check-input" @checked(old('show_website', $galleryPage->show_website))>
                        <label for="show-website" class="form-check-label">Show customer website field</label>
                    </div>
                    <div class="form-group form-check">
                        <input type="hidden" name="show_tags" value="0">
                        <input id="show-tags" type="checkbox" name="show_tags" value="1" class="form-check-input" @checked(old('show_tags', $galleryPage->show_tags ?? true))>
                        <label for="show-tags" class="form-check-label">Show tag filter on public page</label>
                        <small class="form-text text-muted">Controls the orange tag buttons displayed above the gallery items.</small>
                    </div>
                    <div class="form-group form-check">
                        <input type="hidden" name="is_active" value="0">
                        <input id="is-active" type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $galleryPage->is_active))>
                        <label for="is-active" class="form-check-label">Active in admin menu and public website</label>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.gallery-pages.index') }}" class="btn btn-outline-secondary mr-2">Cancel</a>
                        <button type="submit" class="btn btn-success">Save settings</button>
                    </div>
                </form>
            </div>
        </div>
</div>
@endsection

@push('styles')
    <style>
        #description + .ck-editor .ck-editor__editable_inline {
            min-height: 180px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const textarea = document.querySelector('#description');
            const Editor = window.ClassicEditor;

            if (!textarea || !Editor) return;

            Editor.create(textarea, {
                licenseKey: 'GPL',
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'link', '|',
                        'bulletedList', 'numberedList', 'blockQuote', '|',
                        'undo', 'redo',
                    ],
                    shouldNotGroupWhenFull: true,
                },
                link: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://',
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
                const form = textarea.form;

                if (form) {
                    form.addEventListener('submit', function () {
                        textarea.value = editor.getData();
                    });
                }
            }).catch(function (error) {
                console.error('Gallery page description CKEditor error:', error);
            });
        });
    </script>
@endpush
