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
            <div class="alert alert-danger">
                <div>Unable to save the Option Steps. Please try again.</div>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.products.options.update', $product) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-lg-9 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h2 class="h5 mb-1">Option Steps</h2>
                            <p class="text-muted small mb-0">Select a Step, then add its Option Groups from the right-hand list.</p>
                        </div>
                        <button id="add-step" type="button" class="btn btn-outline-primary">+ Add Step</button>
                    </div>

                    <div id="step-tabs" class="step-tabs mb-3"></div>
                    <div id="assigned-groups" class="assigned-groups"></div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary px-4">Save Steps &amp; Options</button>
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
        .step-tabs { display: flex; flex-wrap: wrap; gap: .7rem; }
        .step-tab { min-width: 145px; padding: .8rem 1rem; border: 1px solid #dce1e9; border-radius: .65rem; background: #fff; color: #435169; text-align: left; cursor: pointer; }
        .step-tab:hover { border-color: #8cb4ee; background: #f6f9ff; }
        .step-tab.is-active { border-color: #2674d9; background: #eaf3ff; box-shadow: inset 0 0 0 1px #2674d9; color: #174d98; }
        .step-tab strong, .step-tab small { display: block; }
        .step-tab small { margin-top: .2rem; color: #7a8797; }
        .assigned-groups { min-height: 120px; }
        .step-content { display: none; border: 1px solid #dce1e9; border-radius: .75rem; background: #fff; overflow: hidden; }
        .step-content.is-active { display: block; }
        .step-content-header { display: flex; align-items: center; gap: .8rem; padding: .9rem 1rem; background: #f8f9fc; border-bottom: 1px solid #e3e7ee; }
        .step-content-header label { margin: 0; font-size: .85rem; font-weight: 600; white-space: nowrap; }
        .step-name-input { max-width: 360px; }
        .step-content-body { padding: 1rem; }
        .option-group-card { border: 1px solid #dce1e9; border-radius: .75rem; margin-bottom: 1rem; overflow: hidden; }
        .option-group-card:last-child { margin-bottom: 0; }
        .option-group-card.is-dragging { opacity: .45; }
        .option-group-header { display: flex; align-items: center; gap: .75rem; padding: 1rem; background: #f8f9fc; border-bottom: 1px solid #e3e7ee; }
        .option-group-handle { cursor: grab; border: 1px solid #d9dee7; border-radius: .45rem; background: #fff; color: #728096; padding: .25rem .48rem; line-height: 1; }
        .option-group-title { flex: 1; min-width: 0; }
        .option-group-title strong { display: block; font-size: 1.02rem; }
        .option-group-meta { color: #7a8797; font-size: .8rem; }
        .option-group-actions { display: flex; gap: .35rem; align-items: center; }
        .move-step-select { width: 155px; }
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
            .step-content-header, .option-group-header { align-items: flex-start; flex-wrap: wrap; }
            .step-name-input, .option-group-actions { width: 100%; max-width: none; }
            .option-row { grid-template-columns: 1fr; gap: .25rem; }
            .option-settings { grid-template-columns: 1fr 1fr; }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const groups = @json($optionGroups);
            let selectedIds = @json($selectedIds).map(Number);
            let selectedGroupSteps = @json($selectedGroupSteps);
            let steps = @json($steps).map(function (step) {
                return { id: step.id, key: step.key, name: step.name };
            });
            let activeStepKey = steps[0]?.key || null;
            let draggingId = null;
            let nextStepNumber = steps.length + 1;

            const stepTabs = document.getElementById('step-tabs');
            const assigned = document.getElementById('assigned-groups');
            const available = document.getElementById('available-groups');
            const search = document.getElementById('option-group-search');

            const escapeHtml = function (value) {
                const element = document.createElement('div');
                element.textContent = String(value ?? '');
                return element.innerHTML;
            };

            const newStep = function () {
                const key = `new-step-${nextStepNumber}`;
                steps.push({ id: null, key: key, name: `Step ${nextStepNumber}` });
                nextStepNumber += 1;
                return key;
            };

            if (!steps.length) activeStepKey = newStep();

            selectedIds.forEach(function (groupId) {
                if (!selectedGroupSteps[groupId]) selectedGroupSteps[groupId] = activeStepKey;
            });

            const groupById = function (id) {
                return groups.find(function (group) { return Number(group.id) === Number(id); });
            };

            const groupsForStep = function (stepKey) {
                return selectedIds
                    .filter(function (id) { return selectedGroupSteps[id] === stepKey; })
                    .map(groupById)
                    .filter(Boolean);
            };

            const groupFlags = function (group) {
                const flags = [];
                if (group.is_main_price_group) flags.push('<span class="badge badge-primary">Main Price</span>');
                if (group.is_required) flags.push('<span class="badge badge-warning">Required</span>');
                if (!group.is_active) flags.push('<span class="badge badge-secondary">Inactive</span>');
                return flags.join(' ');
            };

            const captureFormState = function () {
                steps.forEach(function (step) {
                    const nameInput = document.querySelector(`[data-step-name="${step.key}"]`);
                    if (nameInput) step.name = nameInput.value;
                });

                groups.forEach(function (group) {
                    group.options.forEach(function (option) {
                        const selected = document.querySelector(`input[name="option_ids[${group.id}][]"][value="${option.id}"]`);
                        if (!selected) return;
                        option.is_selected = selected.checked;
                        option.is_default = document.querySelector(`input[name="option_config[${option.id}][is_default]"]`)?.checked || false;
                        option.is_active = document.querySelector(`input[name="option_config[${option.id}][is_active]"]`)?.checked || false;
                        option.quantity_rule = document.querySelector(`select[name="option_config[${option.id}][quantity_rule]"]`)?.value || 'no_limit';
                        option.min_qty = document.querySelector(`input[name="option_config[${option.id}][min_qty]"]`)?.value || '';
                        option.max_qty = document.querySelector(`input[name="option_config[${option.id}][max_qty]"]`)?.value || '';
                        option.exact_qty = document.querySelector(`input[name="option_config[${option.id}][exact_qty]"]`)?.value || '';
                    });
                });
            };

            const optionRows = function (group) {
                if (!group.options.length) return '<div class="text-muted small py-2">No active Product Options in this Option Group.</div>';

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

                    return `<div class="option-row">
                        <div>
                            <label class="mb-0"><input type="checkbox" name="option_ids[${group.id}][]" value="${option.id}" ${option.is_selected ? 'checked' : ''}> <strong>${escapeHtml(option.option_name)}</strong></label>
                            <code class="small ml-1">${escapeHtml(option.option_code)}</code>
                        </div>
                        <div>${detail}</div>
                        <div class="text-nowrap">${color} <span class="text-muted small ml-1">${option.image_count} image(s)</span></div>
                        <div class="option-settings">
                            <label><input type="checkbox" name="option_config[${option.id}][is_default]" value="1" ${option.is_default ? 'checked' : ''}> Default</label>
                            <label><input type="checkbox" name="option_config[${option.id}][is_active]" value="1" ${option.is_active ? 'checked' : ''}> Active</label>
                            <label>Quantity Rule<select name="option_config[${option.id}][quantity_rule]" class="form-control form-control-sm mt-1">${ruleOptions}</select></label>
                            <label>Min Qty<input type="number" min="0" name="option_config[${option.id}][min_qty]" value="${escapeHtml(option.min_qty)}" class="form-control form-control-sm mt-1"></label>
                            <label>Max Qty<input type="number" min="0" name="option_config[${option.id}][max_qty]" value="${escapeHtml(option.max_qty)}" class="form-control form-control-sm mt-1"></label>
                            <label>Exact Qty<input type="number" min="0" name="option_config[${option.id}][exact_qty]" value="${escapeHtml(option.exact_qty)}" class="form-control form-control-sm mt-1"></label>
                        </div>
                    </div>`;
                }).join('');
            };

            const reorderStepGroups = function (stepKey, orderedIds) {
                let cursor = 0;
                selectedIds = selectedIds.map(function (id) {
                    if (selectedGroupSteps[id] !== stepKey) return id;
                    return orderedIds[cursor++];
                });
            };

            const renderStepTabs = function () {
                stepTabs.innerHTML = steps.map(function (step, index) {
                    return `<button type="button" class="step-tab ${step.key === activeStepKey ? 'is-active' : ''}" data-step-key="${step.key}">
                        <strong>Step ${index + 1}</strong><small>${escapeHtml(step.name)} &middot; ${groupsForStep(step.key).length} group(s)</small>
                    </button>`;
                }).join('');

                stepTabs.querySelectorAll('.step-tab').forEach(function (tab) {
                    tab.addEventListener('click', function () {
                        activeStepKey = tab.dataset.stepKey;
                        renderStepTabs();
                        assigned.querySelectorAll('.step-content').forEach(function (content) {
                            content.classList.toggle('is-active', content.dataset.stepKey === activeStepKey);
                        });
                    });
                });
            };

            const groupCard = function (group, step, index) {
                const stepOptions = steps.map(function (candidate) {
                    return `<option value="${candidate.key}" ${candidate.key === step.key ? 'selected' : ''}>${escapeHtml(candidate.name)}</option>`;
                }).join('');

                return `<section class="option-group-card" draggable="true" data-group-id="${group.id}" data-step-key="${step.key}">
                    <input type="hidden" name="option_group_ids[]" value="${group.id}">
                    <input type="hidden" name="option_group_steps[${group.id}]" value="${step.key}">
                    <input type="hidden" name="option_group_sort_orders[${group.id}]" value="${index + 1}">
                    <header class="option-group-header">
                        <button type="button" class="option-group-handle" title="Drag to reorder" aria-label="Drag to reorder">&#9776;</button>
                        <div class="option-group-title"><strong>${escapeHtml(group.group_name)}</strong><div class="option-group-meta"><code>${escapeHtml(group.group_code)}</code> &middot; ${group.options.length} option(s) ${groupFlags(group)}</div></div>
                        <div class="option-group-actions">
                            <select class="form-control form-control-sm move-step-select" data-group-id="${group.id}" aria-label="Move to Step">${stepOptions}</select>
                            <button type="button" class="btn btn-sm btn-outline-secondary btn-move-top" data-group-id="${group.id}" ${index === 0 ? 'disabled' : ''}>move to top</button>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-group" data-group-id="${group.id}">remove</button>
                        </div>
                    </header>
                    <div class="option-group-options">${optionRows(group)}</div>
                </section>`;
            };

            const renderAssigned = function () {
                const stepInputs = steps.map(function (step) {
                    return `<input type="hidden" name="steps[${step.key}][key]" value="${step.key}"><input type="hidden" name="steps[${step.key}][id]" value="${step.id ?? ''}">`;
                }).join('');

                assigned.innerHTML = stepInputs + steps.map(function (step, stepIndex) {
                    const stepGroups = groupsForStep(step.key);
                    const cards = stepGroups.length
                        ? stepGroups.map(function (group, index) { return groupCard(group, step, index); }).join('')
                        : '<div class="empty-options">Select an Option Group from the right-hand list to add it to this Step.</div>';
                    return `<section class="step-content ${step.key === activeStepKey ? 'is-active' : ''}" data-step-key="${step.key}">
                        <header class="step-content-header">
                            <label for="step-name-${step.key}">Step ${stepIndex + 1} name</label>
                            <input id="step-name-${step.key}" data-step-name="${step.key}" name="steps[${step.key}][name]" type="text" class="form-control step-name-input" value="${escapeHtml(step.name)}" maxlength="255" required>
                            <button type="button" class="btn btn-sm btn-outline-danger ml-auto btn-remove-step" data-step-key="${step.key}" ${steps.length === 1 ? 'disabled title="At least one Step is required"' : ''}>Remove Step</button>
                        </header>
                        <div class="step-content-body">${cards}</div>
                    </section>`;
                }).join('');

                assigned.querySelectorAll('.option-group-card').forEach(bindDragEvents);
                assigned.querySelectorAll('.btn-remove-group').forEach(function (button) {
                    button.addEventListener('click', function () {
                        captureFormState();
                        const groupId = Number(button.dataset.groupId);
                        selectedIds = selectedIds.filter(function (id) { return Number(id) !== groupId; });
                        delete selectedGroupSteps[groupId];
                        render();
                    });
                });
                assigned.querySelectorAll('.btn-move-top').forEach(function (button) {
                    button.addEventListener('click', function () {
                        captureFormState();
                        const groupId = Number(button.dataset.groupId);
                        const stepKey = selectedGroupSteps[groupId];
                        const ids = groupsForStep(stepKey).map(function (group) { return Number(group.id); });
                        reorderStepGroups(stepKey, [groupId].concat(ids.filter(function (id) { return id !== groupId; })));
                        render();
                    });
                });
                assigned.querySelectorAll('.move-step-select').forEach(function (select) {
                    select.addEventListener('change', function () {
                        captureFormState();
                        selectedGroupSteps[Number(select.dataset.groupId)] = select.value;
                        activeStepKey = select.value;
                        render();
                    });
                });
                assigned.querySelectorAll('.btn-remove-step:not(:disabled)').forEach(function (button) {
                    button.addEventListener('click', function () {
                        captureFormState();
                        const removedKey = button.dataset.stepKey;
                        const destination = steps.find(function (step) { return step.key !== removedKey; });
                        groupsForStep(removedKey).forEach(function (group) { selectedGroupSteps[group.id] = destination.key; });
                        steps = steps.filter(function (step) { return step.key !== removedKey; });
                        activeStepKey = destination.key;
                        render();
                    });
                });
            };

            const renderAvailable = function () {
                const keyword = search.value.trim().toLowerCase();
                const groupsToShow = groups.filter(function (group) {
                    return group.is_active && `${group.group_code} ${group.group_name}`.toLowerCase().includes(keyword);
                });
                available.innerHTML = groupsToShow.length
                    ? groupsToShow.map(function (group) {
                        const isSelected = selectedIds.includes(Number(group.id));
                        return `<button type="button" class="available-group" data-group-id="${group.id}" ${isSelected ? 'disabled' : ''}><strong>${escapeHtml(group.group_name)}</strong><small><code>${escapeHtml(group.group_code)}</code> &middot; ${group.options.length} option(s)${isSelected ? ' &middot; Added' : ''}</small></button>`;
                    }).join('')
                    : '<p class="text-muted small p-2 mb-0">No Option Groups found.</p>';
                available.querySelectorAll('.available-group:not(:disabled)').forEach(function (button) {
                    button.addEventListener('click', function () {
                        captureFormState();
                        const groupId = Number(button.dataset.groupId);
                        selectedIds.push(groupId);
                        selectedGroupSteps[groupId] = activeStepKey;
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
                card.addEventListener('dragover', function (event) { event.preventDefault(); });
                card.addEventListener('drop', function (event) {
                    event.preventDefault();
                    const targetId = Number(card.dataset.groupId);
                    const stepKey = card.dataset.stepKey;
                    if (!draggingId || draggingId === targetId || selectedGroupSteps[draggingId] !== stepKey) return;
                    captureFormState();
                    const ids = groupsForStep(stepKey).map(function (group) { return Number(group.id); });
                    const from = ids.indexOf(draggingId);
                    const to = ids.indexOf(targetId);
                    ids.splice(from, 1);
                    ids.splice(to, 0, draggingId);
                    reorderStepGroups(stepKey, ids);
                    render();
                });
            };

            const render = function () {
                renderStepTabs();
                renderAssigned();
                renderAvailable();
            };

            document.getElementById('add-step').addEventListener('click', function () {
                captureFormState();
                activeStepKey = newStep();
                render();
            });
            search.addEventListener('input', renderAvailable);
            render();
        });
    </script>
@endpush
