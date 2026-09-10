@extends('admin.layouts.app')

@section('title', 'Manage Options')

@section('content')
    <div class="container-fluid product-options-manager">
        <div class="mb-4">
            <h1 class="h3 mb-1">Manage Options</h1>
            <p class="text-muted mb-0">{{ $product->name }} <span class="mx-1">/</span> {{ $product->slug }}</p>
        </div>

        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary mb-4">&larr; Back</a>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">Unable to save the selected Option Groups. Please try again.</div>
        @endif

        <form method="POST" action="{{ route('admin.products.options.update', $product) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-9 mb-4">
                    <div id="assigned-groups" class="assigned-groups"></div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary px-4">Save Option Order</button>
                    </div>
                </div>

                <aside class="col-lg-3 mb-4">
                    <div class="card shadow-sm option-group-picker">
                        <div class="card-body p-2">
                            <input id="option-group-search" type="search" class="form-control mb-2" placeholder="Search option group...">
                            <div id="available-groups" class="available-groups"></div>
                        </div>
                    </div>
                </aside>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <style>
        .product-options-manager { max-width: 1500px; }
        .assigned-groups { min-height: 120px; }
        .option-group-card { background: #fff; border: 1px solid #dce1e9; border-radius: .75rem; margin-bottom: 1rem; overflow: hidden; }
        .option-group-card.is-dragging { opacity: .45; }
        .option-group-header { display: flex; align-items: center; gap: .75rem; padding: 1rem; background: #f8f9fc; border-bottom: 1px solid #e3e7ee; }
        .option-group-handle { cursor: grab; border: 1px solid #d9dee7; border-radius: .45rem; background: #fff; color: #728096; padding: .25rem .48rem; line-height: 1; font-size: 0; }
        .option-group-handle::after { content: '\2630'; font-size: 1rem; }
        .option-group-title { flex: 1; min-width: 0; }
        .option-group-title strong { display: block; font-size: 1.02rem; }
        .option-group-meta { color: #7a8797; font-size: .8rem; }
        .option-group-actions { display: flex; gap: .35rem; align-items: center; }
        .option-group-options { padding: .85rem 1rem 1rem; }
        .option-row { display: grid; grid-template-columns: minmax(180px, 1fr) minmax(140px, 1.5fr) auto; gap: .75rem; align-items: center; padding: .7rem .25rem; border-bottom: 1px solid #edf0f4; }
        .option-row:last-child { border-bottom: 0; }
        .option-settings { grid-column: 1 / -1; display: grid; grid-template-columns: 120px 120px minmax(180px, 1fr) repeat(3, minmax(110px, 1fr)); gap: .75rem; align-items: end; padding: .8rem; border: 1px solid #dce1e9; border-radius: .6rem; background: #f7f9fc; }
        .option-settings label { margin: 0; font-size: .83rem; font-weight: 600; }
        .option-settings .form-control { min-width: 0; }
        .option-color { width: 20px; height: 20px; border: 1px solid #c8ced8; border-radius: 50%; display: inline-block; vertical-align: middle; margin-right: .35rem; }
        .available-group { width: 100%; text-align: left; border: 0; border-bottom: 1px solid #e8ebf0; background: #fff; padding: .8rem .7rem; cursor: pointer; }
        .available-group:hover { background: #f4f8ff; }
        .available-group:disabled { cursor: default; color: #9aa4b2; background: #f8f9fa; }
        .available-group small { display: block; color: #788596; margin-top: .15rem; }
        .option-group-picker { position: sticky; top: 1rem; }
        .empty-options { padding: 2rem; text-align: center; color: #7a8797; border: 1px dashed #cbd3df; border-radius: .75rem; background: #fafbfc; }
        @media (max-width: 767.98px) {
            .option-group-header { align-items: flex-start; flex-wrap: wrap; }
            .option-group-actions { width: 100%; }
            .option-row { grid-template-columns: 1fr; gap: .25rem; }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const groups = @json($optionGroups);
            let selectedIds = @json($selectedIds).map(Number);
            let draggingId = null;

            const assigned = document.getElementById('assigned-groups');
            const available = document.getElementById('available-groups');
            const search = document.getElementById('option-group-search');

            const escapeHtml = function (value) {
                const element = document.createElement('div');
                element.textContent = String(value ?? '');
                return element.innerHTML;
            };

            const groupById = function (id) {
                return groups.find(function (group) { return Number(group.id) === Number(id); });
            };

            const selectedGroups = function () {
                return selectedIds.map(groupById).filter(Boolean);
            };

            const groupFlags = function (group) {
                const flags = [];
                if (group.is_main_price_group) flags.push('<span class="badge badge-primary">Main Price</span>');
                if (group.is_required) flags.push('<span class="badge badge-warning">Required</span>');
                if (!group.is_active) flags.push('<span class="badge badge-secondary">Inactive</span>');
                return flags.join(' ');
            };

            const optionRows = function (group) {
                if (!group.options.length) {
                    return '<div class="text-muted small py-2">No active Product Options in this Option Group.</div>';
                }

                return group.options.map(function (option) {
                    const color = option.color_code
                        ? `<span class="option-color" style="background:${escapeHtml(option.color_code)}"></span><code>${escapeHtml(option.color_code)}</code>`
                        : '-';
                    const detail = option.option_detail
                        ? `<span class="text-muted small">${escapeHtml(option.option_detail)}</span>`
                        : '<span class="text-muted small">-</span>';
                    const ruleOptions = [
                        ['no_limit', 'No limit'],
                        ['minimum_only', 'Minimum only'],
                        ['maximum_only', 'Maximum only'],
                        ['exact_quantity_only', 'Exact quantity only'],
                        ['min_max_range', 'Min - Max range']
                    ].map(function (rule) {
                        return `<option value="${rule[0]}" ${option.quantity_rule === rule[0] ? 'selected' : ''}>${rule[1]}</option>`;
                    }).join('');

                    return `
                        <div class="option-row">
                            <div>
                                <label class="mb-0">
                                    <input type="checkbox" name="option_ids[${group.id}][]" value="${option.id}" ${option.is_selected ? 'checked' : ''}>
                                    <strong>${escapeHtml(option.option_name)}</strong>
                                </label>
                                <code class="small ml-1">${escapeHtml(option.option_code)}</code>
                            </div>
                            <div>${detail}</div>
                            <div class="text-nowrap">${color} <span class="text-muted small ml-1">${option.image_count} image(s)</span></div>
                            <div class="option-settings">
                                <label><input type="checkbox" name="option_config[${option.id}][is_default]" ${option.is_default ? 'checked' : ''}> Default</label>
                                <label><input type="checkbox" name="option_config[${option.id}][is_active]" ${option.is_active ? 'checked' : ''}> Active</label>
                                <label>Quantity Rule
                                    <select name="option_config[${option.id}][quantity_rule]" class="form-control form-control-sm mt-1">${ruleOptions}</select>
                                </label>
                                <label>Min Qty
                                    <input type="number" min="0" name="option_config[${option.id}][min_qty]" value="${option.min_qty ?? ''}" class="form-control form-control-sm mt-1">
                                </label>
                                <label>Max Qty
                                    <input type="number" min="0" name="option_config[${option.id}][max_qty]" value="${option.max_qty ?? ''}" class="form-control form-control-sm mt-1">
                                </label>
                                <label>Exact Qty
                                    <input type="number" min="0" name="option_config[${option.id}][exact_qty]" value="${option.exact_qty ?? ''}" class="form-control form-control-sm mt-1">
                                </label>
                            </div>
                        </div>
                    `;
                }).join('');
            };

            const renderAssigned = function () {
                const currentGroups = selectedGroups();

                if (!currentGroups.length) {
                    assigned.innerHTML = '<div class="empty-options">Choose an Option Group from the right-hand list to add it to this product.</div>';
                    return;
                }

                assigned.innerHTML = currentGroups.map(function (group, index) {
                    return `
                        <section class="option-group-card" draggable="true" data-group-id="${group.id}">
                            <input type="hidden" name="option_group_ids[]" value="${group.id}">
                            <header class="option-group-header">
                                <button type="button" class="option-group-handle" title="Drag to reorder" aria-label="Drag to reorder">☰</button>
                                <div class="option-group-title">
                                    <strong>${escapeHtml(group.group_name)}</strong>
                                    <div class="option-group-meta"><code>${escapeHtml(group.group_code)}</code> &middot; ${group.options.length} option(s) ${groupFlags(group)}</div>
                                </div>
                                <div class="option-group-actions">
                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-move-top" data-group-id="${group.id}" ${index === 0 ? 'disabled' : ''}>move to top</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-group" data-group-id="${group.id}">remove</button>
                                </div>
                            </header>
                            <div class="option-group-options">${optionRows(group)}</div>
                        </section>
                    `;
                }).join('');

                assigned.querySelectorAll('.option-group-card').forEach(bindDragEvents);
                assigned.querySelectorAll('.btn-remove-group').forEach(function (button) {
                    button.addEventListener('click', function () {
                        selectedIds = selectedIds.filter(function (id) { return Number(id) !== Number(button.dataset.groupId); });
                        render();
                    });
                });
                assigned.querySelectorAll('.btn-move-top').forEach(function (button) {
                    button.addEventListener('click', function () {
                        selectedIds = [Number(button.dataset.groupId)].concat(selectedIds.filter(function (id) { return Number(id) !== Number(button.dataset.groupId); }));
                        render();
                    });
                });
            };

            const renderAvailable = function () {
                const keyword = search.value.trim().toLowerCase();
                const groupsToShow = groups.filter(function (group) {
                    const haystack = `${group.group_code} ${group.group_name}`.toLowerCase();
                    return group.is_active && haystack.includes(keyword);
                });

                available.innerHTML = groupsToShow.length
                    ? groupsToShow.map(function (group) {
                        const isSelected = selectedIds.includes(Number(group.id));
                        return `
                            <button type="button" class="available-group" data-group-id="${group.id}" ${isSelected ? 'disabled' : ''}>
                                <strong>${escapeHtml(group.group_name)}</strong>
                                <small><code>${escapeHtml(group.group_code)}</code> &middot; ${group.options.length} option(s)${isSelected ? ' &middot; Added' : ''}</small>
                            </button>
                        `;
                    }).join('')
                    : '<p class="text-muted small p-2 mb-0">No Option Groups found.</p>';

                available.querySelectorAll('.available-group:not(:disabled)').forEach(function (button) {
                    button.addEventListener('click', function () {
                        selectedIds.push(Number(button.dataset.groupId));
                        render();
                    });
                });
            };

            const bindDragEvents = function (card) {
                card.addEventListener('dragstart', function () {
                    draggingId = Number(card.dataset.groupId);
                    card.classList.add('is-dragging');
                });
                card.addEventListener('dragend', function () {
                    draggingId = null;
                    card.classList.remove('is-dragging');
                });
                card.addEventListener('dragover', function (event) {
                    event.preventDefault();
                });
                card.addEventListener('drop', function (event) {
                    event.preventDefault();
                    const targetId = Number(card.dataset.groupId);
                    if (!draggingId || draggingId === targetId) return;
                    const from = selectedIds.indexOf(draggingId);
                    const to = selectedIds.indexOf(targetId);
                    selectedIds.splice(from, 1);
                    selectedIds.splice(to, 0, draggingId);
                    render();
                });
            };

            const render = function () {
                renderAssigned();
                renderAvailable();
            };

            search.addEventListener('input', renderAvailable);
            render();
        });
    </script>
@endpush
