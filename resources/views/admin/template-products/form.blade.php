@extends('admin.layouts.app')

@php
    $blocks = old('blocks');

    if ($blocks === null && $templateProduct->exists) {
        $blocks = $templateProduct->blocks->mapWithKeys(function ($block) {
            return [(string) $block->id => [
                'id' => $block->id,
                'heading' => $block->heading,
                'rows' => $block->rows->mapWithKeys(function ($row) {
                    return [(string) $row->id => [
                        'id' => $row->id,
                        'size_template' => $row->size_template,
                        'downloads' => $row->downloads->mapWithKeys(function ($download) {
                            return [(string) $download->id => [
                                'id' => $download->id,
                                'button_label' => $download->button_label,
                                'file_path' => $download->file_path,
                                'original_name' => $download->original_name,
                            ]];
                        })->all(),
                    ]];
                })->all(),
            ]];
        })->all();
    }

    if ($blocks === null) {
        $blocks = [
            'new_block_1' => [
                'heading' => '',
                'rows' => [
                    'new_row_1' => [
                        'size_template' => '',
                        'downloads' => [
                            'new_download_1' => ['button_label' => 'テンプレートダウンロードai'],
                            'new_download_2' => ['button_label' => 'テンプレートダウンロードpsd'],
                        ],
                    ],
                ],
            ],
        ];
    }
@endphp

@section('title', $isEditing ? 'Edit Template Product' : 'Add Template Product')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h3 mb-1">{{ $isEditing ? 'Edit' : 'Add' }} Template Product</h1>
                <p class="text-muted mb-0">One product can contain multiple blocks. Each row can contain multiple download buttons.</p>
            </div>
            <a href="{{ route('admin.template-products.index') }}" class="btn btn-outline-secondary">Back</a>
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

        <form method="POST" action="{{ $isEditing ? route('admin.template-products.update', $templateProduct) : route('admin.template-products.store') }}" enctype="multipart/form-data" id="template-product-form">
            @csrf
            @if ($isEditing)
                @method('PUT')
            @endif

            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="template-product-name">Product name</label>
                            <input id="template-product-name" type="text" name="name" class="form-control" maxlength="255" required value="{{ old('name', $templateProduct->name) }}" placeholder="めじるしチャーム（アクリルアンブレラマーカー）">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="template-sort-order">Menu order</label>
                            <input id="template-sort-order" type="number" name="sort_order" class="form-control" required value="{{ old('sort_order', $templateProduct->sort_order) }}">
                        </div>
                    </div>
                    <input type="hidden" name="is_active" value="0">
                    <div class="form-check">
                        <input id="template-is-active" type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $templateProduct->is_active))>
                        <label for="template-is-active" class="form-check-label">Show on public template page</label>
                    </div>
                </div>
            </div>

            <div id="template-blocks">
                @foreach ($blocks as $blockKey => $block)
                    <div class="card shadow-sm mb-3 template-block" data-block-key="{{ $blockKey }}">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span><span class="template-drag-handle" draggable="true" title="Drag to reorder">☷</span><strong>Block</strong></span>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-template-block">Remove block</button>
                        </div>
                        <div class="card-body">
                            @if (! empty($block['id']))
                                <input type="hidden" name="blocks[{{ $blockKey }}][id]" value="{{ $block['id'] }}">
                            @endif
                            <div class="form-group">
                                <label>Block heading</label>
                                <input type="text" name="blocks[{{ $blockKey }}][heading]" class="form-control" maxlength="500" required value="{{ $block['heading'] ?? '' }}" placeholder="めじるしチャーム（アクリルアンブレラマーカー）【Illustrator／Photoshop】">
                            </div>

                            <div class="template-rows">
                                @foreach (($block['rows'] ?? []) as $rowKey => $row)
                                    <div class="border rounded p-3 mb-3 template-row" data-row-key="{{ $rowKey }}">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span><span class="template-drag-handle" draggable="true" title="Drag to reorder">☷</span><strong>Size row</strong></span>
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-template-row">Remove row</button>
                                        </div>
                                        @if (! empty($row['id']))
                                            <input type="hidden" name="blocks[{{ $blockKey }}][rows][{{ $rowKey }}][id]" value="{{ $row['id'] }}">
                                        @endif
                                        <div class="form-group">
                                            <label>size_template</label>
                                            <input type="text" name="blocks[{{ $blockKey }}][rows][{{ $rowKey }}][size_template]" class="form-control" maxlength="500" required value="{{ $row['size_template'] ?? '' }}" placeholder="50mm×50mm">
                                        </div>
                                        <div class="template-downloads">
                                            @foreach (($row['downloads'] ?? []) as $downloadKey => $download)
                                                <div class="form-row align-items-end border-top pt-3 mt-3 template-download">
                                                    @if (! empty($download['id']))
                                                        <input type="hidden" name="blocks[{{ $blockKey }}][rows][{{ $rowKey }}][downloads][{{ $downloadKey }}][id]" value="{{ $download['id'] }}">
                                                    @endif
                                                    <div class="form-group col-md-1 text-center">
                                                        <span class="template-drag-handle" draggable="true" title="Drag to reorder">☷</span>
                                                    </div>
                                                    <div class="form-group col-md-3">
                                                        <label>Button name</label>
                                                        <input type="text" name="blocks[{{ $blockKey }}][rows][{{ $rowKey }}][downloads][{{ $downloadKey }}][button_label]" class="form-control" maxlength="255" required value="{{ $download['button_label'] ?? '' }}" placeholder="テンプレートダウンロードai">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>{{ ! empty($download['id']) ? 'Replace file (optional)' : 'Upload file' }}</label>
                                                        <input type="file" name="blocks[{{ $blockKey }}][rows][{{ $rowKey }}][downloads][{{ $downloadKey }}][file]" class="form-control-file" {{ empty($download['id']) ? 'required' : '' }} accept=".ai,.psd,.clip,.zip,.pdf,.eps,.rar,.7z">
                                                        @if (! empty($download['file_path']))
                                                            <small class="form-text text-muted">
                                                                Current: <a href="{{ $download['file_path'] }}" target="_blank" rel="noopener">{{ $download['original_name'] ?: basename($download['file_path']) }}</a>
                                                            </small>
                                                        @endif
                                                    </div>
                                                    <div class="form-group col-md-2 text-right">
                                                        <button type="button" class="btn btn-outline-danger remove-template-download">Remove</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-primary add-template-download">+ Add upload button</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-success add-template-row">+ Add size row</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" id="add-template-block" class="btn btn-outline-primary mb-4">+ Add block</button>

            <div class="d-flex justify-content-end mb-5">
                <a href="{{ route('admin.template-products.index') }}" class="btn btn-outline-secondary mr-2">Cancel</a>
                <button type="submit" class="btn btn-success">Save template product</button>
            </div>
        </form>
    </div>

    <template id="template-block-template">
        <div class="card shadow-sm mb-3 template-block" data-block-key="__BLOCK__">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><span class="template-drag-handle" draggable="true" title="Drag to reorder">☷</span><strong>Block</strong></span>
                <button type="button" class="btn btn-sm btn-outline-danger remove-template-block">Remove block</button>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Block heading</label>
                    <input type="text" name="blocks[__BLOCK__][heading]" class="form-control" maxlength="500" required placeholder="めじるしチャーム（アクリルアンブレラマーカー）【Illustrator／Photoshop】">
                </div>
                <div class="template-rows"></div>
                <button type="button" class="btn btn-sm btn-outline-success add-template-row">+ Add size row</button>
            </div>
        </div>
    </template>

    <template id="template-row-template">
        <div class="border rounded p-3 mb-3 template-row" data-row-key="__ROW__">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span><span class="template-drag-handle" draggable="true" title="Drag to reorder">☷</span><strong>Size row</strong></span>
                <button type="button" class="btn btn-sm btn-outline-danger remove-template-row">Remove row</button>
            </div>
            <div class="form-group">
                <label>size_template</label>
                <input type="text" name="blocks[__BLOCK__][rows][__ROW__][size_template]" class="form-control" maxlength="500" required placeholder="50mm×50mm">
            </div>
            <div class="template-downloads"></div>
            <button type="button" class="btn btn-sm btn-outline-primary add-template-download">+ Add upload button</button>
        </div>
    </template>

    <template id="template-download-template">
        <div class="form-row align-items-end border-top pt-3 mt-3 template-download">
            <div class="form-group col-md-1 text-center">
                <span class="template-drag-handle" draggable="true" title="Drag to reorder">☷</span>
            </div>
            <div class="form-group col-md-3">
                <label>Button name</label>
                <input type="text" name="blocks[__BLOCK__][rows][__ROW__][downloads][__DOWNLOAD__][button_label]" class="form-control" maxlength="255" required placeholder="テンプレートダウンロードai">
            </div>
            <div class="form-group col-md-6">
                <label>Upload file</label>
                <input type="file" name="blocks[__BLOCK__][rows][__ROW__][downloads][__DOWNLOAD__][file]" class="form-control-file" required accept=".ai,.psd,.clip,.zip,.pdf,.eps,.rar,.7z">
            </div>
            <div class="form-group col-md-2 text-right">
                <button type="button" class="btn btn-outline-danger remove-template-download">Remove</button>
            </div>
        </div>
    </template>
@endsection

@push('styles')
    <style>
        .template-block { border-left: 4px solid #f58904; }
        .template-row { background: #fafafa; }
        .template-download:first-child { margin-top: 0 !important; border-top: 0 !important; padding-top: 0 !important; }
        .template-drag-handle { cursor: grab; color: #6c757d; font-size: 1.2rem; user-select: none; }
        .template-dragging { opacity: .45; }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const blocks = document.querySelector('#template-blocks');
            const blockTemplate = document.querySelector('#template-block-template').innerHTML;
            const rowTemplate = document.querySelector('#template-row-template').innerHTML;
            const downloadTemplate = document.querySelector('#template-download-template').innerHTML;
            let sequence = Date.now();
            const nextKey = function (prefix) { sequence += 1; return prefix + sequence; };

            function addDownload(row, defaultLabel) {
                const blockKey = row.closest('.template-block').dataset.blockKey;
                const rowKey = row.dataset.rowKey;
                const downloadKey = nextKey('new_download_');
                const wrapper = document.createElement('div');
                wrapper.innerHTML = downloadTemplate
                    .replaceAll('__BLOCK__', blockKey)
                    .replaceAll('__ROW__', rowKey)
                    .replaceAll('__DOWNLOAD__', downloadKey);
                const download = wrapper.firstElementChild;
                if (defaultLabel) download.querySelector('input[type="text"]').value = defaultLabel;
                row.querySelector('.template-downloads').appendChild(download);
            }

            function addRow(block) {
                const blockKey = block.dataset.blockKey;
                const rowKey = nextKey('new_row_');
                const wrapper = document.createElement('div');
                wrapper.innerHTML = rowTemplate
                    .replaceAll('__BLOCK__', blockKey)
                    .replaceAll('__ROW__', rowKey);
                const row = wrapper.firstElementChild;
                block.querySelector('.template-rows').appendChild(row);
                addDownload(row, 'テンプレートダウンロードai');
                addDownload(row, 'テンプレートダウンロードpsd');
            }

            function addBlock() {
                const blockKey = nextKey('new_block_');
                const wrapper = document.createElement('div');
                wrapper.innerHTML = blockTemplate.replaceAll('__BLOCK__', blockKey);
                const block = wrapper.firstElementChild;
                blocks.appendChild(block);
                addRow(block);
            }

            document.querySelector('#add-template-block').addEventListener('click', addBlock);

            blocks.addEventListener('click', function (event) {
                const button = event.target.closest('button');
                if (!button) return;

                if (button.classList.contains('add-template-row')) {
                    addRow(button.closest('.template-block'));
                } else if (button.classList.contains('add-template-download')) {
                    addDownload(button.closest('.template-row'), 'テンプレートダウンロード');
                } else if (button.classList.contains('remove-template-download')) {
                    const row = button.closest('.template-row');
                    if (row.querySelectorAll('.template-download').length <= 1) {
                        alert('Each size row needs at least one download button.');
                        return;
                    }
                    button.closest('.template-download').remove();
                } else if (button.classList.contains('remove-template-row')) {
                    const block = button.closest('.template-block');
                    if (block.querySelectorAll('.template-row').length <= 1) {
                        alert('Each block needs at least one size row.');
                        return;
                    }
                    button.closest('.template-row').remove();
                } else if (button.classList.contains('remove-template-block')) {
                    if (blocks.querySelectorAll('.template-block').length <= 1) {
                        alert('A product needs at least one block.');
                        return;
                    }
                    button.closest('.template-block').remove();
                }
            });

            let draggedItem = null;

            blocks.addEventListener('dragstart', function (event) {
                const handle = event.target.closest('.template-drag-handle');
                if (!handle) {
                    event.preventDefault();
                    return;
                }

                draggedItem = handle.closest('.template-block, .template-row, .template-download');
                draggedItem.classList.add('template-dragging');
                event.dataTransfer.effectAllowed = 'move';
            });

            blocks.addEventListener('dragover', function (event) {
                if (!draggedItem) return;

                const target = event.target.closest('.template-block, .template-row, .template-download');
                if (!target || target === draggedItem || target.parentElement !== draggedItem.parentElement) return;

                event.preventDefault();
                const insertAfter = event.clientY > target.getBoundingClientRect().top + target.offsetHeight / 2;
                target.parentElement.insertBefore(draggedItem, insertAfter ? target.nextSibling : target);
            });

            blocks.addEventListener('dragend', function () {
                if (!draggedItem) return;

                draggedItem.classList.remove('template-dragging');
                draggedItem = null;
            });
        });
    </script>
@endpush
