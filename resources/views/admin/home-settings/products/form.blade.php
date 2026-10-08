@extends('admin.layouts.app')

@section('title', $isEditing ? 'Edit Home Product Card' : 'Add Home Product Card')

@section('content')
    <div class="container-fluid py-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">{{ $isEditing ? 'Edit Home Product card' : 'Add Home Product card' }}</h1>
                <p class="text-muted mb-0">Choose a Product to generate the link. Enter a title, upload its image, and edit the copy and red sub-detail labels.</p>
            </div>
            <a href="{{ route('admin.home-settings.products.index') }}" class="btn btn-outline-secondary mt-2 mt-md-0">Back to Home Setting</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                @if ($products->isEmpty())
                    <div class="alert alert-warning mb-0">Create a Product first, then return here to add it to the homepage. <a href="{{ route('admin.products.index') }}" class="alert-link">Open Products</a></div>
                @else
                    <form id="home-product-card-form" method="POST" enctype="multipart/form-data" action="{{ $isEditing ? route('admin.home-settings.products.update', $item) : route('admin.home-settings.products.store') }}">
                        @csrf
                        @if ($isEditing) @method('PUT') @endif

                        <div class="form-group">
                            <label for="home-product-id">Product / link <span class="text-danger">*</span></label>
                            <select id="home-product-id" name="product_id" class="form-control" required>
                                <option value="">-- Select a Product --</option>
                                @foreach ($products as $product)
                                    @php($isSelected = (string) old('product_id', $item->product_id) === (string) $product->id)
                                    <option value="{{ $product->id }}" @selected($isSelected) @disabled(in_array((int) $product->id, $usedProductIds, true) && ! $isSelected)>
                                        {{ $product->name }} — /products/{{ trim($product->slug, '/') }} ({{ $product->status }}){{ in_array((int) $product->id, $usedProductIds, true) && ! $isSelected ? ' — already added' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">The card links to the selected Product. Draft or unpublished Products are hidden from the public homepage.</small>
                        </div>

                        <div class="form-group">
                            <label for="home-product-name">Card title <span class="text-danger">*</span></label>
                            <input id="home-product-name" name="name" type="text" class="form-control" maxlength="255" required value="{{ old('name', $item->name) }}">
                        </div>

                        <div class="form-group">
                            <label for="home-product-description">Description</label>
                            <textarea id="home-product-description" name="description_html" class="form-control" rows="5">{{ old('description_html', $item->description_html) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="home-product-features">Sub-details / highlights</label>
                            <textarea id="home-product-features" name="features_html" class="form-control" rows="7">{{ old('features_html', $item->features_html) }}</textarea>
                            <small class="form-text text-muted">Each paragraph is shown as one red highlight label, like the current 価格・納期・送料無料 boxes. Text color and bold formatting are supported.</small>
                        </div>

                        <div class="form-group">
                            <label for="home-product-image">Product image @unless($isEditing)<span class="text-danger">*</span>@endunless</label>
                            <input id="home-product-image" name="image" type="file" class="form-control-file" accept=".jpg,.jpeg,.png,.webp,.avif,image/*" @required(! $isEditing)>
                            <small class="form-text text-muted">JPG, PNG, WebP, or AVIF; maximum 10 MB. The homepage displays this image at 157 × 120 px.</small>
                            @if ($isEditing)
                                <div class="mt-2">
                                    <img src="{{ Storage::disk('public')->url($item->image_path) }}" alt="{{ $item->name }}" style="width:157px;height:120px;object-fit:contain;border:1px solid #ddd">
                                    <div class="small text-muted mt-1">Current image. Upload a replacement to change it.</div>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.home-settings.products.index') }}" class="btn btn-outline-secondary mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">{{ $isEditing ? 'Save changes' : 'Add Product card' }}</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        #home-product-card-form .ck-editor__editable { min-height: 150px; }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editors = [];
            const Editor = window.CKEDITOR && window.CKEDITOR.ClassicEditor;
            const editorConfig = {
                licenseKey: 'GPL',
                toolbar: {
                    items: ['heading', '|', 'bold', 'italic', 'underline', 'fontColor', 'link', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
                    shouldNotGroupWhenFull: true,
                },
                link: { addTargetToExternalLinks: true, defaultProtocol: 'https://' },
                removePlugins: ['AIAssistant', 'CKBox', 'CKFinder', 'EasyImage', 'ExportPdf', 'ExportWord', 'MultiLevelList', 'RealTimeCollaborativeComments', 'RealTimeCollaborativeTrackChanges', 'RealTimeCollaborativeRevisionHistory', 'PresenceList', 'Comments', 'TrackChanges', 'TrackChangesData', 'RevisionHistory', 'Pagination', 'WProofreader', 'MathType', 'SlashCommand', 'Template', 'DocumentOutline', 'FormatPainter', 'TableOfContents', 'PasteFromOfficeEnhanced', 'CaseChange'],
            };

            ['home-product-description', 'home-product-features'].forEach(function (id) {
                const textarea = document.getElementById(id);
                if (!textarea || !Editor) return;
                Editor.create(textarea, editorConfig).then(function (editor) {
                    editors.push(editor);
                }).catch(function (error) {
                    console.error('Home Product CKEditor error:', error);
                });
            });

            const form = document.getElementById('home-product-card-form');
            if (form) form.addEventListener('submit', function () { editors.forEach(function (editor) { editor.updateSourceElement(); }); });
        });
    </script>
@endpush
