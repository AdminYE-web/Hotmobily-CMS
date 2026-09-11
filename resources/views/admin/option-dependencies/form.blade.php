@extends('admin.layouts.app')

@section('title', $isEditing ? 'Edit Option Dependency' : 'Add Option Dependency')

@php
    $selectedTargetType = old('target_type', $dependency->target_type ?? 'option');
    $selectedTargetId = old(
        'target_id',
        $selectedTargetType === 'group'
            ? $dependency->target_option_group_id
            : $dependency->target_product_option_id
    );
@endphp

@section('content')
    <div class="container-fluid option-dependency-form">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">{{ $isEditing ? 'Edit Option Dependency' : 'Add Option Dependency' }}</h1>
                <p class="text-muted mb-0">Apply an action when the customer selects a Trigger Option.</p>
            </div>
            <a href="{{ route('admin.option-dependencies.index') }}" class="btn btn-outline-secondary">&larr; Back</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <div>Unable to save this Option Dependency.</div>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ $isEditing ? route('admin.option-dependencies.update', $dependency) : route('admin.option-dependencies.store') }}">
            @csrf
            @if ($isEditing)
                @method('PUT')
            @endif

            <section class="dependency-section">
                <h2>Dependency Setting</h2>

                <div class="form-group mb-4">
                    <label for="trigger_product_option_id">Trigger Option <span class="text-danger">*</span></label>
                    <select id="trigger_product_option_id" name="trigger_product_option_id" class="form-control @error('trigger_product_option_id') is-invalid @enderror" required>
                        <option value="">-- Select Trigger Option --</option>
                        @foreach ($productOptions as $option)
                            <option value="{{ $option->id }}" @selected((string) old('trigger_product_option_id', $dependency->trigger_product_option_id) === (string) $option->id)>
                                {{ $option->optionGroup?->group_name }} / {{ $option->option_name }} ({{ $option->option_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('trigger_product_option_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="target_type">Target Type <span class="text-danger">*</span></label>
                        <select id="target_type" name="target_type" class="form-control @error('target_type') is-invalid @enderror" required>
                            <option value="option" @selected($selectedTargetType === 'option')>Option - Show only option</option>
                            <option value="group" @selected($selectedTargetType === 'group')>Group - Apply to entire Option Group</option>
                        </select>
                        @error('target_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="action_type">Action Type <span class="text-danger">*</span></label>
                        <select id="action_type" name="action_type" class="form-control @error('action_type') is-invalid @enderror" required>
                            <option value="show" @selected(old('action_type', $dependency->action_type) === 'show')>Show target</option>
                            <option value="hide" @selected(old('action_type', $dependency->action_type) === 'hide')>Hide target</option>
                            <option value="lock" @selected(old('action_type', $dependency->action_type) === 'lock')>Lock target</option>
                            <option value="disable" @selected(old('action_type', $dependency->action_type) === 'disable')>Disable target</option>
                        </select>
                        @error('action_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label id="target-label" for="target_id">Target Option <span class="text-danger">*</span></label>
                    <select id="target_id" name="target_id" class="form-control @error('target_id') is-invalid @enderror" required></select>
                    @error('target_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </section>

            <section class="dependency-section">
                <h2>Status</h2>
                <div class="status-box">
                    <div class="custom-control custom-checkbox">
                        <input id="is_active" name="is_active" type="checkbox" value="1" class="custom-control-input" @checked(old('is_active', $dependency->is_active))>
                        <label class="custom-control-label" for="is_active">Active</label>
                    </div>
                </div>
            </section>

            <button type="submit" class="btn btn-primary px-4">{{ $isEditing ? 'Update Option Dependency' : 'Add Option Dependency' }}</button>
        </form>
    </div>
@endsection

@push('styles')
    <style>
        .option-dependency-form { max-width: 1350px; }
        .dependency-section { border-top: 1px solid #dce1e9; padding: 1.35rem 0 1.55rem; }
        .dependency-section h2 { font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; }
        .status-box { max-width: 660px; padding: .85rem .75rem; border: 1px solid #dce1e9; border-radius: .55rem; background: #f7f9fc; }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const targetType = document.getElementById('target_type');
            const target = document.getElementById('target_id');
            const targetLabel = document.getElementById('target-label');
            const selectedTargetId = String(@json($selectedTargetId ?? ''));
            const optionTargets = @json($productOptions->map(static fn ($option): array => [
                'id' => $option->id,
                'label' => ($option->optionGroup?->group_name ?? '-') . ' / ' . $option->option_name . ' (' . $option->option_code . ')',
            ])->values());
            const groupTargets = @json($optionGroups->map(static fn ($group): array => [
                'id' => $group->id,
                'label' => $group->group_name . ' (' . $group->group_code . ')',
            ])->values());

            const escapeHtml = function (value) {
                const element = document.createElement('div');
                element.textContent = String(value ?? '');
                return element.innerHTML;
            };

            const renderTargets = function (keepSelection) {
                const isGroup = targetType.value === 'group';
                const items = isGroup ? groupTargets : optionTargets;
                const value = keepSelection ? selectedTargetId : '';
                targetLabel.innerHTML = isGroup
                    ? 'Target Group <span class="text-danger">*</span>'
                    : 'Target Option <span class="text-danger">*</span>';
                target.innerHTML = `<option value="">-- Select Target ${isGroup ? 'Group' : 'Option'} --</option>`
                    + items.map(function (item) {
                        return `<option value="${item.id}" ${String(item.id) === value ? 'selected' : ''}>${escapeHtml(item.label)}</option>`;
                    }).join('');
            };

            targetType.addEventListener('change', function () { renderTargets(false); });
            renderTargets(true);
        });
    </script>
@endpush
