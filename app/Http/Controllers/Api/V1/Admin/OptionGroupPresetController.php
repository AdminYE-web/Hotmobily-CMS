<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\OptionGroup;
use App\Models\OptionGroupPreset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class OptionGroupPresetController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => OptionGroupPreset::orderBy('name')->get(['id', 'option_group_id', 'name', 'updated_at'])]);
    }

    public function show(OptionGroupPreset $optionGroupPreset): JsonResponse
    {
        return response()->json(['data' => $optionGroupPreset]);
    }

    public function store(Request $request): JsonResponse
    {
        return response()->json(['data' => OptionGroupPreset::create($this->validated($request))], 201);
    }

    public function update(Request $request, OptionGroupPreset $optionGroupPreset): JsonResponse
    {
        $optionGroupPreset->update($this->validated($request, $optionGroupPreset));
        return response()->json(['data' => $optionGroupPreset->fresh()]);
    }

    public function destroy(OptionGroupPreset $optionGroupPreset): JsonResponse
    {
        $optionGroupPreset->delete();
        return response()->json(['success' => true]);
    }

    private function validated(Request $request, ?OptionGroupPreset $preset = null): array
    {
        $groupId = $preset?->option_group_id ?? $request->input('option_group_id');
        $data = $request->validate([
            'option_group_id' => ['required', 'integer', 'exists:option_groups,id', ...($preset ? [Rule::in([$preset->option_group_id])] : [])],
            'name' => ['required', 'string', 'max:150', Rule::unique('option_group_presets')->where('option_group_id', $groupId)->ignore($preset?->id)],
            'content' => ['required', 'array'],
            'content.quantity_min' => ['nullable', 'integer', 'min:1', 'max:2147483647'],
            'content.quantity_max' => ['nullable', 'integer', 'min:1', 'max:2147483647'],
            'content.options' => ['present', 'array', 'max:500'],
            'content.options.*.id' => ['required', 'integer', 'distinct', Rule::exists('product_options', 'id')->where('option_group_id', $groupId)],
            'content.options.*.is_selected' => ['required', 'boolean'],
            'content.options.*.is_default' => ['required', 'boolean'],
            'content.options.*.is_active' => ['required', 'boolean'],
            'content.options.*.quantity_rule' => ['required', Rule::in(['no_limit', 'minimum_only', 'maximum_only', 'exact_quantity_only', 'min_max_range'])],
            'content.options.*.min_qty' => ['nullable', 'integer', 'min:0', 'max:2147483647'],
            'content.options.*.max_qty' => ['nullable', 'integer', 'min:0', 'max:2147483647'],
            'content.options.*.exact_qty' => ['nullable', 'integer', 'min:0', 'max:2147483647'],
        ]);
        $content = $data['content'];
        $group = OptionGroup::findOrFail($data['option_group_id']);
        $limits = ['quantity_min' => $group->display_type === 'quantity_input' ? ($content['quantity_min'] ?? null) : null, 'quantity_max' => $group->display_type === 'quantity_input' ? ($content['quantity_max'] ?? null) : null];
        if (isset($limits['quantity_min'], $limits['quantity_max']) && $limits['quantity_min'] > $limits['quantity_max']) {
            throw ValidationException::withMessages(['content.quantity_max' => 'Maximum quantity must be greater than or equal to minimum quantity.']);
        }
        $options = [];
        foreach ($content['options'] as $index => $option) {
            $item = ['id' => (int) $option['id'], 'quantity_rule' => $option['quantity_rule']];
            foreach (['is_selected', 'is_default', 'is_active'] as $key) $item[$key] = (bool) $option[$key];
            foreach (['min_qty', 'max_qty', 'exact_qty'] as $key) $item[$key] = isset($option[$key]) ? (int) $option[$key] : null;
            foreach (['minimum_only' => ['min_qty'], 'maximum_only' => ['max_qty'], 'exact_quantity_only' => ['exact_qty'], 'min_max_range' => ['min_qty', 'max_qty']][$item['quantity_rule']] ?? [] as $key) {
                if ($item[$key] === null) throw ValidationException::withMessages(["content.options.$index.$key" => 'Enter the quantity required by this rule.']);
            }
            if ($item['quantity_rule'] === 'min_max_range' && $item['min_qty'] > $item['max_qty']) throw ValidationException::withMessages(["content.options.$index.max_qty" => 'Maximum quantity must be greater than or equal to minimum quantity.']);
            $options[] = $item;
        }
        return ['option_group_id' => (int) $groupId, 'name' => trim($data['name']), 'content_json' => [...$limits, 'options' => $options]];
    }
}
