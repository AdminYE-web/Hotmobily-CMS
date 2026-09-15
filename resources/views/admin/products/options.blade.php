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
                    <details class="manage-options-accordion option-steps-accordion mb-4">
                        <summary>
                            <span class="manage-options-accordion-title">Option Steps</span>
                            <span class="manage-options-accordion-description">Select a Step, then add its Option Groups from the right-hand list.</span>
                        </summary>
                        <div class="manage-options-accordion-body">
                            <div class="d-flex justify-content-end align-items-center mb-3">
                                <button id="add-step" type="button" class="btn btn-outline-primary">+ Add Step</button>
                            </div>
                            <div id="step-tabs" class="step-tabs mb-3"></div>
                            <div id="assigned-groups" class="assigned-groups"></div>
                        </div>
                    </details>

                    <details class="manage-options-accordion summary-builder mt-4">
                        <summary>
                            <span class="manage-options-accordion-title">Order Summary Settings</span>
                            <span class="manage-options-accordion-description">Configure the fields, display names, and order separately for each summary section.</span>
                        </summary>
                        <div class="summary-builder-body">
                            <div class="summary-config-grid">
                                <details class="summary-config-panel manage-options-accordion">
                                    <summary>
                                        <span class="manage-options-accordion-title">Preview summary (top)</span>
                                        <span class="manage-options-accordion-description">The compact table above the Step navigation.</span>
                                    </summary>
                                    <div class="summary-config-panel-body">
                                        <div class="d-flex justify-content-end mb-2">
                                            <button id="generate-preview-summary" type="button" class="btn btn-sm btn-outline-primary">+ Generate List</button>
                                        </div>
                                        <div class="summary-choice-heading">
                                    <strong>Available option fields</strong>
                                    <span class="text-muted small">Choose fields for this section.</span>
                                        </div>
                                        <input type="hidden" name="preview_summary_field_keys_present" value="1">
                                        <div id="preview-summary-option-choices" class="summary-option-choices"></div>
                                        <div id="preview-summary-groups" class="summary-groups"></div>
                                    </div>
                                </details>
                                <details class="summary-config-panel manage-options-accordion">
                                    <summary>
                                        <span class="manage-options-accordion-title">Detailed summary (bottom)</span>
                                        <span class="manage-options-accordion-description">Choose the fields shown in the Product Specification table on the storefront.</span>
                                    </summary>
                                    <div class="summary-config-panel-body">
                                        <div class="d-flex justify-content-end mb-2">
                                            <button id="generate-summary" type="button" class="btn btn-sm btn-outline-primary">+ Generate List</button>
                                        </div>
                                        <div class="summary-step-control">
                                    <label for="summary-step-key" class="mb-0">Display summary in</label>
                                    <select id="summary-step-key" name="summary_step_key" class="form-control form-control-sm"></select>
                                        </div>
                                        <div class="summary-choice-heading">
                                    <strong>Available specification fields</strong>
                                    <span class="text-muted small">Choose fields for the Product Specification table.</span>
                                        </div>
                                        <input type="hidden" name="summary_field_keys_present" value="1">
                                        <div id="summary-option-choices" class="summary-option-choices"></div>
                                        <div id="summary-groups" class="summary-groups"></div>
                                    </div>
                                </details>
                                <details class="summary-config-panel manage-options-accordion">
                                    <summary>
                                        <span class="manage-options-accordion-title">Production charges (price)</span>
                                        <span class="manage-options-accordion-description">Configure the displayed name. Prices are taken automatically from the related Product Option.</span>
                                    </summary>
                                    <div class="summary-config-panel-body">
                                        <div class="d-flex justify-content-end mb-2">
                                            <button id="generate-price-summary" type="button" class="btn btn-sm btn-outline-primary">+ Generate List</button>
                                        </div>
                                        <div class="summary-choice-heading">
                                    <strong>Available price fields</strong>
                                    <span class="text-muted small">Choose fields for the Production Charges table.</span>
                                        </div>
                                        <input type="hidden" name="price_summary_field_keys_present" value="1">
                                        <div id="price-summary-option-choices" class="summary-option-choices"></div>
                                        <div id="price-summary-groups" class="summary-groups"></div>
                                    </div>
                                </details>
                                <details class="summary-config-panel manage-options-accordion">
                                    <summary>
                                        <span class="manage-options-accordion-title">PDF export - Product specification</span>
                                        <span class="manage-options-accordion-description">Choose the fields, display names, and order in the exported PDF. This is independent from the storefront summaries.</span>
                                    </summary>
                                    <div class="summary-config-panel-body">
                                        <div class="d-flex flex-wrap justify-content-end gap-2 mb-2">
                                            <button id="generate-pdf-summary" type="button" class="btn btn-sm btn-outline-primary">+ Generate List</button>
                                            <button id="add-pdf-custom-row" type="button" class="btn btn-sm btn-outline-secondary">+ Add Custom Row</button>
                                        </div>
                                        <div class="summary-choice-heading">
                                    <strong>Available PDF fields</strong>
                                    <span class="text-muted small">Choose fields for the Product Specification table in the PDF.</span>
                                        </div>
                                        <input type="hidden" name="pdf_summary_field_keys_present" value="1">
                                        <div id="pdf-summary-option-choices" class="summary-option-choices"></div>
                                        <div id="pdf-summary-groups" class="summary-groups"></div>
                                    </div>
                                </details>
                            </div>
                        </div>
                    </details>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary px-4">Save Steps &amp; Options</button>
                    </div>
                </div>

                <aside class="col-lg-3 mb-4">
                    <details class="card shadow-sm option-group-picker manage-options-accordion">
                        <summary class="card-header">Available Option Groups</summary>
                        <div class="card-body p-2">
                            <input id="option-group-search" type="search" class="form-control mb-2" placeholder="Search option group...">
                            <div id="available-groups" class="available-groups"></div>
                        </div>
                    </details>
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
        .option-row { display: grid; grid-template-columns: minmax(180px, 1fr) minmax(140px, 1.5fr) auto; gap: .75rem; align-items: center; padding: .7rem .25rem; border-bottom: 1px solid #edf0f4; cursor: grab; transition: opacity .16s ease, transform .16s ease; }
        .option-row:last-child { border-bottom: 0; }
        .option-row.is-dragging { opacity: .45; }
        .option-row-placeholder { height: 0; margin: 0; border-top: 0 solid #2674d9; background: rgba(38, 116, 217, .08); opacity: 0; pointer-events: none; transition: height .16s ease, margin .16s ease, border-width .16s ease, opacity .16s ease; }
        .option-row-placeholder.is-visible { height: 10px; margin: .2rem 0; border-top-width: 3px; opacity: 1; }
        .option-row-handle { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; margin-right: .4rem; padding: 0; border: 1px solid #d9dee7; border-radius: .35rem; background: #fff; color: #728096; cursor: grab; line-height: 1; vertical-align: middle; }
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
        .manage-options-accordion { border: 1px solid #dce1e9; border-radius: .75rem; background: #f8f9fc; overflow: hidden; }
        .manage-options-accordion > summary { display: flex; align-items: center; gap: .6rem; padding: .9rem 1rem; cursor: pointer; list-style: none; }
        .manage-options-accordion > summary::-webkit-details-marker { display: none; }
        .manage-options-accordion > summary::after { margin-left: auto; color: #728096; content: '+'; font-size: 1.1rem; font-weight: 700; }
        .manage-options-accordion[open] > summary::after { content: '-'; }
        .manage-options-accordion-title { color: #26364d; font-weight: 700; }
        .manage-options-accordion-description { color: #7a8797; font-size: .8rem; }
        .manage-options-accordion-body { padding: 1rem; background: #fff; border-top: 1px solid #e3e7ee; }
        .summary-builder { padding: 0; }
        .summary-builder-body { padding: 1rem; }
        .summary-config-grid { display: grid; grid-template-columns: 1fr; gap: 1rem; }
        .summary-config-panel { min-width: 0; padding: 0; border-radius: .6rem; background: #fff; }
        .summary-config-panel > summary { padding: .85rem; background: #fff; }
        .summary-config-panel[open] > summary { border-bottom: 1px solid #e3e7ee; background: #f8f9fc; }
        .summary-config-panel-body { padding: .85rem; }
        .summary-config-panel h3 { color: #26364d; }
        .summary-step-control { display: flex; align-items: center; gap: .7rem; max-width: 480px; margin: .75rem 0 .35rem; }
        .summary-step-control label { flex: 0 0 auto; font-size: .85rem; font-weight: 600; }
        .summary-step-control select { max-width: 280px; }
        .summary-choice-heading { display: flex; flex-wrap: wrap; align-items: baseline; gap: .4rem .75rem; margin-top: .75rem; }
        .summary-option-choices { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: .45rem; max-width: 850px; margin-top: .45rem; }
        .summary-option-choice { display: flex; align-items: flex-start; gap: .5rem; padding: .55rem .7rem; border: 1px solid #dce1e9; border-radius: .45rem; background: #fff; cursor: pointer; }
        .summary-option-choice:hover { border-color: #8cb4ee; background: #f6f9ff; }
        .summary-option-choice input { margin-top: .2rem; }
        .summary-option-choice-content { min-width: 0; }
        .summary-option-choice-content strong, .summary-option-choice-content small { display: block; }
        .summary-option-choice-content small { margin-top: .15rem; color: #7a8797; overflow-wrap: anywhere; }
        .summary-groups { max-width: 640px; }
        .summary-row { display: flex; align-items: center; gap: .7rem; margin-top: .45rem; padding: .65rem .75rem; border: 1px solid #dce1e9; border-radius: .45rem; background: #fff; cursor: grab; transition: opacity .16s ease; }
        .summary-row.is-dragging { opacity: .45; }
        .summary-row-handle { color: #728096; cursor: grab; }
        .summary-row-name { flex: 1; }
        .summary-row-parent { display: block; margin-top: .15rem; color: #7a8797; font-size: .75rem; }
        .summary-label-editor { display: flex; align-items: center; flex-wrap: wrap; gap: .35rem .55rem; margin-top: .35rem; color: #7a8797; font-size: .75rem; font-weight: 600; }
        .summary-label-editor input { width: min(100%, 320px); padding: .25rem .45rem; border: 1px solid #cbd3df; border-radius: .3rem; font: inherit; font-weight: 400; color: #435169; }
        .summary-custom-editor { align-items: flex-start; }
        .summary-custom-editor textarea { box-sizing: border-box; width: min(100%, 520px); min-height: 70px; padding: .35rem .45rem; border: 1px solid #cbd3df; border-radius: .3rem; font: inherit; font-weight: 400; color: #435169; resize: vertical; }
        .summary-empty { padding: .9rem; border: 1px dashed #cbd3df; border-radius: .45rem; color: #7a8797; background: #fff; }
        .summary-config-panel .gap-2 { gap: .5rem; }
        .option-group-picker > summary { background: #f8f9fc; color: #26364d; font-weight: 700; }
        @media (max-width: 767.98px) {
            .summary-config-grid { grid-template-columns: 1fr; }
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
            let summaryFieldKeys = @json($summaryFieldKeys);
            let previewSummaryFieldKeys = @json($previewSummaryFieldKeys);
            let priceSummaryFieldKeys = @json($priceSummaryFieldKeys);
            let pdfSummaryFieldKeys = @json($pdfSummaryFieldKeys);
            let pdfSummaryCustomRows = @json($pdfSummaryCustomRows ?? []);
            if (!Array.isArray(pdfSummaryCustomRows)) pdfSummaryCustomRows = Object.values(pdfSummaryCustomRows || {});
            let summaryStepKey = @json($summaryStepKey);
            let steps = @json($steps).map(function (step) {
                return { id: step.id, key: step.key, name: step.name, isSummaryStep: Boolean(step.is_summary_step) };
            });
            let activeStepKey = steps[0]?.key || null;
            let draggingId = null;
            let draggingOption = null;
            let optionDropPlaceholder = null;
            let draggingSummaryKey = null;
            let draggingPreviewSummaryKey = null;
            let draggingPriceSummaryKey = null;
            let draggingPdfSummaryKey = null;
            let nextStepNumber = steps.length + 1;

            const stepTabs = document.getElementById('step-tabs');
            const assigned = document.getElementById('assigned-groups');
            const available = document.getElementById('available-groups');
            const search = document.getElementById('option-group-search');
            const summaryStepSelect = document.getElementById('summary-step-key');
            const previewSummaryOptionChoices = document.getElementById('preview-summary-option-choices');
            const previewSummaryGroups = document.getElementById('preview-summary-groups');
            const summaryOptionChoices = document.getElementById('summary-option-choices');
            const summaryGroups = document.getElementById('summary-groups');
            const priceSummaryOptionChoices = document.getElementById('price-summary-option-choices');
            const priceSummaryGroups = document.getElementById('price-summary-groups');
            const pdfSummaryOptionChoices = document.getElementById('pdf-summary-option-choices');
            const pdfSummaryGroups = document.getElementById('pdf-summary-groups');

            const escapeHtml = function (value) {
                const element = document.createElement('div');
                element.textContent = String(value ?? '');
                return element.innerHTML;
            };

            const captureSummaryLabels = function () {
                previewSummaryGroups?.querySelectorAll('[data-summary-field-label-key]').forEach(function (input) {
                    const field = summaryFieldForKey(input.dataset.summaryFieldLabelKey);
                    if (field) field.option
                        ? field.option.preview_summary_label = input.value
                        : field.group.preview_summary_label = input.value;
                });
                summaryGroups?.querySelectorAll('[data-summary-field-label-key]').forEach(function (input) {
                    const field = summaryFieldForKey(input.dataset.summaryFieldLabelKey);
                    if (field) field.option
                        ? field.option.summary_label = input.value
                        : field.group.summary_label = input.value;
                });
                priceSummaryGroups?.querySelectorAll('[data-summary-field-label-key]').forEach(function (input) {
                    const field = summaryFieldForKey(input.dataset.summaryFieldLabelKey);
                    if (field) field.option
                        ? field.option.price_summary_label = input.value
                        : field.group.price_summary_label = input.value;
                });
                pdfSummaryGroups?.querySelectorAll('[data-summary-field-label-key]').forEach(function (input) {
                    const field = summaryFieldForKey(input.dataset.summaryFieldLabelKey);
                    if (!field) return;
                    if (field.custom) field.custom.label = input.value;
                    else if (field.option) field.option.pdf_summary_label = input.value;
                    else field.group.pdf_summary_label = input.value;
                });
                pdfSummaryGroups?.querySelectorAll('[data-pdf-custom-content-key]').forEach(function (input) {
                    const field = summaryFieldForKey(input.dataset.pdfCustomContentKey);
                    if (field?.custom) field.custom.content = input.value;
                });
            };

            const newStep = function () {
                const key = `new-step-${nextStepNumber}`;
                steps.push({ id: null, key: key, name: `Step ${nextStepNumber}` });
                if (!summaryStepKey) summaryStepKey = key;
                nextStepNumber += 1;
                return key;
            };

            if (!steps.length) activeStepKey = newStep();
            if (!summaryStepKey && steps.length) summaryStepKey = steps[0].key;

            selectedIds.forEach(function (groupId) {
                if (!selectedGroupSteps[groupId]) selectedGroupSteps[groupId] = activeStepKey;
            });

            const groupById = function (id) {
                return groups.find(function (group) { return Number(group.id) === Number(id); });
            };

            const summaryFieldForKey = function (fieldKey) {
                if (String(fieldKey).startsWith('custom-')) {
                    const custom = pdfSummaryCustomRows.find(function (row) {
                        return row.key === String(fieldKey);
                    });
                    return custom ? { key: String(fieldKey), group: null, option: null, custom: custom } : null;
                }

                const match = /^(option|group)-(\d+)$/.exec(String(fieldKey));
                if (!match) return null;

                const type = match[1];
                const id = Number(match[2]);
                if (type === 'group') {
                    const group = groupById(id);
                    return group ? { key: String(fieldKey), group: group, option: null } : null;
                }

                for (const group of groups) {
                    const option = group.options.find(function (candidate) {
                        return Number(candidate.id) === id;
                    });
                    if (option) return { key: String(fieldKey), group: group, option: option };
                }

                return null;
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
                captureSummaryLabels();
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
                if (group.display_type === 'quantity_input') {
                    return '<div class="text-muted small py-2">This group renders a product-quantity field. Product Options are not required.</div>';
                }
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

                    return `<div class="option-row" draggable="true" data-group-id="${group.id}" data-option-id="${option.id}">
                        <div>
                            <button type="button" class="option-row-handle" title="Drag to reorder" aria-label="Drag to reorder">&#9776;</button><label class="mb-0"><input type="checkbox" name="option_ids[${group.id}][]" value="${option.id}" ${option.is_selected ? 'checked' : ''}> <strong>${escapeHtml(option.option_name)}</strong></label>
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

            const reorderGroupOptions = function (groupId, orderedIds) {
                const group = groupById(groupId);
                if (!group) return;

                const optionsById = new Map(group.options.map(function (option) {
                    return [Number(option.id), option];
                }));
                group.options = orderedIds
                    .map(function (optionId) { return optionsById.get(Number(optionId)); })
                    .filter(Boolean);
            };

            const renderSummary = function () {
                captureSummaryLabels();
                summaryGroupIds = summaryGroupIds.filter(function (groupId) {
                    const group = groupById(groupId);
                    return selectedIds.includes(Number(groupId)) && Boolean(group);
                });

                if (!summaryGroupIds.length) {
                    summaryGroups.innerHTML = '<div class="summary-empty">No summary items yet. Click Generate Summary List to add the selected Option Groups marked “Show in order summary”.</div>';
                    return;
                }

                summaryGroups.innerHTML = summaryGroupIds.map(function (groupId, index) {
                    const group = groupById(groupId);
                    if (!group) return '';
                    return `<div class="summary-row" draggable="true" data-summary-group-id="${group.id}">
                        <input type="hidden" name="summary_group_ids[]" value="${group.id}">
                        <span class="summary-row-handle" title="Drag to reorder" aria-hidden="true">&#9776;</span>
                        <span class="badge badge-light border">${index + 1}</span>
                        <span class="summary-row-name">
                            <strong>${escapeHtml(group.group_name)}</strong> <code class="small ml-1">${escapeHtml(group.group_code)}</code>
                            <label class="summary-label-editor">
                                <span>Display name</span>
                                <input type="text" name="summary_group_labels[${group.id}]" data-summary-label-id="${group.id}" value="${escapeHtml(group.summary_label || '')}" placeholder="${escapeHtml(group.group_name)}" maxlength="255">
                            </label>
                        </span>
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-summary" data-summary-group-id="${group.id}">Remove</button>
                    </div>`;
                }).join('');

                summaryGroups.querySelectorAll('.summary-row').forEach(bindSummaryDragEvents);
                summaryGroups.querySelectorAll('[data-summary-label-id]').forEach(function (input) {
                    input.addEventListener('input', function () {
                        const group = groupById(input.dataset.summaryLabelId);
                        if (group) group.summary_label = input.value;
                    });
                });
                summaryGroups.querySelectorAll('.btn-remove-summary').forEach(function (button) {
                    button.addEventListener('click', function () {
                        summaryGroupIds = summaryGroupIds.filter(function (id) { return id !== Number(button.dataset.summaryGroupId); });
                        renderSummaryChoices();
                        renderSummary();
                    });
                });
            };

            const renderSummaryChoices = function () {
                if (!summaryOptionChoices) return;

                const availableGroups = selectedIds
                    .map(groupById)
                    .filter(Boolean);

                if (!availableGroups.length) {
                    summaryOptionChoices.innerHTML = '<div class="summary-empty">Add an Option Group first to choose summary fields.</div>';
                    return;
                }

                summaryOptionChoices.innerHTML = availableGroups.map(function (group) {
                    const optionNames = group.options.length
                        ? group.options.map(function (option) { return option.option_name; }).join(' / ')
                        : 'Quantity input';
                    const isChecked = summaryGroupIds.includes(Number(group.id));

                    return `<label class="summary-option-choice">
                        <input type="checkbox" data-summary-choice-id="${group.id}" ${isChecked ? 'checked' : ''}>
                        <span class="summary-option-choice-content">
                            <strong>${escapeHtml(group.group_name)} <code class="small ml-1">${escapeHtml(group.group_code)}</code></strong>
                            <small>${escapeHtml(optionNames)}</small>
                        </span>
                    </label>`;
                }).join('');

                summaryOptionChoices.querySelectorAll('[data-summary-choice-id]').forEach(function (checkbox) {
                    checkbox.addEventListener('change', function () {
                        const groupId = Number(checkbox.dataset.summaryChoiceId);
                        if (checkbox.checked) {
                            if (!summaryGroupIds.includes(groupId)) summaryGroupIds.push(groupId);
                        } else {
                            summaryGroupIds = summaryGroupIds.filter(function (id) { return id !== groupId; });
                        }
                        renderSummary();
                    });
                });
            };

            const renderPreviewSummary = function () {
                captureSummaryLabels();
                previewSummaryGroupIds = previewSummaryGroupIds.filter(function (groupId) {
                    const group = groupById(groupId);
                    return selectedIds.includes(Number(groupId)) && Boolean(group);
                });

                if (!previewSummaryGroupIds.length) {
                    previewSummaryGroups.innerHTML = '<div class="summary-empty">No preview items yet. Select fields above or click Generate List.</div>';
                    return;
                }

                previewSummaryGroups.innerHTML = previewSummaryGroupIds.map(function (groupId, index) {
                    const group = groupById(groupId);
                    if (!group) return '';

                    return '<div class="summary-row" draggable="true" data-preview-summary-group-id="' + group.id + '">'
                        + '<input type="hidden" name="preview_summary_group_ids[]" value="' + group.id + '">'
                        + '<span class="summary-row-handle" title="Drag to reorder" aria-hidden="true">&#9776;</span>'
                        + '<span class="badge badge-light border">' + (index + 1) + '</span>'
                        + '<span class="summary-row-name">'
                        + '<strong>' + escapeHtml(group.group_name) + '</strong> <code class="small ml-1">' + escapeHtml(group.group_code) + '</code>'
                        + '<label class="summary-label-editor">'
                        + '<span>Display name</span>'
                        + '<input type="text" name="preview_summary_group_labels[' + group.id + ']" data-preview-summary-label-id="' + group.id + '" value="' + escapeHtml(group.preview_summary_label || '') + '" placeholder="' + escapeHtml(group.group_name) + '" maxlength="255">'
                        + '</label>'
                        + '</span>'
                        + '<button type="button" class="btn btn-sm btn-outline-danger btn-remove-preview-summary" data-preview-summary-group-id="' + group.id + '">Remove</button>'
                        + '</div>';
                }).join('');

                previewSummaryGroups.querySelectorAll('.summary-row').forEach(bindPreviewSummaryDragEvents);
                previewSummaryGroups.querySelectorAll('[data-preview-summary-label-id]').forEach(function (input) {
                    input.addEventListener('input', function () {
                        const group = groupById(input.dataset.previewSummaryLabelId);
                        if (group) group.preview_summary_label = input.value;
                    });
                });
                previewSummaryGroups.querySelectorAll('.btn-remove-preview-summary').forEach(function (button) {
                    button.addEventListener('click', function () {
                        previewSummaryGroupIds = previewSummaryGroupIds.filter(function (id) {
                            return id !== Number(button.dataset.previewSummaryGroupId);
                        });
                        renderPreviewSummaryChoices();
                        renderPreviewSummary();
                    });
                });
            };

            const renderPreviewSummaryChoices = function () {
                if (!previewSummaryOptionChoices) return;

                const availableGroups = selectedIds
                    .map(groupById)
                    .filter(Boolean);

                if (!availableGroups.length) {
                    previewSummaryOptionChoices.innerHTML = '<div class="summary-empty">Add an Option Group first to choose preview fields.</div>';
                    return;
                }

                previewSummaryOptionChoices.innerHTML = availableGroups.map(function (group) {
                    const optionNames = group.options.length
                        ? group.options.map(function (option) { return option.option_name; }).join(' / ')
                        : 'Quantity input';
                    const isChecked = previewSummaryGroupIds.includes(Number(group.id));

                    return '<label class="summary-option-choice">'
                        + '<input type="checkbox" data-preview-summary-choice-id="' + group.id + '"' + (isChecked ? ' checked' : '') + '>'
                        + '<span class="summary-option-choice-content">'
                        + '<strong>' + escapeHtml(group.group_name) + ' <code class="small ml-1">' + escapeHtml(group.group_code) + '</code></strong>'
                        + '<small>' + escapeHtml(optionNames) + '</small>'
                        + '</span>'
                        + '</label>';
                }).join('');

                previewSummaryOptionChoices.querySelectorAll('[data-preview-summary-choice-id]').forEach(function (checkbox) {
                    checkbox.addEventListener('change', function () {
                        const groupId = Number(checkbox.dataset.previewSummaryChoiceId);
                        if (checkbox.checked) {
                            if (!previewSummaryGroupIds.includes(groupId)) previewSummaryGroupIds.push(groupId);
                        } else {
                            previewSummaryGroupIds = previewSummaryGroupIds.filter(function (id) {
                                return id !== groupId;
                            });
                        }
                        renderPreviewSummary();
                    });
                });
            };

            const summaryListConfig = function (mode) {
                const isPreview = mode === true || mode === 'preview';

                if (isPreview) {
                    return {
                        isPreview: true,
                        isPrice: false,
                        getKeys: function () { return previewSummaryFieldKeys; },
                        setKeys: function (keys) { previewSummaryFieldKeys = keys; },
                        container: previewSummaryGroups,
                        choices: previewSummaryOptionChoices,
                        labelProperty: 'preview_summary_label',
                        keysInputName: 'preview_summary_field_keys[]',
                        labelsInputName: 'preview_summary_field_labels',
                        labelDataAttribute: 'data-summary-field-label-key',
                        choiceDataAttribute: 'data-preview-summary-choice-key',
                        rowDataAttribute: 'data-preview-summary-field-key',
                        removeClass: 'btn-remove-preview-summary-field',
                        emptyMessage: 'No preview items yet. Select fields above or click Generate List.',
                    };
                }

                if (mode === 'price') {
                    return {
                        isPreview: false,
                        isPrice: true,
                        isPdf: false,
                        getKeys: function () { return priceSummaryFieldKeys; },
                        setKeys: function (keys) { priceSummaryFieldKeys = keys; },
                        container: priceSummaryGroups,
                        choices: priceSummaryOptionChoices,
                        labelProperty: 'price_summary_label',
                        keysInputName: 'price_summary_field_keys[]',
                        labelsInputName: 'price_summary_field_labels',
                        labelDataAttribute: 'data-summary-field-label-key',
                        choiceDataAttribute: 'data-price-summary-choice-key',
                        rowDataAttribute: 'data-price-summary-field-key',
                        removeClass: 'btn-remove-price-summary-field',
                        emptyMessage: 'No price items yet. Select fields above or click Generate List.',
                    };
                }

                if (mode === 'pdf') {
                    return {
                        isPreview: false,
                        isPrice: false,
                        isPdf: true,
                        getKeys: function () { return pdfSummaryFieldKeys; },
                        setKeys: function (keys) { pdfSummaryFieldKeys = keys; },
                        container: pdfSummaryGroups,
                        choices: pdfSummaryOptionChoices,
                        labelProperty: 'pdf_summary_label',
                        keysInputName: 'pdf_summary_field_keys[]',
                        labelsInputName: 'pdf_summary_field_labels',
                        labelDataAttribute: 'data-summary-field-label-key',
                        choiceDataAttribute: 'data-pdf-summary-choice-key',
                        rowDataAttribute: 'data-pdf-summary-field-key',
                        removeClass: 'btn-remove-pdf-summary-field',
                        emptyMessage: 'No PDF specification items yet. Select fields above or click Generate List.',
                    };
                }

                return {
                    isPreview: false,
                    isPrice: false,
                    isPdf: false,
                    getKeys: function () { return summaryFieldKeys; },
                    setKeys: function (keys) { summaryFieldKeys = keys; },
                    container: summaryGroups,
                    choices: summaryOptionChoices,
                    labelProperty: 'summary_label',
                    keysInputName: 'summary_field_keys[]',
                    labelsInputName: 'summary_field_labels',
                    labelDataAttribute: 'data-summary-field-label-key',
                    choiceDataAttribute: 'data-summary-choice-key',
                    rowDataAttribute: 'data-summary-field-key',
                    removeClass: 'btn-remove-summary-field',
                    emptyMessage: 'No product specification items yet. Select fields above or click Generate List.',
                };
            };

            const availableSummaryFields = function () {
                return selectedIds
                    .map(groupById)
                    .filter(Boolean)
                    .reduce(function (fields, group) {
                        if (group.display_type === 'switch' && group.options.length) {
                            group.options
                                .filter(function (option) { return option.is_selected !== false; })
                                .forEach(function (option) {
                                    fields.push(summaryFieldForKey('option-' + option.id));
                                });
                        } else {
                            fields.push(summaryFieldForKey('group-' + group.id));
                        }

                        return fields;
                    }, [])
                    .filter(Boolean);
            };

            const renderOptionSummaryList = function (mode) {
                const config = summaryListConfig(mode);
                captureSummaryLabels();
                const keys = config.getKeys().filter(function (fieldKey) {
                    const field = summaryFieldForKey(fieldKey);
                    if (!field) return false;
                    if (field.custom) return config.isPdf === true;

                    return selectedIds.includes(Number(field.group.id))
                        && (!field.option || field.group.display_type === 'switch')
                        && (!field.option || field.option.is_selected !== false);
                });
                config.setKeys(keys);

                if (!keys.length) {
                    config.container.innerHTML = '<div class="summary-empty">' + config.emptyMessage + '</div>';
                    return;
                }

                config.container.innerHTML = keys.map(function (fieldKey, index) {
                    const field = summaryFieldForKey(fieldKey);
                    if (!field) return '';
                    const itemName = field.custom ? 'Custom PDF row' : (field.option ? field.option.option_name : field.group.group_name);
                    const itemCode = field.custom ? 'custom' : (field.option ? field.option.option_code : field.group.group_code);
                    const parentName = field.option ? field.group.group_name : '';
                    const defaultLabel = field.custom ? '' : (field.option ? field.option.option_name : field.group.group_name);
                    const currentLabel = field.custom
                        ? (field.custom.label || '')
                        : (field.option
                            ? (field.option[config.labelProperty] || field.option.option_name)
                            : (field.group[config.labelProperty] || field.group.group_name));
                    const labelValue = field.custom
                        ? currentLabel
                        : (currentLabel === defaultLabel ? '' : currentLabel);
                    const customEditor = field.custom
                        ? '<label class="summary-label-editor summary-custom-editor">'
                            + '<span>Heading</span>'
                            + '<input type="text" name="pdf_summary_custom_rows[' + escapeHtml(field.key) + '][label]" data-summary-field-label-key="' + escapeHtml(field.key) + '" data-pdf-custom-label-key="' + escapeHtml(field.key) + '" value="' + escapeHtml(currentLabel) + '" placeholder="Heading" maxlength="255" required>'
                            + '</label>'
                            + '<label class="summary-label-editor summary-custom-editor">'
                            + '<span>Text</span>'
                            + '<textarea name="pdf_summary_custom_rows[' + escapeHtml(field.key) + '][content]" data-pdf-custom-content-key="' + escapeHtml(field.key) + '" rows="3" maxlength="5000" placeholder="Text shown in the PDF">' + escapeHtml(field.custom.content || '') + '</textarea>'
                            + '</label>'
                        : '<label class="summary-label-editor">'
                            + '<span>Display name</span>'
                            + '<input type="text" name="' + config.labelsInputName + '[' + escapeHtml(field.key) + ']" ' + config.labelDataAttribute + '="' + escapeHtml(field.key) + '" value="' + escapeHtml(labelValue) + '" placeholder="' + escapeHtml(defaultLabel) + '" maxlength="255">'
                            + '</label>';

                    return '<div class="summary-row" draggable="true" data-summary-field-key="' + escapeHtml(field.key) + '">'
                        + '<input type="hidden" name="' + config.keysInputName + '" value="' + escapeHtml(field.key) + '">'
                        + '<span class="summary-row-handle" title="Drag to reorder" aria-hidden="true">&#9776;</span>'
                        + '<span class="badge badge-light border">' + (index + 1) + '</span>'
                        + '<span class="summary-row-name">'
                        + '<strong>' + escapeHtml(itemName) + '</strong> <code class="small ml-1">' + escapeHtml(itemCode) + '</code>'
                        + (parentName ? '<small class="summary-row-parent">' + escapeHtml(parentName) + '</small>' : '')
                        + customEditor
                        + '</span>'
                        + '<button type="button" class="btn btn-sm btn-outline-danger ' + config.removeClass + '" data-summary-field-key="' + escapeHtml(field.key) + '">Remove</button>'
                        + '</div>';
                }).join('');

                config.container.querySelectorAll('.summary-row').forEach(function (row) {
                    bindOptionSummaryDragEvents(row, mode);
                });
                config.container.querySelectorAll('[' + config.labelDataAttribute + ']').forEach(function (input) {
                    input.addEventListener('input', function () {
                        const field = summaryFieldForKey(input.dataset.summaryFieldLabelKey);
                        if (!field) return;
                        if (field.custom) field.custom.label = input.value;
                        else if (field.option) field.option[config.labelProperty] = input.value;
                        else field.group[config.labelProperty] = input.value;
                    });
                });
                if (config.isPdf) {
                    config.container.querySelectorAll('[data-pdf-custom-content-key]').forEach(function (input) {
                        input.addEventListener('input', function () {
                            const field = summaryFieldForKey(input.dataset.pdfCustomContentKey);
                            if (field?.custom) field.custom.content = input.value;
                        });
                    });
                }
                config.container.querySelectorAll('.' + config.removeClass).forEach(function (button) {
                    button.addEventListener('click', function () {
                        config.setKeys(config.getKeys().filter(function (key) {
                            return key !== button.dataset.summaryFieldKey;
                        }));
                        renderOptionSummaryChoices(mode);
                        renderOptionSummaryList(mode);
                    });
                });
            };

            const renderOptionSummaryChoices = function (mode) {
                const config = summaryListConfig(mode);
                const isPreview = mode === true || mode === 'preview';
                const isPrice = mode === 'price';
                const isPdf = mode === 'pdf';
                if (!config.choices) return;

                const fields = availableSummaryFields();
                if (!fields.length) {
                    config.choices.innerHTML = '<div class="summary-empty">Add an Option Group first to choose summary fields.</div>';
                    return;
                }

                config.choices.innerHTML = fields.map(function (field) {
                    const itemName = field.option ? field.option.option_name : field.group.group_name;
                    const itemCode = field.option ? field.option.option_code : field.group.group_code;
                    const parentName = field.option ? field.group.group_name : '';
                    const isChecked = config.getKeys().includes(field.key);

                    return '<label class="summary-option-choice">'
                        + '<input type="checkbox" ' + config.choiceDataAttribute + '="' + escapeHtml(field.key) + '"' + (isChecked ? ' checked' : '') + '>'
                        + '<span class="summary-option-choice-content">'
                        + '<strong>' + escapeHtml(itemName) + ' <code class="small ml-1">' + escapeHtml(itemCode) + '</code></strong>'
                        + (parentName ? '<small>' + escapeHtml(parentName) + '</small>' : '')
                        + '</span>'
                        + '</label>';
                }).join('');

                config.choices.querySelectorAll('[' + config.choiceDataAttribute + ']').forEach(function (checkbox) {
                    checkbox.addEventListener('change', function () {
                        const fieldKey = checkbox.dataset[isPreview
                            ? 'previewSummaryChoiceKey'
                            : (isPrice ? 'priceSummaryChoiceKey' : (isPdf ? 'pdfSummaryChoiceKey' : 'summaryChoiceKey'))];
                        const keys = config.getKeys();
                        if (checkbox.checked) {
                            if (!keys.includes(fieldKey)) config.setKeys(keys.concat(fieldKey));
                        } else {
                            config.setKeys(keys.filter(function (key) { return key !== fieldKey; }));
                        }
                        renderOptionSummaryList(mode);
                    });
                });
            };

            const renderSummaryStepSelect = function () {
                if (!summaryStepSelect) return;

                if (!steps.some(function (step) { return step.key === summaryStepKey; })) {
                    summaryStepKey = steps[0]?.key || '';
                }

                summaryStepSelect.innerHTML = steps.map(function (step, index) {
                    return `<option value="${escapeHtml(step.key)}">Step ${index + 1}: ${escapeHtml(step.name)}</option>`;
                }).join('');
                summaryStepSelect.value = summaryStepKey;
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
                assigned.querySelectorAll('.option-row').forEach(bindOptionDragEvents);
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
                        if (summaryStepKey === removedKey) summaryStepKey = destination.key;
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

            const bindOptionDragEvents = function (row) {
                row.addEventListener('dragstart', function (event) {
                    draggingOption = {
                        groupId: Number(row.dataset.groupId),
                        optionId: Number(row.dataset.optionId),
                    };
                    optionDropPlaceholder = document.createElement('div');
                    optionDropPlaceholder.className = 'option-row-placeholder';
                    event.stopPropagation();
                    row.classList.add('is-dragging');
                });
                row.addEventListener('dragend', function () {
                    draggingOption = null;
                    optionDropPlaceholder?.remove();
                    optionDropPlaceholder = null;
                    row.classList.remove('is-dragging');
                });
                row.addEventListener('dragover', function (event) {
                    if (!draggingOption || draggingOption.groupId !== Number(row.dataset.groupId)) return;
                    event.preventDefault();
                    event.stopPropagation();
                    if (draggingOption.optionId === Number(row.dataset.optionId)) return;

                    const bounds = row.getBoundingClientRect();
                    const insertAfter = event.clientY > bounds.top + (bounds.height / 2);
                    row.parentElement.insertBefore(optionDropPlaceholder, insertAfter ? row.nextSibling : row);
                    requestAnimationFrame(function () { optionDropPlaceholder?.classList.add('is-visible'); });
                });
                row.addEventListener('drop', function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    const targetGroupId = Number(row.dataset.groupId);
                    const targetOptionId = Number(row.dataset.optionId);
                    if (!draggingOption || draggingOption.groupId !== targetGroupId || draggingOption.optionId === targetOptionId) return;

                    captureFormState();
                    const group = groupById(targetGroupId);
                    const optionIds = group.options
                        .map(function (option) { return Number(option.id); })
                        .filter(function (optionId) { return optionId !== draggingOption.optionId; });
                    const nextRow = Array.from(row.parentElement.children)
                        .slice(Array.from(row.parentElement.children).indexOf(optionDropPlaceholder) + 1)
                        .find(function (element) {
                            return element.classList.contains('option-row')
                                && Number(element.dataset.optionId) !== draggingOption.optionId;
                        });
                    const insertAt = nextRow ? optionIds.indexOf(Number(nextRow.dataset.optionId)) : optionIds.length;
                    optionIds.splice(insertAt, 0, draggingOption.optionId);
                    reorderGroupOptions(targetGroupId, optionIds);
                    optionDropPlaceholder?.remove();
                    optionDropPlaceholder = null;
                    render();
                });
            };

            const bindSummaryDragEvents = function (row) {
                row.addEventListener('dragstart', function (event) {
                    draggingSummaryId = Number(row.dataset.summaryGroupId);
                    event.stopPropagation();
                    row.classList.add('is-dragging');
                });
                row.addEventListener('dragend', function () {
                    draggingSummaryId = null;
                    row.classList.remove('is-dragging');
                });
                row.addEventListener('dragover', function (event) {
                    if (draggingSummaryId && draggingSummaryId !== Number(row.dataset.summaryGroupId)) event.preventDefault();
                });
                row.addEventListener('drop', function (event) {
                    event.preventDefault();
                    const targetId = Number(row.dataset.summaryGroupId);
                    if (!draggingSummaryId || draggingSummaryId === targetId) return;
                    const from = summaryGroupIds.indexOf(draggingSummaryId);
                    const targetIndex = summaryGroupIds.indexOf(targetId);
                    const insertAfter = event.clientY > row.getBoundingClientRect().top + (row.getBoundingClientRect().height / 2);
                    summaryGroupIds.splice(from, 1);
                    const insertAt = targetIndex - (from < targetIndex ? 1 : 0) + (insertAfter ? 1 : 0);
                    summaryGroupIds.splice(insertAt, 0, draggingSummaryId);
                    renderSummary();
                });
            };

            const bindPreviewSummaryDragEvents = function (row) {
                row.addEventListener('dragstart', function (event) {
                    draggingPreviewSummaryId = Number(row.dataset.previewSummaryGroupId);
                    event.stopPropagation();
                    row.classList.add('is-dragging');
                });
                row.addEventListener('dragend', function () {
                    draggingPreviewSummaryId = null;
                    row.classList.remove('is-dragging');
                });
                row.addEventListener('dragover', function (event) {
                    if (draggingPreviewSummaryId && draggingPreviewSummaryId !== Number(row.dataset.previewSummaryGroupId)) event.preventDefault();
                });
                row.addEventListener('drop', function (event) {
                    event.preventDefault();
                    const targetId = Number(row.dataset.previewSummaryGroupId);
                    if (!draggingPreviewSummaryId || draggingPreviewSummaryId === targetId) return;
                    const from = previewSummaryGroupIds.indexOf(draggingPreviewSummaryId);
                    const targetIndex = previewSummaryGroupIds.indexOf(targetId);
                    const insertAfter = event.clientY > row.getBoundingClientRect().top + (row.getBoundingClientRect().height / 2);
                    previewSummaryGroupIds.splice(from, 1);
                    const insertAt = targetIndex - (from < targetIndex ? 1 : 0) + (insertAfter ? 1 : 0);
                    previewSummaryGroupIds.splice(insertAt, 0, draggingPreviewSummaryId);
                    renderPreviewSummary();
                });
            };

            const bindOptionSummaryDragEvents = function (row, mode) {
                const isPreview = mode === true || mode === 'preview';
                const isPrice = mode === 'price';
                const isPdf = mode === 'pdf';
                const getDraggingKey = function () {
                    if (isPreview) return draggingPreviewSummaryKey;
                    if (isPrice) return draggingPriceSummaryKey;
                    if (isPdf) return draggingPdfSummaryKey;
                    return draggingSummaryKey;
                };
                const setDraggingKey = function (value) {
                    if (isPreview) draggingPreviewSummaryKey = value;
                    else if (isPrice) draggingPriceSummaryKey = value;
                    else if (isPdf) draggingPdfSummaryKey = value;
                    else draggingSummaryKey = value;
                };

                row.addEventListener('dragstart', function (event) {
                    setDraggingKey(row.dataset.summaryFieldKey);
                    event.stopPropagation();
                    row.classList.add('is-dragging');
                });
                row.addEventListener('dragend', function () {
                    setDraggingKey(null);
                    row.classList.remove('is-dragging');
                });
                row.addEventListener('dragover', function (event) {
                    const draggingKey = getDraggingKey();
                    if (draggingKey && draggingKey !== row.dataset.summaryFieldKey) event.preventDefault();
                });
                row.addEventListener('drop', function (event) {
                    event.preventDefault();
                    const draggingKey = getDraggingKey();
                    const targetKey = row.dataset.summaryFieldKey;
                    if (!draggingKey || draggingKey === targetKey) return;

                    const config = summaryListConfig(mode);
                    const keys = config.getKeys();
                    const from = keys.indexOf(draggingKey);
                    const targetIndex = keys.indexOf(targetKey);
                    if (from < 0 || targetIndex < 0) return;

                    const insertAfter = event.clientY > row.getBoundingClientRect().top + (row.getBoundingClientRect().height / 2);
                    keys.splice(from, 1);
                    const insertAt = targetIndex - (from < targetIndex ? 1 : 0) + (insertAfter ? 1 : 0);
                    keys.splice(insertAt, 0, draggingKey);
                    config.setKeys(keys);
                    renderOptionSummaryList(mode);
                });
            };

            const render = function () {
                renderStepTabs();
                renderAssigned();
                renderAvailable();
                renderSummaryStepSelect();
                renderOptionSummaryChoices(true);
                renderOptionSummaryChoices(false);
                renderOptionSummaryChoices('price');
                renderOptionSummaryChoices('pdf');
                renderOptionSummaryList(true);
                renderOptionSummaryList(false);
                renderOptionSummaryList('price');
                renderOptionSummaryList('pdf');
            };

            document.getElementById('add-step').addEventListener('click', function () {
                captureFormState();
                activeStepKey = newStep();
                render();
            });
            search.addEventListener('input', renderAvailable);
            summaryStepSelect?.addEventListener('change', function () {
                summaryStepKey = summaryStepSelect.value;
            });
            document.getElementById('generate-preview-summary').addEventListener('click', function () {
                captureFormState();
                previewSummaryFieldKeys = availableSummaryFields().map(function (field) { return field.key; });
                renderOptionSummaryChoices(true);
                renderOptionSummaryList(true);
            });
            document.getElementById('generate-summary').addEventListener('click', function () {
                captureFormState();
                summaryFieldKeys = availableSummaryFields().map(function (field) { return field.key; });
                renderOptionSummaryChoices(false);
                renderOptionSummaryList(false);
            });
            document.getElementById('generate-price-summary').addEventListener('click', function () {
                captureFormState();
                priceSummaryFieldKeys = availableSummaryFields().map(function (field) { return field.key; });
                renderOptionSummaryChoices('price');
                renderOptionSummaryList('price');
            });
            document.getElementById('generate-pdf-summary').addEventListener('click', function () {
                captureFormState();
                const customKeys = pdfSummaryFieldKeys.filter(function (fieldKey) {
                    return String(fieldKey).startsWith('custom-');
                });
                pdfSummaryFieldKeys = availableSummaryFields()
                    .map(function (field) { return field.key; })
                    .concat(customKeys);
                renderOptionSummaryChoices('pdf');
                renderOptionSummaryList('pdf');
            });
            document.getElementById('add-pdf-custom-row').addEventListener('click', function () {
                captureFormState();
                const customKey = 'custom-new-' + Date.now() + '-' + Math.random().toString(36).slice(2, 10);
                pdfSummaryCustomRows.push({ id: null, key: customKey, label: '', content: '', sort_order: 0 });
                pdfSummaryFieldKeys = pdfSummaryFieldKeys.concat(customKey);
                renderOptionSummaryList('pdf');
                window.requestAnimationFrame(function () {
                    pdfSummaryGroups.querySelector('[data-pdf-custom-label-key="' + customKey + '"]')?.focus();
                });
            });
            render();
        });
    </script>
@endpush
