@extends('admin.layouts.app')

@section('title', 'Guide Main')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Guide Main</h1>
                <p class="text-muted mb-0">
                    Manage the heading, description and guide cards displayed at <code>/guide</code>.
                </p>
            </div>

            <button type="button" class="btn btn-primary" id="save-guide-main">
                Save Guide Main
            </button>
        </div>

        <div id="guide-main-error" class="alert alert-danger d-none"></div>
        <div id="guide-main-success" class="alert alert-success d-none"></div>

        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <strong>Head and Description</strong>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="guide-main-heading">Head</label>
                    <input
                        type="text"
                        id="guide-main-heading"
                        class="form-control"
                        maxlength="255"
                        placeholder="オリジナル製品製作に関するご利用案内"
                    >
                </div>

                <div class="form-group mb-0">
                    <label for="guide-main-description">Description</label>
                    <textarea
                        id="guide-main-description"
                        class="form-control"
                        rows="5"
                        maxlength="20000"
                        placeholder="Guide page description"
                    ></textarea>
                    <small class="form-text text-muted">
                        Rich text and links are supported.
                    </small>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Guide List</strong>
                <button type="button" class="btn btn-sm btn-outline-primary" id="add-guide-main-item">
                    + Add Guide
                </button>
            </div>
            <div class="card-body">
                <div id="guide-main-items"></div>
                <div id="guide-main-empty" class="text-muted text-center py-4">
                    No guide cards yet. Add a guide and select a Guide page.
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .guide-main-item {
            border: 1px solid #d6dce1;
            border-radius: .35rem;
            background: #fff;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .guide-main-item:last-child {
            margin-bottom: 0;
        }

        .guide-main-item__preview {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 140px;
            padding: .5rem;
            border: 1px dashed #b7c0ca;
            border-radius: .25rem;
            background: #f8f9fa;
        }

        .guide-main-item__preview img {
            display: block;
            max-width: 100%;
            max-height: 180px;
            object-fit: contain;
        }

        .guide-main-item__preview--empty {
            color: #6c757d;
            font-size: .875rem;
        }

        .guide-main-item__actions {
            white-space: nowrap;
        }

        .guide-main-item__title-color.form-control {
            width: 88px;
            height: 38px;
            padding: .15rem;
        }

        #guide-main-description + .ck-editor .ck-editor__editable_inline {
            min-height: 180px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const guideMainApi = '/api/v1/admin/guide-main';
            const guidesApi = '/api/v1/admin/guides';
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const itemsContainer = document.getElementById('guide-main-items');
            const emptyState = document.getElementById('guide-main-empty');
            const errorBox = document.getElementById('guide-main-error');
            const successBox = document.getElementById('guide-main-success');
            const descriptionTextarea = document.getElementById('guide-main-description');
            let guidePages = [];
            let descriptionEditor = null;
            let pendingDescription = '';

            async function api(url, options = {}) {
                const isFormData = options.body instanceof FormData;
                const response = await fetch(url, {
                    credentials: 'same-origin',
                    ...options,
                    headers: {
                        Accept: 'application/json',
                        ...(!isFormData && options.body ? {'Content-Type': 'application/json'} : {}),
                        ...(options.method && options.method !== 'GET' ? {'X-CSRF-TOKEN': csrf} : {}),
                        ...(options.headers || {}),
                    },
                });

                const result = await response.json();
                if (!response.ok) throw result;
                return result;
            }

            function imageUrl(path) {
                if (!path) return '';
                if (/^(https?:)?\/\//i.test(path) || path.startsWith('/')) return path;
                return '/storage/' + path;
            }

            function showError(error) {
                const message = error?.errors
                    ? Object.values(error.errors).flat().join('\n')
                    : (error?.message || 'Something went wrong.');
                errorBox.textContent = message;
                errorBox.classList.remove('d-none');
                successBox.classList.add('d-none');
            }

            function showSuccess(message) {
                successBox.textContent = message;
                successBox.classList.remove('d-none');
                errorBox.classList.add('d-none');
            }

            function populateGuidePages(select, selectedId) {
                select.innerHTML = '<option value="">-- Select Guide page --</option>';
                guidePages.forEach(function (page) {
                    const option = document.createElement('option');
                    option.value = page.id;
                    option.textContent = page.name + ' (' + page.slug + ')'
                        + (page.status !== 'active' ? ' [' + page.status + ']' : '');
                    select.appendChild(option);
                });
                select.value = selectedId || '';
            }

            function updatePreview(item) {
                const preview = item.querySelector('.guide-main-item__preview');
                const imagePath = item.querySelector('.guide-main-item__image-path').value.trim();
                const url = imageUrl(imagePath);

                if (!url) {
                    preview.classList.add('guide-main-item__preview--empty');
                    preview.innerHTML = 'No image selected';
                    return;
                }

                preview.classList.remove('guide-main-item__preview--empty');
                preview.innerHTML = '';
                const image = document.createElement('img');
                image.src = url;
                image.alt = item.querySelector('.guide-main-item__image-alt').value.trim()
                    || item.querySelector('.guide-main-item__title').value.trim()
                    || 'Guide image';
                preview.appendChild(image);
            }

            function createItem(item = {}) {
                const wrapper = document.createElement('div');
                wrapper.className = 'guide-main-item';
                wrapper.innerHTML = [
                    '<div class="d-flex justify-content-between align-items-center mb-3">',
                        '<strong class="guide-main-item__number">Guide</strong>',
                        '<div class="guide-main-item__actions">',
                            '<button type="button" class="btn btn-sm btn-outline-secondary move-up">↑</button>',
                            '<button type="button" class="btn btn-sm btn-outline-secondary move-down">↓</button>',
                            '<button type="button" class="btn btn-sm btn-outline-danger remove-guide-main-item">Remove</button>',
                        '</div>',
                    '</div>',
                    '<div class="form-row">',
                        '<div class="form-group col-md-5">',
                            '<label>Title <span class="text-danger">*</span></label>',
                            '<input type="text" class="form-control guide-main-item__title" maxlength="255">',
                        '</div>',
                        '<div class="form-group col-md-2">',
                            '<label>Title Color</label>',
                            '<input type="color" class="form-control guide-main-item__title-color" value="#000000">',
                        '</div>',
                        '<div class="form-group col-md-5">',
                            '<label>Guide page <span class="text-danger">*</span></label>',
                            '<select class="form-control guide-main-item__page"></select>',
                        '</div>',
                    '</div>',
                    '<div class="form-row">',
                        '<div class="form-group col-md-4">',
                            '<label>Image</label>',
                            '<div class="guide-main-item__preview guide-main-item__preview--empty">No image selected</div>',
                            '<input type="hidden" class="guide-main-item__image-path">',
                            '<input type="file" class="form-control-file mt-2 guide-main-item__image-file" accept="image/*">',
                            '<small class="form-text text-muted">Upload the card image.</small>',
                        '</div>',
                        '<div class="form-group col-md-8">',
                            '<label>Image alt</label>',
                            '<input type="text" class="form-control guide-main-item__image-alt" maxlength="500">',
                            '<label class="mt-3">Description</label>',
                            '<textarea class="form-control guide-main-item__description" rows="4" maxlength="20000"></textarea>',
                        '</div>',
                    '</div>',
                ].join('');

                wrapper.querySelector('.guide-main-item__title').value = item.title || '';
                wrapper.querySelector('.guide-main-item__title-color').value = item.title_color || '#000000';
                wrapper.querySelector('.guide-main-item__image-path').value = item.image_path || '';
                wrapper.querySelector('.guide-main-item__image-alt').value = item.image_alt || '';
                wrapper.querySelector('.guide-main-item__description').value = item.description || '';
                populateGuidePages(wrapper.querySelector('.guide-main-item__page'), item.guide_page_id);
                updatePreview(wrapper);

                wrapper.querySelector('.guide-main-item__image-file').addEventListener('change', async function () {
                    const file = this.files?.[0];
                    if (!file) return;

                    const formData = new FormData();
                    formData.append('image', file);
                    this.disabled = true;

                    try {
                        const result = await api(guideMainApi + '/images', {
                            method: 'POST',
                            body: formData,
                        });
                        wrapper.querySelector('.guide-main-item__image-path').value = result.data.path || '';
                        updatePreview(wrapper);
                    } catch (error) {
                        showError(error);
                    } finally {
                        this.disabled = false;
                        this.value = '';
                    }
                });

                wrapper.querySelector('.guide-main-item__image-alt').addEventListener('input', function () {
                    updatePreview(wrapper);
                });

                wrapper.querySelector('.remove-guide-main-item').addEventListener('click', function () {
                    wrapper.remove();
                    refreshEmptyState();
                    refreshNumbers();
                });

                wrapper.querySelector('.move-up').addEventListener('click', function () {
                    const previous = wrapper.previousElementSibling;
                    if (previous) previous.before(wrapper);
                    refreshNumbers();
                });

                wrapper.querySelector('.move-down').addEventListener('click', function () {
                    const next = wrapper.nextElementSibling;
                    if (next) next.after(wrapper);
                    refreshNumbers();
                });

                itemsContainer.appendChild(wrapper);
                refreshEmptyState();
                refreshNumbers();
            }

            function refreshEmptyState() {
                emptyState.classList.toggle('d-none', itemsContainer.children.length > 0);
            }

            function refreshNumbers() {
                Array.from(itemsContainer.children).forEach(function (item, index) {
                    item.querySelector('.guide-main-item__number').textContent = 'Guide ' + (index + 1);
                });
            }

            function setDescription(value) {
                pendingDescription = value || '';
                descriptionTextarea.value = pendingDescription;
                if (descriptionEditor) descriptionEditor.setData(pendingDescription);
            }

            function collectItems() {
                return Array.from(itemsContainer.children).map(function (item, index) {
                    return {
                        guide_page_id: Number(item.querySelector('.guide-main-item__page').value || 0),
                        title: item.querySelector('.guide-main-item__title').value.trim(),
                        title_color: item.querySelector('.guide-main-item__title-color').value || '#000000',
                        image_path: item.querySelector('.guide-main-item__image-path').value.trim() || null,
                        image_alt: item.querySelector('.guide-main-item__image-alt').value.trim() || null,
                        description: item.querySelector('.guide-main-item__description').value.trim() || null,
                        sort_order: index,
                    };
                });
            }

            async function load() {
                try {
                    const [mainResult, pagesResult] = await Promise.all([
                        api(guideMainApi),
                        api(guidesApi),
                    ]);

                    guidePages = pagesResult.data || [];
                    const main = mainResult.data || {};
                    document.getElementById('guide-main-heading').value = main.heading || '';
                    setDescription(main.description || '');
                    itemsContainer.innerHTML = '';
                    (main.items || []).forEach(createItem);
                    refreshEmptyState();
                } catch (error) {
                    showError(error);
                }
            }

            document.getElementById('add-guide-main-item').addEventListener('click', function () {
                createItem();
            });

            document.getElementById('save-guide-main').addEventListener('click', async function () {
                const button = this;
                const items = collectItems();
                const invalidItem = items.find(item => !item.guide_page_id || !item.title);

                if (invalidItem) {
                    showError({message: 'Every Guide card needs a title and a Guide page.'});
                    return;
                }

                button.disabled = true;
                button.textContent = 'Saving...';

                try {
                    await api(guideMainApi, {
                        method: 'PUT',
                        body: JSON.stringify({
                            heading: document.getElementById('guide-main-heading').value.trim() || null,
                            description: descriptionEditor
                                ? descriptionEditor.getData()
                                : descriptionTextarea.value,
                            items,
                        }),
                    });
                    showSuccess('Guide Main settings saved.');
                } catch (error) {
                    showError(error);
                } finally {
                    button.disabled = false;
                    button.textContent = 'Save Guide Main';
                }
            });

            if (window.ClassicEditor) {
                ClassicEditor.create(descriptionTextarea, {
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
                    descriptionEditor = editor;
                    editor.setData(pendingDescription);
                }).catch(function (error) {
                    console.error('Guide Main description CKEditor error:', error);
                });
            }

            load();
        });
    </script>
@endpush
