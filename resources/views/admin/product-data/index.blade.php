@extends('admin.layouts.app')

@php
    $pageManagerEntity = $pageManagerEntity ?? 'Product Data';
    $pageManagerEntityPlural = $pageManagerEntityPlural ?? 'Product Data';
    $pageManagerTitle = $pageManagerTitle ?? $pageManagerEntityPlural;
    $pageManagerDescription = $pageManagerDescription ?? 'Manage pages and assign a reusable layout.';
    $pageManagerApiBase = $pageManagerApiBase ?? '/api/v1/admin/product-data';
    $pageManagerLayoutApiBase = $pageManagerLayoutApiBase ?? '/api/v1/admin/product-data-layouts';
    $pageManagerLayoutBuilderBase = $pageManagerLayoutBuilderBase ?? '/admin/product-data-layouts';
    $pageManagerContentBase = $pageManagerContentBase ?? '/admin/product-data';
    $pageManagerLayoutField = $pageManagerLayoutField ?? 'product_data_layout_id';
    $pageManagerSlugPlaceholder = $pageManagerSlugPlaceholder ?? 'data.html';
    $pageManagerSlugHelp = $pageManagerSlugHelp ?? 'Path after /products/, for example data.html or rubberstrap/data.';
@endphp

@section('title', $pageManagerTitle)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">{{ $pageManagerTitle }}</h1>
            <p class="text-muted mb-0">{{ $pageManagerDescription }}</p>
        </div>

        <button type="button" class="btn btn-primary" id="btn-add-product-data">
            + Add {{ $pageManagerEntity }}
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>{{ $pageManagerEntityPlural }} List</strong>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-refresh">Refresh</button>
        </div>

        <div class="card-body">
            <div id="product-data-loading" class="text-center py-5">Loading...</div>
            <div id="product-data-error" class="alert alert-danger d-none"></div>

            <div id="product-data-empty" class="text-center py-5 text-muted d-none">
                <div class="mb-3">No {{ $pageManagerEntityPlural }} found.</div>
                <button type="button" class="btn btn-primary" id="btn-empty-create">
                    + Create First {{ $pageManagerEntity }}
                </button>
            </div>

            <div id="product-data-table-wrapper" class="table-responsive d-none">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width:70px">ID</th>
                            <th>{{ $pageManagerEntity }}</th>
                            <th style="width:220px">URL Slug</th>
                            <th style="width:220px">{{ $pageManagerEntity }} Layout</th>
                            <th style="width:120px">Status</th>
                            <th style="width:250px">Action</th>
                        </tr>
                    </thead>
                    <tbody id="product-data-list"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="productDataModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="product-data-modal-title">Add {{ $pageManagerEntity }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div id="product-data-form-error" class="alert alert-danger d-none"></div>
                <input type="hidden" id="product-data-id">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>{{ $pageManagerEntity }} Name <span class="text-danger">*</span></label>
                            <input type="text" id="product-data-name" class="form-control" maxlength="255" placeholder="Rubber Strap Data Guide">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <select id="product-data-status" class="form-control">
                                <option value="draft">Draft</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>URL Slug <span class="text-danger">*</span></label>
                    <input type="text" id="product-data-slug" class="form-control" maxlength="255" placeholder="{{ $pageManagerSlugPlaceholder }}">
                    <small class="form-text text-muted">
                        {{ $pageManagerSlugHelp }}
                    </small>
                </div>

                <div class="form-group">
                            <label>{{ $pageManagerEntity }} Layout</label>
                    <select id="product-data-layout-id" class="form-control">
                        <option value="">-- Select {{ $pageManagerEntity }} Layout --</option>
                    </select>
                        <small class="form-text text-muted">Select the layout used by this {{ $pageManagerEntity }} page.</small>
                </div>

                <div id="selected-product-data-layout" class="border rounded bg-light p-3 mb-3 d-none">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong id="selected-product-data-layout-name"></strong>
                            <div id="selected-product-data-layout-description" class="small text-muted mt-1"></div>
                        </div>
                        <span id="selected-product-data-layout-status" class="badge badge-secondary"></span>
                    </div>
                    <a href="#" target="_blank" id="selected-product-data-layout-builder" class="btn btn-sm btn-outline-primary mt-3">
                        Open Layout Builder
                    </a>
                </div>

                <div class="form-group mb-0">
                    <label>Description</label>
                    <textarea id="product-data-description" class="form-control" rows="3" maxlength="500"></textarea>
                </div>

                <hr>

                <h6 class="font-weight-bold mb-3">SEO Meta Settings</h6>

                <div class="form-group">
                    <label for="product-data-meta-keywords">Meta Keywords</label>
                    <textarea
                        id="product-data-meta-keywords"
                        class="form-control"
                        rows="2"
                        maxlength="1000"
                        placeholder="rubber strap, original goods, custom product"
                    ></textarea>
                    <small class="form-text text-muted">Separate keywords with commas.</small>
                </div>

                <div class="form-group mb-0">
                    <label for="product-data-meta-description">Meta Description</label>
                    <textarea
                        id="product-data-meta-description"
                        class="form-control"
                        rows="3"
                        maxlength="1000"
                        placeholder="Description displayed by search engines for this {{ $pageManagerEntity }} page."
                    ></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="save-product-data">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .product-data-name { font-weight: 600; }
    .product-data-description { color: #6c757d; font-size: 12px; margin-top: 3px; }
    .product-data-status { display: inline-block; padding: 4px 9px; border-radius: 999px; font-size: 12px; font-weight: 700; }
    .product-data-status--active { color: #155724; background: #d4edda; }
    .product-data-status--draft { color: #856404; background: #fff3cd; }
    .product-data-status--inactive { color: #721c24; background: #f8d7da; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const pageEntityLabel = @json($pageManagerEntity);
    const pageEntityPluralLabel = @json($pageManagerEntityPlural);
    const pageApiBase = @json($pageManagerApiBase);
    const layoutApiBase = @json($pageManagerLayoutApiBase);
    const layoutBuilderBase = @json($pageManagerLayoutBuilderBase);
    const contentBase = @json($pageManagerContentBase);
    const layoutField = @json($pageManagerLayoutField);
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const modal = $('#productDataModal');
    const loading = document.getElementById('product-data-loading');
    const errorBox = document.getElementById('product-data-error');
    const emptyBox = document.getElementById('product-data-empty');
    const tableWrapper = document.getElementById('product-data-table-wrapper');
    const list = document.getElementById('product-data-list');
    const layoutSelect = document.getElementById('product-data-layout-id');
    let pages = [];
    let layouts = [];

    async function api(url, options = {}) {
        const response = await fetch(url, {
            credentials: 'same-origin',
            ...options,
            headers: {
                Accept: 'application/json',
                ...(options.body ? {'Content-Type': 'application/json'} : {}),
                ...(options.method && options.method !== 'GET' ? {'X-CSRF-TOKEN': csrf} : {}),
                ...(options.headers || {}),
            },
        });
        const result = await response.json();
        if (!response.ok) throw result;
        return result;
    }

    async function loadData() {
        loading.classList.remove('d-none');
        errorBox.classList.add('d-none');
        emptyBox.classList.add('d-none');
        tableWrapper.classList.add('d-none');

        try {
            const [pageResult, layoutResult] = await Promise.all([
                api(pageApiBase),
                api(layoutApiBase),
            ]);
            pages = pageResult.data || [];
            layouts = layoutResult.data || [];
            renderLayoutOptions();
            renderPages();
        } catch (error) {
            errorBox.textContent = formatApiError(error);
            errorBox.classList.remove('d-none');
        } finally {
            loading.classList.add('d-none');
        }
    }

    function renderLayoutOptions() {
        const selected = layoutSelect.value;
        layoutSelect.innerHTML = `<option value="">-- Select ${pageEntityLabel} Layout --</option>`;
        layouts.forEach(function (layout) {
            const option = document.createElement('option');
            option.value = layout.id;
            option.textContent = `${layout.name} (${layout.status})`;
            layoutSelect.appendChild(option);
        });
        layoutSelect.value = selected;
        updateSelectedLayout();
    }

    function renderPages() {
        list.innerHTML = '';
        if (pages.length === 0) {
            emptyBox.classList.remove('d-none');
            return;
        }

        tableWrapper.classList.remove('d-none');
        pages.forEach(function (page) {
            const tr = document.createElement('tr');
            const status = ['active', 'inactive'].includes(page.status) ? page.status : 'draft';
            tr.innerHTML = `
                <td>${page.id}</td>
                <td>
                    <div class="product-data-name">${escapeHtml(page.name)}</div>
                    <div class="product-data-description">${escapeHtml(page.description || '')}</div>
                </td>
                <td><code>${escapeHtml(page.slug)}</code></td>
                <td>${page.layout ? escapeHtml(page.layout.name) : '<span class="text-muted">Not selected</span>'}</td>
                <td><span class="product-data-status product-data-status--${status}">${escapeHtml(page.status)}</span></td>
                <td>
                    ${page[layoutField] ? `<a href="${contentBase}/${page.id}/content" class="btn btn-sm btn-primary">Content</a>` : `<button type="button" class="btn btn-sm btn-secondary" disabled title="Select a ${pageEntityLabel} Layout first">Content</button>`}
                    <button type="button" class="btn btn-sm btn-warning btn-edit-product-data" data-id="${page.id}">Edit</button>
                    <button type="button" class="btn btn-sm btn-danger btn-delete-product-data" data-id="${page.id}">Delete</button>
                </td>
            `;
            list.appendChild(tr);
        });
    }

    function openCreateModal() {
        clearForm();
        document.getElementById('product-data-modal-title').textContent = `Add ${pageEntityLabel}`;
        modal.modal('show');
    }

    function openEditModal(id) {
        const page = pages.find(item => String(item.id) === String(id));
        if (!page) return;
        clearForm();
        document.getElementById('product-data-modal-title').textContent = `Edit ${pageEntityLabel}`;
        document.getElementById('product-data-id').value = page.id;
        document.getElementById('product-data-name').value = page.name || '';
        document.getElementById('product-data-slug').value = page.slug || '';
        document.getElementById('product-data-status').value = page.status || 'draft';
        document.getElementById('product-data-description').value = page.description || '';
        document.getElementById('product-data-meta-keywords').value = page.meta_keywords || '';
        document.getElementById('product-data-meta-description').value = page.meta_description || '';
        layoutSelect.value = page[layoutField] || '';
        updateSelectedLayout();
        modal.modal('show');
    }

    function clearForm() {
        document.getElementById('product-data-id').value = '';
        document.getElementById('product-data-name').value = '';
        document.getElementById('product-data-slug').value = '';
        document.getElementById('product-data-status').value = 'draft';
        document.getElementById('product-data-description').value = '';
        document.getElementById('product-data-meta-keywords').value = '';
        document.getElementById('product-data-meta-description').value = '';
        layoutSelect.value = '';
        document.getElementById('product-data-form-error').classList.add('d-none');
        updateSelectedLayout();
    }

    function updateSelectedLayout() {
        const box = document.getElementById('selected-product-data-layout');
        const layout = layouts.find(item => String(item.id) === String(layoutSelect.value));
        if (!layout) {
            box.classList.add('d-none');
            return;
        }
        document.getElementById('selected-product-data-layout-name').textContent = layout.name;
        document.getElementById('selected-product-data-layout-description').textContent = layout.description || '';
        document.getElementById('selected-product-data-layout-status').textContent = layout.status;
        document.getElementById('selected-product-data-layout-builder').href = `${layoutBuilderBase}/${layout.id}/builder`;
        box.classList.remove('d-none');
    }

    async function savePage() {
        const id = document.getElementById('product-data-id').value;
        const payload = {
            name: document.getElementById('product-data-name').value.trim(),
            slug: document.getElementById('product-data-slug').value.trim(),
            status: document.getElementById('product-data-status').value,
            description: document.getElementById('product-data-description').value.trim() || null,
            meta_keywords: document.getElementById('product-data-meta-keywords').value.trim() || null,
            meta_description: document.getElementById('product-data-meta-description').value.trim() || null,
        };
        payload[layoutField] = layoutSelect.value ? Number(layoutSelect.value) : null;
        const formError = document.getElementById('product-data-form-error');
        formError.classList.add('d-none');

        if (!payload.name || !payload.slug) {
            formError.textContent = `${pageEntityLabel} Name and URL Slug are required.`;
            formError.classList.remove('d-none');
            return;
        }

        const button = document.getElementById('save-product-data');
        try {
            button.disabled = true;
            button.textContent = 'Saving...';
            await api(id ? `${pageApiBase}/${id}` : pageApiBase, {
                method: id ? 'PUT' : 'POST',
                body: JSON.stringify(payload),
            });
            modal.modal('hide');
            await loadData();
        } catch (error) {
            formError.textContent = formatApiError(error);
            formError.classList.remove('d-none');
        } finally {
            button.disabled = false;
            button.textContent = 'Save';
        }
    }

    async function deletePage(id) {
        const page = pages.find(item => String(item.id) === String(id));
        if (!page || !confirm(`Delete ${pageEntityLabel} "${page.name}"?`)) return;
        try {
            await api(`${pageApiBase}/${id}`, {method: 'DELETE'});
            await loadData();
        } catch (error) {
            alert(formatApiError(error));
        }
    }

    function formatApiError(error) {
        if (error?.errors) {
            return Object.values(error.errors).flat().join('\n');
        }
        return error?.message || 'Something went wrong.';
    }

    function escapeHtml(value) {
        return String(value ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    document.getElementById('btn-add-product-data').addEventListener('click', openCreateModal);
    document.getElementById('btn-empty-create').addEventListener('click', openCreateModal);
    document.getElementById('btn-refresh').addEventListener('click', loadData);
    document.getElementById('save-product-data').addEventListener('click', savePage);
    layoutSelect.addEventListener('change', updateSelectedLayout);
    list.addEventListener('click', function (event) {
        const edit = event.target.closest('.btn-edit-product-data');
        const remove = event.target.closest('.btn-delete-product-data');
        if (edit) openEditModal(edit.dataset.id);
        if (remove) deletePage(remove.dataset.id);
    });

    loadData();
});
</script>
@endpush
