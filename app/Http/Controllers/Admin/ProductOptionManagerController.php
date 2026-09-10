<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OptionGroup;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionGroup;
use App\Models\ProductOptionGroupItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductOptionManagerController extends Controller
{
    public function edit(Product $product): View
    {
        $assignments = ProductOptionGroup::query()
            ->where('product_id', $product->id)
            ->with('items')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $selectedIds = $assignments
            ->pluck('option_group_id')
            ->map(static fn ($id): int => (int) $id)
            ->all();

        $selectedOptionSettings = $assignments
            ->mapWithKeys(static fn (ProductOptionGroup $assignment): array => [
                $assignment->option_group_id => [
                    'configured' => $assignment->has_option_configuration,
                    'items' => $assignment->items
                        ->mapWithKeys(static fn (ProductOptionGroupItem $item): array => [
                            $item->product_option_id => [
                                'is_default' => $item->is_default,
                                'is_active' => $item->is_active,
                                'quantity_rule' => $item->quantity_rule,
                                'min_qty' => $item->min_qty,
                                'max_qty' => $item->max_qty,
                                'exact_qty' => $item->exact_qty,
                            ],
                        ])
                        ->all(),
                ],
            ])
            ->all();

        $optionGroups = OptionGroup::query()
            ->with([
                'productOptions' => fn ($query) => $query
                    ->where('is_active', true)
                    ->orderBy('option_name'),
            ])
            ->where(function ($query) use ($selectedIds): void {
                $query->where('is_active', true);

                if ($selectedIds !== []) {
                    $query->orWhereIn('id', $selectedIds);
                }
            })
            ->orderBy('group_name')
            ->get()
            ->map(static function (OptionGroup $group) use ($selectedOptionSettings): array {
                $settings = $selectedOptionSettings[$group->id] ?? null;
                $storedOptions = $settings['items'] ?? [];
                $isConfigured = $settings['configured'] ?? false;

                return [
                    'id' => $group->id,
                    'group_code' => $group->group_code,
                    'group_name' => $group->group_name,
                    'display_type' => $group->display_type,
                    'help_text' => $group->help_text,
                    'is_main_price_group' => $group->is_main_price_group,
                    'is_required' => $group->is_required,
                    'is_active' => $group->is_active,
                    'options' => $group->productOptions->map(static function (ProductOption $option) use ($isConfigured, $storedOptions): array {
                        $item = $storedOptions[$option->id] ?? null;

                        return [
                            'id' => $option->id,
                            'option_code' => $option->option_code,
                            'option_name' => $option->option_name,
                            'color_code' => $option->color_code,
                            'option_detail' => $option->option_detail,
                            'image_count' => count($option->option_images ?? []),
                            'is_selected' => !$isConfigured || $item !== null,
                            'is_default' => $item['is_default'] ?? false,
                            'is_active' => $item['is_active'] ?? true,
                            'quantity_rule' => $item['quantity_rule'] ?? 'no_limit',
                            'min_qty' => $item['min_qty'] ?? null,
                            'max_qty' => $item['max_qty'] ?? null,
                            'exact_qty' => $item['exact_qty'] ?? null,
                        ];
                    })->values()->all(),
                ];
            })
            ->values();

        return view('admin.products.options', compact('product', 'optionGroups', 'selectedIds'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'option_group_ids' => ['nullable', 'array'],
            'option_group_ids.*' => ['integer', 'distinct', 'exists:option_groups,id'],
            'option_ids' => ['nullable', 'array'],
            'option_ids.*' => ['nullable', 'array'],
            'option_ids.*.*' => ['integer', 'distinct', 'exists:product_options,id'],
            'option_config' => ['nullable', 'array'],
            'option_config.*.is_default' => ['nullable', 'boolean'],
            'option_config.*.is_active' => ['nullable', 'boolean'],
            'option_config.*.quantity_rule' => ['nullable', 'in:no_limit,minimum_only,maximum_only,exact_quantity_only,min_max_range'],
            'option_config.*.min_qty' => ['nullable', 'integer', 'min:0'],
            'option_config.*.max_qty' => ['nullable', 'integer', 'min:0'],
            'option_config.*.exact_qty' => ['nullable', 'integer', 'min:0'],
        ]);

        $groupIds = collect($data['option_group_ids'] ?? [])
            ->map(static fn ($id): int => (int) $id)
            ->values()
            ->all();

        DB::transaction(function () use ($data, $product, $groupIds): void {
            $assignments = ProductOptionGroup::query()
                ->where('product_id', $product->id);

            $removedAssignmentIds = (clone $assignments)
                ->when(
                    $groupIds !== [],
                    fn ($query) => $query->whereNotIn('option_group_id', $groupIds)
                )
                ->pluck('id');

            if ($removedAssignmentIds->isNotEmpty()) {
                ProductOptionGroupItem::query()
                    ->whereIn('product_option_group_id', $removedAssignmentIds)
                    ->delete();

                ProductOptionGroup::query()
                    ->whereIn('id', $removedAssignmentIds)
                    ->delete();
            }

            foreach ($groupIds as $position => $groupId) {
                $assignment = ProductOptionGroup::query()->updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'option_group_id' => $groupId,
                    ],
                    [
                        'sort_order' => $position + 1,
                        'has_option_configuration' => true,
                    ]
                );

                $submittedOptionIds = collect($data['option_ids'][$groupId] ?? [])
                    ->map(static fn ($id): int => (int) $id)
                    ->values();

                $validOptionIds = $submittedOptionIds->isEmpty()
                    ? collect()
                    : ProductOption::query()
                        ->where('option_group_id', $groupId)
                        ->whereIn('id', $submittedOptionIds)
                        ->pluck('id')
                        ->map(static fn ($id): int => (int) $id);

                ProductOptionGroupItem::query()
                    ->where('product_option_group_id', $assignment->id)
                    ->delete();

                foreach ($validOptionIds->values() as $optionPosition => $optionId) {
                    $config = $data['option_config'][$optionId] ?? [];
                    $quantityRule = $config['quantity_rule'] ?? 'no_limit';

                    ProductOptionGroupItem::query()->create([
                        'product_option_group_id' => $assignment->id,
                        'product_option_id' => $optionId,
                        'sort_order' => $optionPosition + 1,
                        'is_default' => array_key_exists('is_default', $config),
                        'is_active' => array_key_exists('is_active', $config),
                        'quantity_rule' => $quantityRule,
                        'min_qty' => in_array($quantityRule, ['minimum_only', 'min_max_range'], true) ? ($config['min_qty'] ?? null) : null,
                        'max_qty' => in_array($quantityRule, ['maximum_only', 'min_max_range'], true) ? ($config['max_qty'] ?? null) : null,
                        'exact_qty' => $quantityRule === 'exact_quantity_only' ? ($config['exact_qty'] ?? null) : null,
                    ]);
                }
            }
        });

        return redirect()
            ->route('admin.products.options.edit', $product)
            ->with('status', 'Option Group order was saved.');
    }
}
