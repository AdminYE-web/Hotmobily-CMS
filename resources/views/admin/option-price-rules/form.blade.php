@extends('admin.layouts.app')

@section('title', $isEditing ? 'Edit Option Price Rule' : 'Add Option Price Rule')

@php
    $oldTiers = old('tiers');
    $initialTiers = $oldTiers !== null
        ? collect($oldTiers)->values()->all()
        : $rule->tiers->map(static fn ($tier): array => [
            'quantity' => $tier->quantity,
            'additional_price' => $tier->additional_price,
            'additional_price_with_tax' => $tier->additional_price_with_tax,
        ])->values()->all();

    if ($initialTiers === []) {
        $initialTiers = [[
            'quantity' => '',
            'additional_price' => '',
            'additional_price_with_tax' => '',
        ]];
    }

    $initialProductId = (int) old('product_id', $rule->product_id);
    $initialTargetOptionId = (int) old('target_product_option_id', $rule->target_product_option_id);
    $initialConditionIds = collect(old('condition_product_option_ids', $selectedConditionIds))
        ->map(static fn ($id): int => (int) $id)
        ->values()
        ->all();
    $initialPriceType = old('price_type', $rule->price_type ?? 'per_order');
    $initialTaxRate = old('tax_rate', $rule->tax_rate ?? 10);
@endphp

@section('content')
    <div class="container-fluid option-price-rule-form">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">{{ $isEditing ? 'Edit Option Price Rule' : 'Add Option Price Rule' }}</h1>
                <p class="text-muted mb-0">Replace an option price when the selected conditions are met.</p>
            </div>

            <a href="{{ route('admin.option-price-rules.index') }}" class="btn btn-outline-secondary">&larr; Back</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <div>Unable to save this Option Price Rule.</div>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ $isEditing ? route('admin.option-price-rules.update', $rule) : route('admin.option-price-rules.store') }}">
            @csrf
            @if ($isEditing)
                @method('PUT')
            @endif

            <section class="rule-section">
                <h2>Rule Information</h2>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="product_id">Product <span class="text-danger">*</span></label>
                        <select id="product_id" name="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                            <option value="">-- Select Product --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" @selected($initialProductId === (int) $product->id)>
                                    {{ $product->name }} | {{ $product->slug }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="rule_name">Rule Name <span class="text-danger">*</span></label>
                        <input id="rule_name" name="rule_name" type="text" value="{{ old('rule_name', $rule->rule_name) }}" class="form-control @error('rule_name') is-invalid @enderror" placeholder="For example, Black rope + 200m" maxlength="255" required>
                        @error('rule_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="price_type">Price Type <span class="text-danger">*</span></label>
                        <select id="price_type" name="price_type" class="form-control @error('price_type') is-invalid @enderror" required>
                            <option value="per_order" @selected($initialPriceType === 'per_order')>Per order</option>
                            <option value="per_piece" @selected($initialPriceType === 'per_piece')>Per piece</option>
                        </select>
                        <small class="form-text text-muted">Apply each tier once per order, or multiply it by quantity.</small>
                        @error('price_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </section>

            <section class="rule-section">
                <h2>Option Rule Conditions</h2>
                <div class="form-row condition-headings">
                    <div class="col-md-6"><p class="text-muted mb-2">Select the option whose price will be replaced by this rule.</p></div>
                    <div class="col-md-6"><p class="text-muted mb-2">Select all options the customer must choose before this price applies.</p></div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div id="target-options" class="condition-panel"></div>
                    </div>
                    <div class="col-md-6">
                        <div id="condition-options" class="condition-panel"></div>
                    </div>
                </div>
                <div id="no-product-message" class="alert alert-warning mt-3 mb-0">Select a Product to load its Main Price Group and Product Options.</div>
                @error('target_product_option_id')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                @error('condition_product_option_ids')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
            </section>

            <section class="rule-section">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="mb-1">Additional Price Tiers</h2>
                        <p class="text-muted small mb-0">Tax is automatically calculated at the rate below. The tax-inclusive price remains editable.</p>
                    </div>
                    <div class="form-inline">
                        <label for="tax_rate" class="mr-2 mb-0">Auto Tax</label>
                        <div class="input-group" style="width: 125px;">
                            <input id="tax_rate" name="tax_rate" type="number" step="0.01" min="0" max="100" value="{{ $initialTaxRate }}" class="form-control @error('tax_rate') is-invalid @enderror" required>
                            <div class="input-group-append"><span class="input-group-text">%</span></div>
                        </div>
                    </div>
                </div>

                <div class="tier-table-wrap">
                    <table class="table tier-table mb-0">
                        <thead>
                            <tr>
                                <th>Quantity</th>
                                <th>Additional Price</th>
                                <th>Additional Price With Tax</th>
                                <th style="width: 100px;"></th>
                            </tr>
                        </thead>
                        <tbody id="tier-rows"></tbody>
                    </table>
                </div>
                <button id="add-tier" type="button" class="btn btn-outline-secondary mt-3">+ Add Tier</button>
            </section>

            <div class="d-flex justify-content-end mb-5">
                <button type="submit" class="btn btn-primary px-4">{{ $isEditing ? 'Update Option Price Rule' : 'Add Option Price Rule' }}</button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <style>
        .option-price-rule-form { max-width: 1500px; }
        .rule-section { border-top: 1px solid #dce1e9; padding: 1.35rem 0 1.55rem; }
        .rule-section h2 { font-size: 1.15rem; font-weight: 700; margin-bottom: 1rem; }
        .condition-panel { border: 1px solid #dce1e9; border-radius: .55rem; padding: 1rem; min-height: 180px; }
        .condition-group { margin-bottom: 1rem; }
        .condition-group:last-child { margin-bottom: 0; }
        .condition-group-title { font-weight: 700; border-bottom: 1px solid #d4dae3; padding-bottom: .55rem; margin-bottom: .5rem; }
        .condition-option { display: block; color: #174a9c; margin: .4rem 0; }
        .condition-option input { margin-right: .45rem; }
        .main-price-label { color: #856404; font-size: .75rem; margin-left: .35rem; }
        .tier-table-wrap { border: 1px solid #cfd8e5; border-radius: .55rem; overflow: hidden; max-width: 970px; }
        .tier-table thead { background: #f5f8fb; }
        .tier-table th { color: #193b63; font-size: .88rem; border-bottom: 1px solid #cfd8e5; }
        .tier-table td { vertical-align: middle; border-top: 1px solid #e8edf3; }
        .tier-table .input-group-text { background: #f5f8fb; }
        .remove-tier { color: #c82333; border-color: #f0aab2; background: #fff; }
        .remove-tier:hover { color: #fff; background: #c82333; }
        @media (max-width: 767.98px) {
            .condition-headings { display: none; }
            .tier-table-wrap { overflow-x: auto; }
            .tier-table { min-width: 760px; }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const catalog = @json($productCatalog);
            const productSelect = document.getElementById('product_id');
            const targetOptions = document.getElementById('target-options');
            const conditionOptions = document.getElementById('condition-options');
            const noProductMessage = document.getElementById('no-product-message');
            const tierRows = document.getElementById('tier-rows');
            const taxRate = document.getElementById('tax_rate');
            let targetId = Number(@json($initialTargetOptionId));
            let conditionIds = @json($initialConditionIds).map(Number);
            let tiers = @json($initialTiers);

            const escapeHtml = function (value) {
                const element = document.createElement('div');
                element.textContent = String(value ?? '');
                return element.innerHTML;
            };

            const currentProduct = function () {
                return catalog.find(function (product) { return Number(product.id) === Number(productSelect.value); });
            };

            const groupMarkup = function (group, type) {
                if (!group.options.length) return '';

                const options = group.options.map(function (option) {
                    const checked = type === 'target'
                        ? Number(targetId) === Number(option.id)
                        : conditionIds.includes(Number(option.id));
                    const inputType = type === 'target' ? 'radio' : 'checkbox';
                    const inputName = type === 'target' ? 'target_product_option_id' : 'condition_product_option_ids[]';

                    return `<label class="condition-option">
                        <input type="${inputType}" name="${inputName}" value="${option.id}" ${checked ? 'checked' : ''}>
                        ${escapeHtml(option.option_name)} <code>${escapeHtml(option.option_code)}</code>
                    </label>`;
                }).join('');

                return `<div class="condition-group">
                    <div class="condition-group-title">${escapeHtml(group.group_name)} <code>${escapeHtml(group.group_code)}</code>${group.is_main_price_group ? '<span class="main-price-label">Main Price Group</span>' : ''}</div>
                    ${options}
                </div>`;
            };

            const renderConditions = function () {
                const product = currentProduct();
                if (!product) {
                    targetOptions.innerHTML = '';
                    conditionOptions.innerHTML = '';
                    noProductMessage.classList.remove('d-none');
                    return;
                }

                noProductMessage.classList.add('d-none');
                const mainGroups = product.groups.filter(function (group) { return group.is_main_price_group; });
                targetOptions.innerHTML = mainGroups.map(function (group) { return groupMarkup(group, 'target'); }).join('')
                    || '<div class="text-danger small">This Product has no active Main Price Group assigned.</div>';
                conditionOptions.innerHTML = product.groups.map(function (group) { return groupMarkup(group, 'condition'); }).join('')
                    || '<div class="text-muted small">This Product has no active Option Group assigned.</div>';

                targetOptions.querySelectorAll('input[type="radio"]').forEach(function (input) {
                    input.addEventListener('change', function () { targetId = Number(input.value); });
                });
                conditionOptions.querySelectorAll('input[type="checkbox"]').forEach(function (input) {
                    input.addEventListener('change', function () {
                        const id = Number(input.value);
                        conditionIds = input.checked
                            ? [...new Set(conditionIds.concat(id))]
                            : conditionIds.filter(function (conditionId) { return conditionId !== id; });
                    });
                });
            };

            const captureTiers = function () {
                tiers = Array.from(tierRows.querySelectorAll('tr')).map(function (row) {
                    return {
                        quantity: row.querySelector('[data-field="quantity"]').value,
                        additional_price: row.querySelector('[data-field="additional_price"]').value,
                        additional_price_with_tax: row.querySelector('[data-field="additional_price_with_tax"]').value,
                    };
                });
            };

            const recalculateTax = function (row, force) {
                const price = parseFloat(row.querySelector('[data-field="additional_price"]').value);
                const withTax = row.querySelector('[data-field="additional_price_with_tax"]');
                if (force || withTax.dataset.manual !== '1') {
                    const rate = parseFloat(taxRate.value) || 0;
                    withTax.value = Number.isFinite(price) ? (price * (1 + rate / 100)).toFixed(2) : '';
                }
            };

            const renderTiers = function () {
                tierRows.innerHTML = tiers.map(function (tier, index) {
                    return `<tr>
                        <td><input name="tiers[${index}][quantity]" data-field="quantity" type="number" min="1" step="1" value="${escapeHtml(tier.quantity)}" class="form-control" required></td>
                        <td><div class="input-group"><div class="input-group-prepend"><span class="input-group-text">¥</span></div><input name="tiers[${index}][additional_price]" data-field="additional_price" type="number" min="0" step="0.01" value="${escapeHtml(tier.additional_price)}" class="form-control" required></div></td>
                        <td><div class="input-group"><div class="input-group-prepend"><span class="input-group-text">¥</span></div><input name="tiers[${index}][additional_price_with_tax]" data-field="additional_price_with_tax" type="number" min="0" step="0.01" value="${escapeHtml(tier.additional_price_with_tax)}" class="form-control" required></div></td>
                        <td><button type="button" class="btn btn-sm remove-tier">Remove</button></td>
                    </tr>`;
                }).join('');

                tierRows.querySelectorAll('tr').forEach(function (row) {
                    const price = row.querySelector('[data-field="additional_price"]');
                    const withTax = row.querySelector('[data-field="additional_price_with_tax"]');
                    price.addEventListener('input', function () { recalculateTax(row, false); });
                    withTax.addEventListener('input', function () { withTax.dataset.manual = '1'; });
                    row.querySelector('.remove-tier').addEventListener('click', function () {
                        captureTiers();
                        if (tiers.length > 1) tiers.splice(Array.from(tierRows.children).indexOf(row), 1);
                        renderTiers();
                    });
                    if (!withTax.value && price.value) recalculateTax(row, true);
                });
            };

            productSelect.addEventListener('change', function () {
                targetId = 0;
                conditionIds = [];
                renderConditions();
            });
            taxRate.addEventListener('input', function () {
                tierRows.querySelectorAll('tr').forEach(function (row) { recalculateTax(row, false); });
            });
            document.getElementById('add-tier').addEventListener('click', function () {
                captureTiers();
                tiers.push({ quantity: '', additional_price: '', additional_price_with_tax: '' });
                renderTiers();
            });

            renderConditions();
            renderTiers();
        });
    </script>
@endpush
