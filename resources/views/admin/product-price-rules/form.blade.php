@extends('admin.layouts.app')

@section('title', $isEditing ? 'Edit Product Price Rule' : 'Add Product Price Rule')

@php
    $oldTiers = old('tiers');
    $initialTiers = $oldTiers !== null
        ? collect($oldTiers)->values()->all()
        : $rule->tiers->map(static fn ($tier): array => [
            'quantity' => $tier->quantity,
            'unit_price' => $tier->unit_price,
            'unit_price_with_tax' => $tier->unit_price_with_tax,
        ])->values()->all();

    if ($initialTiers === []) {
        $initialTiers = [[
            'quantity' => '',
            'unit_price' => '',
            'unit_price_with_tax' => '',
        ]];
    }

    $initialProductId = (int) old('product_id', $rule->product_id);
    $initialConditionIds = collect(old('condition_product_option_ids', $selectedConditionIds))
        ->map(static fn ($id): int => (int) $id)
        ->values()
        ->all();
    $initialDisplayTierIndex = (int) old('display_tier_index', $displayTierIndex);
    $initialTaxRate = old('tax_rate', $rule->tax_rate ?? 10);
@endphp

@section('content')
    <div class="container-fluid product-price-rule-form">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">{{ $isEditing ? 'Edit Product Price Rule' : 'Add Product Price Rule' }}</h1>
                <p class="text-muted mb-0">Set a product unit price when all selected Options are chosen.</p>
            </div>

            <a href="{{ route('admin.product-price-rules.index') }}" class="btn btn-outline-secondary">&larr; Back</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <div>Unable to save this Product Price Rule.</div>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ $isEditing ? route('admin.product-price-rules.update', $rule) : route('admin.product-price-rules.store') }}">
            @csrf
            @if ($isEditing)
                @method('PUT')
            @endif

            <section class="rule-section">
                <h2>Rule Information</h2>
                <div class="form-row">
                    <div class="form-group col-md-6">
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

                    <div class="form-group col-md-6">
                        <label for="rule_name">Rule Name <span class="text-danger">*</span></label>
                        <input id="rule_name" name="rule_name" type="text" value="{{ old('rule_name', $rule->rule_name) }}" class="form-control @error('rule_name') is-invalid @enderror" placeholder="For example, Horizontal + Green" maxlength="255" required>
                        @error('rule_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </section>

            <section class="rule-section">
                <h2>Required Options</h2>
                <p class="text-muted">Select all the options that the customer must choose in order to use this price rate.</p>
                <div id="condition-options" class="condition-panel"></div>
                <div id="no-product-message" class="alert alert-warning mt-3 mb-0">Select a Product to load its assigned Product Options.</div>
                @error('condition_product_option_ids')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
            </section>

            <section class="rule-section">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="mb-1">Price Tiers</h2>
                        <p class="text-muted small mb-0">Unit price with tax is calculated automatically and remains editable.</p>
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
                                <th>Unit Price</th>
                                <th>Unit Price With Tax</th>
                                <th>Display</th>
                                <th style="width: 100px;"></th>
                            </tr>
                        </thead>
                        <tbody id="tier-rows"></tbody>
                    </table>
                </div>
                @error('display_tier_index')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                <button id="add-tier" type="button" class="btn btn-outline-secondary mt-3">+ Add Tier</button>
            </section>

            <div class="d-flex justify-content-end mb-5">
                <button type="submit" class="btn btn-primary px-4">{{ $isEditing ? 'Update Product Price Rule' : 'Add Product Price Rule' }}</button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <style>
        .product-price-rule-form { max-width: 1280px; }
        .rule-section { border-top: 1px solid #dce1e9; padding: 1.35rem 0 1.55rem; }
        .rule-section h2 { font-size: 1.15rem; font-weight: 700; margin-bottom: 1rem; }
        .condition-panel { border: 1px solid #dce1e9; border-radius: .55rem; padding: 1rem; min-height: 180px; }
        .condition-group { margin-bottom: 1.2rem; }
        .condition-group:last-child { margin-bottom: 0; }
        .condition-group-title { font-weight: 700; border-bottom: 1px solid #d4dae3; padding-bottom: .55rem; margin-bottom: .5rem; }
        .condition-option { display: block; color: #174a9c; margin: .4rem 0; }
        .condition-option input { margin-right: .45rem; }
        .tier-table-wrap { border: 1px solid #cfd8e5; border-radius: .55rem; overflow: hidden; max-width: 1060px; }
        .tier-table thead { background: #f5f8fb; }
        .tier-table th { color: #193b63; font-size: .88rem; border-bottom: 1px solid #cfd8e5; }
        .tier-table td { vertical-align: middle; border-top: 1px solid #e8edf3; }
        .tier-table .input-group-text { background: #f5f8fb; }
        .remove-tier { color: #c82333; border-color: #f0aab2; background: #fff; }
        .remove-tier:hover { color: #fff; background: #c82333; }
        @media (max-width: 767.98px) {
            .tier-table-wrap { overflow-x: auto; }
            .tier-table { min-width: 850px; }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const catalog = @json($productCatalog);
            const productSelect = document.getElementById('product_id');
            const conditionOptions = document.getElementById('condition-options');
            const noProductMessage = document.getElementById('no-product-message');
            const tierRows = document.getElementById('tier-rows');
            const taxRate = document.getElementById('tax_rate');
            let conditionIds = @json($initialConditionIds).map(Number);
            let displayTierIndex = Number(@json($initialDisplayTierIndex));
            let tiers = @json($initialTiers);

            const escapeHtml = function (value) {
                const element = document.createElement('div');
                element.textContent = String(value ?? '');
                return element.innerHTML;
            };

            const currentProduct = function () {
                return catalog.find(function (product) { return Number(product.id) === Number(productSelect.value); });
            };

            const renderConditions = function () {
                const product = currentProduct();
                if (!product) {
                    conditionOptions.innerHTML = '';
                    noProductMessage.classList.remove('d-none');
                    return;
                }

                noProductMessage.classList.add('d-none');
                conditionOptions.innerHTML = product.groups.map(function (group) {
                    if (!group.options.length) return '';
                    const options = group.options.map(function (option) {
                        const checked = conditionIds.includes(Number(option.id));
                        return `<label class="condition-option">
                            <input type="checkbox" name="condition_product_option_ids[]" value="${option.id}" ${checked ? 'checked' : ''}>
                            ${escapeHtml(option.option_name)} <code>${escapeHtml(option.option_code)}</code>
                        </label>`;
                    }).join('');
                    return `<div class="condition-group">
                        <div class="condition-group-title">${escapeHtml(group.group_name)} <code>${escapeHtml(group.group_code)}</code></div>
                        ${options}
                    </div>`;
                }).join('') || '<div class="text-muted small">This Product has no active Product Options assigned.</div>';

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
                        unit_price: row.querySelector('[data-field="unit_price"]').value,
                        unit_price_with_tax: row.querySelector('[data-field="unit_price_with_tax"]').value,
                    };
                });
            };

            const recalculateTax = function (row, force) {
                const price = parseFloat(row.querySelector('[data-field="unit_price"]').value);
                const withTax = row.querySelector('[data-field="unit_price_with_tax"]');
                if (force || withTax.dataset.manual !== '1') {
                    const rate = parseFloat(taxRate.value) || 0;
                    withTax.value = Number.isFinite(price) ? (price * (1 + rate / 100)).toFixed(2) : '';
                }
            };

            const renderTiers = function () {
                if (displayTierIndex >= tiers.length) displayTierIndex = 0;
                tierRows.innerHTML = tiers.map(function (tier, index) {
                    return `<tr>
                        <td><input name="tiers[${index}][quantity]" data-field="quantity" type="number" min="1" step="1" value="${escapeHtml(tier.quantity)}" class="form-control" required></td>
                        <td><div class="input-group"><div class="input-group-prepend"><span class="input-group-text">&#165;</span></div><input name="tiers[${index}][unit_price]" data-field="unit_price" type="number" min="0" step="0.01" value="${escapeHtml(tier.unit_price)}" class="form-control" required></div></td>
                        <td><div class="input-group"><div class="input-group-prepend"><span class="input-group-text">&#165;</span></div><input name="tiers[${index}][unit_price_with_tax]" data-field="unit_price_with_tax" type="number" min="0" step="0.01" value="${escapeHtml(tier.unit_price_with_tax)}" class="form-control" required></div></td>
                        <td class="text-center"><input type="radio" name="display_tier_index" value="${index}" ${index === displayTierIndex ? 'checked' : ''} aria-label="Display this tier"></td>
                        <td><button type="button" class="btn btn-sm remove-tier">Remove</button></td>
                    </tr>`;
                }).join('');

                tierRows.querySelectorAll('tr').forEach(function (row) {
                    const price = row.querySelector('[data-field="unit_price"]');
                    const withTax = row.querySelector('[data-field="unit_price_with_tax"]');
                    price.addEventListener('input', function () { recalculateTax(row, false); });
                    withTax.addEventListener('input', function () { withTax.dataset.manual = '1'; });
                    row.querySelector('input[name="display_tier_index"]').addEventListener('change', function (event) {
                        displayTierIndex = Number(event.target.value);
                    });
                    row.querySelector('.remove-tier').addEventListener('click', function () {
                        captureTiers();
                        const removeIndex = Array.from(tierRows.children).indexOf(row);
                        if (tiers.length > 1) {
                            tiers.splice(removeIndex, 1);
                            displayTierIndex = displayTierIndex === removeIndex
                                ? 0
                                : (displayTierIndex > removeIndex ? displayTierIndex - 1 : displayTierIndex);
                        }
                        renderTiers();
                    });
                    if (!withTax.value && price.value) recalculateTax(row, true);
                });
            };

            productSelect.addEventListener('change', function () {
                conditionIds = [];
                renderConditions();
            });
            taxRate.addEventListener('input', function () {
                tierRows.querySelectorAll('tr').forEach(function (row) { recalculateTax(row, false); });
            });
            document.getElementById('add-tier').addEventListener('click', function () {
                captureTiers();
                tiers.push({ quantity: '', unit_price: '', unit_price_with_tax: '' });
                renderTiers();
            });

            renderConditions();
            renderTiers();
        });
    </script>
@endpush
