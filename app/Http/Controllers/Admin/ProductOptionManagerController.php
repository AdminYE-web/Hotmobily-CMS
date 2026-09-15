<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OptionGroup;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionGroup;
use App\Models\ProductOptionGroupItem;
use App\Models\ProductOptionStep;
use App\Models\ProductPdfSummaryCustomRow;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class ProductOptionManagerController extends Controller
{
    public function edit(Product $product): View
    {
        $assignments = ProductOptionGroup::query()
            ->where('product_id', $product->id)
            ->with(['items', 'optionGroup'])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        $selectedIds = $assignments
            ->pluck('option_group_id')
            ->map(static fn ($id): int => (int) $id)
            ->all();

        $selectedGroupSteps = $assignments
            ->mapWithKeys(static fn (ProductOptionGroup $assignment): array => [
                $assignment->option_group_id => $assignment->product_option_step_id === null
                    ? null
                    : 'step-'.$assignment->product_option_step_id,
            ])
            ->all();

        $summaryGroupIds = $assignments
            ->filter(static fn (ProductOptionGroup $assignment): bool => (bool) $assignment->show_in_order_summary)
            ->sortBy('summary_sort_order')
            ->pluck('option_group_id')
            ->map(static fn ($id): int => (int) $id)
            ->values()
            ->all();

        $previewSummaryGroupIds = $assignments
            ->filter(static fn (ProductOptionGroup $assignment): bool => (bool) $assignment->show_in_preview_summary)
            ->sortBy('preview_summary_sort_order')
            ->pluck('option_group_id')
            ->map(static fn ($id): int => (int) $id)
            ->values()
            ->all();

        $summaryFieldKeys = $assignments
            ->flatMap(static function (ProductOptionGroup $assignment): array {
                if ($assignment->optionGroup?->display_type !== 'switch') {
                    return $assignment->show_in_order_summary
                        ? [[
                            'key' => 'group-'.$assignment->option_group_id,
                            'sort_order' => (int) $assignment->summary_sort_order,
                        ]]
                        : [];
                }

                $items = $assignment->items
                    ->filter(static fn (ProductOptionGroupItem $item): bool => (bool) $item->show_in_order_summary)
                    ->sortBy('summary_sort_order');

                if ($items->isNotEmpty()) {
                    return $items
                        ->map(static fn (ProductOptionGroupItem $item): array => [
                            'key' => 'option-'.$item->product_option_id,
                            'sort_order' => (int) $item->summary_sort_order,
                        ])
                        ->all();
                }

                return $assignment->show_in_order_summary
                    ? [[
                        'key' => 'group-'.$assignment->option_group_id,
                        'sort_order' => (int) $assignment->summary_sort_order,
                    ]]
                    : [];
            })
            ->sortBy('sort_order')
            ->pluck('key')
            ->values()
            ->all();

        $previewSummaryFieldKeys = $assignments
            ->flatMap(static function (ProductOptionGroup $assignment): array {
                if ($assignment->optionGroup?->display_type !== 'switch') {
                    return $assignment->show_in_preview_summary
                        ? [[
                            'key' => 'group-'.$assignment->option_group_id,
                            'sort_order' => (int) $assignment->preview_summary_sort_order,
                        ]]
                        : [];
                }

                $items = $assignment->items
                    ->filter(static fn (ProductOptionGroupItem $item): bool => (bool) $item->show_in_preview_summary)
                    ->sortBy('preview_summary_sort_order');

                if ($items->isNotEmpty()) {
                    return $items
                        ->map(static fn (ProductOptionGroupItem $item): array => [
                            'key' => 'option-'.$item->product_option_id,
                            'sort_order' => (int) $item->preview_summary_sort_order,
                        ])
                        ->all();
                }

                return $assignment->show_in_preview_summary
                    ? [[
                        'key' => 'group-'.$assignment->option_group_id,
                        'sort_order' => (int) $assignment->preview_summary_sort_order,
                    ]]
                    : [];
            })
            ->sortBy('sort_order')
            ->pluck('key')
            ->values()
            ->all();

        $priceSummaryFieldKeys = $assignments
            ->flatMap(static function (ProductOptionGroup $assignment): array {
                if ($assignment->optionGroup?->display_type !== 'switch') {
                    return $assignment->show_in_price_summary
                        ? [[
                            'key' => 'group-'.$assignment->option_group_id,
                            'sort_order' => (int) $assignment->price_summary_sort_order,
                        ]]
                        : [];
                }

                $items = $assignment->items
                    ->filter(static fn (ProductOptionGroupItem $item): bool => (bool) $item->show_in_price_summary)
                    ->sortBy('price_summary_sort_order');

                if ($items->isNotEmpty()) {
                    return $items
                        ->map(static fn (ProductOptionGroupItem $item): array => [
                            'key' => 'option-'.$item->product_option_id,
                            'sort_order' => (int) $item->price_summary_sort_order,
                        ])
                        ->all();
                }

                return $assignment->show_in_price_summary
                    ? [[
                        'key' => 'group-'.$assignment->option_group_id,
                        'sort_order' => (int) $assignment->price_summary_sort_order,
                    ]]
                    : [];
            })
            ->sortBy('sort_order')
            ->pluck('key')
            ->values()
            ->all();

        $pdfSummaryCustomRows = Schema::hasTable('product_pdf_summary_custom_rows')
            ? ProductPdfSummaryCustomRow::query()
                ->where('product_id', $product->id)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
                ->map(static fn (ProductPdfSummaryCustomRow $row): array => [
                    'id' => (int) $row->id,
                    'key' => 'custom-'.$row->id,
                    'label' => $row->label,
                    'content' => $row->content,
                    'sort_order' => (int) $row->sort_order,
                ])
                ->values()
            : collect();

        $pdfSummaryFieldKeys = $assignments
            ->flatMap(static function (ProductOptionGroup $assignment): array {
                if ($assignment->optionGroup?->display_type !== 'switch') {
                    return $assignment->show_in_pdf_summary
                        ? [[
                            'key' => 'group-'.$assignment->option_group_id,
                            'sort_order' => (int) $assignment->pdf_summary_sort_order,
                        ]]
                        : [];
                }

                $items = $assignment->items
                    ->filter(static fn (ProductOptionGroupItem $item): bool => (bool) $item->show_in_pdf_summary)
                    ->sortBy('pdf_summary_sort_order');

                if ($items->isNotEmpty()) {
                    return $items
                        ->map(static fn (ProductOptionGroupItem $item): array => [
                            'key' => 'option-'.$item->product_option_id,
                            'sort_order' => (int) $item->pdf_summary_sort_order,
                        ])
                        ->all();
                }

                return $assignment->show_in_pdf_summary
                    ? [[
                        'key' => 'group-'.$assignment->option_group_id,
                        'sort_order' => (int) $assignment->pdf_summary_sort_order,
                    ]]
                    : [];
            })
            ->sortBy('sort_order')
            ->concat($pdfSummaryCustomRows->map(static fn (array $row): array => [
                'key' => $row['key'],
                'sort_order' => $row['sort_order'],
            ]))
            ->sortBy('sort_order')
            ->pluck('key')
            ->values()
            ->all();

        $steps = ProductOptionStep::query()
            ->where('product_id', $product->id)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(static fn (ProductOptionStep $step): array => [
                'id' => $step->id,
                'key' => 'step-'.$step->id,
                'name' => $step->step_name,
                'is_summary_step' => (bool) $step->is_summary_step,
            ])
            ->values();

        $summaryStep = $steps->first(static fn (array $step): bool => $step['is_summary_step']);
        $summaryStepKey = $summaryStep['key'] ?? ($steps->first()['key'] ?? null);

        $selectedOptionSettings = $assignments
            ->mapWithKeys(static fn (ProductOptionGroup $assignment): array => [
                $assignment->option_group_id => [
                    'configured' => $assignment->has_option_configuration,
                    'summary_label' => $assignment->summary_label,
                    'preview_summary_label' => $assignment->preview_summary_label,
                    'show_in_preview_summary' => $assignment->show_in_preview_summary,
                    'preview_summary_sort_order' => $assignment->preview_summary_sort_order,
                    'show_in_price_summary' => $assignment->show_in_price_summary,
                    'price_summary_label' => $assignment->price_summary_label,
                    'price_summary_sort_order' => $assignment->price_summary_sort_order,
                    'price_summary_option_id' => $assignment->price_summary_option_id,
                    'show_in_pdf_summary' => $assignment->show_in_pdf_summary,
                    'pdf_summary_label' => $assignment->pdf_summary_label,
                    'pdf_summary_sort_order' => $assignment->pdf_summary_sort_order,
                    'option_order' => $assignment->items
                        ->pluck('product_option_id')
                        ->map(static fn ($id): int => (int) $id)
                        ->values()
                        ->all(),
                    'items' => $assignment->items
                        ->mapWithKeys(static fn (ProductOptionGroupItem $item): array => [
                            $item->product_option_id => [
                                'is_default' => $item->is_default,
                                'is_active' => $item->is_active,
                                'quantity_rule' => $item->quantity_rule,
                                'min_qty' => $item->min_qty,
                                'max_qty' => $item->max_qty,
                                'exact_qty' => $item->exact_qty,
                                'show_in_order_summary' => $item->show_in_order_summary,
                                'summary_label' => $item->summary_label,
                                'summary_sort_order' => $item->summary_sort_order,
                                'show_in_preview_summary' => $item->show_in_preview_summary,
                                'preview_summary_label' => $item->preview_summary_label,
                                'preview_summary_sort_order' => $item->preview_summary_sort_order,
                                'show_in_price_summary' => $item->show_in_price_summary,
                                'price_summary_label' => $item->price_summary_label,
                                'price_summary_sort_order' => $item->price_summary_sort_order,
                                'price_summary_option_id' => $item->price_summary_option_id,
                                'show_in_pdf_summary' => $item->show_in_pdf_summary,
                                'pdf_summary_label' => $item->pdf_summary_label,
                                'pdf_summary_sort_order' => $item->pdf_summary_sort_order,
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
                $storedOptionOrder = $settings['option_order'] ?? [];
                $isConfigured = $settings['configured'] ?? false;
                $storedOrderLookup = array_flip($storedOptionOrder);
                $orderedOptions = $group->productOptions
                    ->sortBy(static fn (ProductOption $option): int => $storedOrderLookup[$option->id] ?? PHP_INT_MAX)
                    ->values();

                return [
                    'id' => $group->id,
                    'group_code' => $group->group_code,
                    'group_name' => $group->group_name,
                    'display_type' => $group->display_type,
                    'help_text' => $group->help_text,
                    'is_main_price_group' => $group->is_main_price_group,
                    'is_required' => $group->is_required,
                    'show_in_order_summary' => $group->show_in_order_summary,
                    'summary_label' => $settings['summary_label'] ?? null,
                    'show_in_preview_summary' => $settings['show_in_preview_summary'] ?? false,
                    'preview_summary_label' => $settings['preview_summary_label'] ?? null,
                    'show_in_price_summary' => $settings['show_in_price_summary'] ?? false,
                    'price_summary_label' => $settings['price_summary_label'] ?? null,
                    'price_summary_sort_order' => (int) ($settings['price_summary_sort_order'] ?? 0),
                    'price_summary_option_id' => $settings['price_summary_option_id'] ?? null,
                    'show_in_pdf_summary' => $settings['show_in_pdf_summary'] ?? false,
                    'pdf_summary_label' => $settings['pdf_summary_label'] ?? null,
                    'pdf_summary_sort_order' => (int) ($settings['pdf_summary_sort_order'] ?? 0),
                    'is_active' => $group->is_active,
                    'options' => $orderedOptions->map(static function (ProductOption $option) use ($isConfigured, $storedOptions): array {
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
                            'show_in_order_summary' => (bool) ($item['show_in_order_summary'] ?? false),
                            'summary_label' => $item['summary_label'] ?? null,
                            'summary_sort_order' => (int) ($item['summary_sort_order'] ?? 0),
                            'show_in_preview_summary' => (bool) ($item['show_in_preview_summary'] ?? false),
                            'preview_summary_label' => $item['preview_summary_label'] ?? null,
                            'preview_summary_sort_order' => (int) ($item['preview_summary_sort_order'] ?? 0),
                            'show_in_price_summary' => (bool) ($item['show_in_price_summary'] ?? false),
                            'price_summary_label' => $item['price_summary_label'] ?? null,
                            'price_summary_sort_order' => (int) ($item['price_summary_sort_order'] ?? 0),
                            'price_summary_option_id' => $item['price_summary_option_id'] ?? null,
                            'show_in_pdf_summary' => (bool) ($item['show_in_pdf_summary'] ?? false),
                            'pdf_summary_label' => $item['pdf_summary_label'] ?? null,
                            'pdf_summary_sort_order' => (int) ($item['pdf_summary_sort_order'] ?? 0),
                        ];
                    })->values()->all(),
                ];
            })
            ->values();

        return view('admin.products.options', compact(
            'product',
            'optionGroups',
            'selectedIds',
            'selectedGroupSteps',
            'summaryGroupIds',
            'previewSummaryGroupIds',
            'summaryFieldKeys',
            'previewSummaryFieldKeys',
            'priceSummaryFieldKeys',
            'pdfSummaryFieldKeys',
            'pdfSummaryCustomRows',
            'summaryStepKey',
            'steps'
        ));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'option_group_ids' => ['nullable', 'array'],
            'option_group_ids.*' => ['integer', 'distinct', 'exists:option_groups,id'],
            'steps' => ['required', 'array', 'min:1'],
            'steps.*.key' => ['required', 'string', 'max:100', 'regex:/^[A-Za-z0-9_-]+$/'],
            'steps.*.id' => ['nullable', 'integer'],
            'steps.*.name' => ['required', 'string', 'max:255'],
            'option_group_steps' => ['nullable', 'array'],
            'option_group_steps.*' => ['nullable', 'string', 'max:100'],
            'option_group_sort_orders' => ['nullable', 'array'],
            'option_group_sort_orders.*' => ['nullable', 'integer', 'min:1'],
            'summary_group_ids' => ['nullable', 'array'],
            'summary_group_ids.*' => ['integer', 'distinct', 'exists:option_groups,id'],
            'summary_group_labels' => ['nullable', 'array'],
            'summary_group_labels.*' => ['nullable', 'string', 'max:255'],
            'preview_summary_group_ids' => ['nullable', 'array'],
            'preview_summary_group_ids.*' => ['integer', 'distinct', 'exists:option_groups,id'],
            'preview_summary_group_labels' => ['nullable', 'array'],
            'preview_summary_group_labels.*' => ['nullable', 'string', 'max:255'],
            'summary_field_keys_present' => ['nullable', 'boolean'],
            'summary_field_keys' => ['nullable', 'array'],
            'summary_field_keys.*' => ['string', 'max:100', 'regex:/^(option|group)-[0-9]+$/'],
            'summary_field_labels' => ['nullable', 'array'],
            'summary_field_labels.*' => ['nullable', 'string', 'max:255'],
            'preview_summary_field_keys_present' => ['nullable', 'boolean'],
            'preview_summary_field_keys' => ['nullable', 'array'],
            'preview_summary_field_keys.*' => ['string', 'max:100', 'regex:/^(option|group)-[0-9]+$/'],
            'preview_summary_field_labels' => ['nullable', 'array'],
            'preview_summary_field_labels.*' => ['nullable', 'string', 'max:255'],
            'price_summary_field_keys_present' => ['nullable', 'boolean'],
            'price_summary_field_keys' => ['nullable', 'array'],
            'price_summary_field_keys.*' => ['string', 'max:100', 'regex:/^(option|group)-[0-9]+$/'],
            'price_summary_field_labels' => ['nullable', 'array'],
            'price_summary_field_labels.*' => ['nullable', 'string', 'max:255'],
            'price_summary_sources' => ['nullable', 'array'],
            'price_summary_sources.*' => ['nullable', 'integer', 'exists:product_options,id'],
            'pdf_summary_field_keys_present' => ['nullable', 'boolean'],
            'pdf_summary_field_keys' => ['nullable', 'array'],
            'pdf_summary_field_keys.*' => ['string', 'max:100', 'regex:/^(option|group)-[0-9]+$|^custom-[A-Za-z0-9_-]+$/'],
            'pdf_summary_field_labels' => ['nullable', 'array'],
            'pdf_summary_field_labels.*' => ['nullable', 'string', 'max:255'],
            'pdf_summary_custom_rows' => ['nullable', 'array', 'max:100'],
            'pdf_summary_custom_rows.*' => ['array'],
            'pdf_summary_custom_rows.*.label' => ['required', 'string', 'max:255'],
            'pdf_summary_custom_rows.*.content' => ['nullable', 'string', 'max:5000'],
            'summary_step_key' => ['nullable', 'string', 'max:100'],
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

        $summaryGroupIds = collect($data['summary_group_ids'] ?? [])
            ->map(static fn ($id): int => (int) $id)
            ->filter(static fn (int $id): bool => in_array($id, $groupIds, true))
            ->values()
            ->all();
        $hasSummaryFieldSettings = (bool) ($data['summary_field_keys_present'] ?? false);
        $summaryFieldKeys = collect($data['summary_field_keys'] ?? [])
            ->map(static fn ($key): string => trim((string) $key))
            ->filter()
            ->unique()
            ->values()
            ->all();
        if (! $hasSummaryFieldSettings) {
            $summaryFieldKeys = collect($summaryGroupIds)
                ->map(static fn (int $groupId): string => 'group-'.$groupId)
                ->all();
        }
        $summaryFieldOrderLookup = array_flip($summaryFieldKeys);
        $summaryFieldLabels = collect($data['summary_field_labels'] ?? [])
            ->mapWithKeys(static fn ($label, $fieldKey): array => [
                (string) $fieldKey => trim((string) $label),
            ])
            ->all();
        if (! $hasSummaryFieldSettings) {
            $summaryFieldLabels = collect($data['summary_group_labels'] ?? [])
            ->mapWithKeys(static fn ($label, $groupId): array => [
                'group-'.(int) $groupId => trim((string) $label),
            ])
            ->all();
        }
        $previewSummaryGroupIds = collect($data['preview_summary_group_ids'] ?? [])
            ->map(static fn ($id): int => (int) $id)
            ->filter(static fn (int $id): bool => in_array($id, $groupIds, true))
            ->values()
            ->all();
        $hasPreviewSummaryFieldSettings = (bool) ($data['preview_summary_field_keys_present'] ?? false);
        $previewSummaryFieldKeys = collect($data['preview_summary_field_keys'] ?? [])
            ->map(static fn ($key): string => trim((string) $key))
            ->filter()
            ->unique()
            ->values()
            ->all();
        if (! $hasPreviewSummaryFieldSettings) {
            $previewSummaryFieldKeys = collect($previewSummaryGroupIds)
                ->map(static fn (int $groupId): string => 'group-'.$groupId)
                ->all();
        }
        $previewSummaryFieldOrderLookup = array_flip($previewSummaryFieldKeys);
        $previewSummaryFieldLabels = collect($data['preview_summary_field_labels'] ?? [])
            ->mapWithKeys(static fn ($label, $fieldKey): array => [
                (string) $fieldKey => trim((string) $label),
            ])
            ->all();
        if (! $hasPreviewSummaryFieldSettings) {
            $previewSummaryFieldLabels = collect($data['preview_summary_group_labels'] ?? [])
            ->mapWithKeys(static fn ($label, $groupId): array => [
                'group-'.(int) $groupId => trim((string) $label),
            ])
            ->all();
        }

        $hasPriceSummaryFieldSettings = (bool) ($data['price_summary_field_keys_present'] ?? false);
        $priceSummaryFieldKeys = collect($data['price_summary_field_keys'] ?? [])
            ->map(static fn ($key): string => trim((string) $key))
            ->filter()
            ->unique()
            ->values()
            ->all();
        if (! $hasPriceSummaryFieldSettings) {
            $priceSummaryFieldKeys = $summaryFieldKeys;
        }
        $priceSummaryFieldOrderLookup = array_flip($priceSummaryFieldKeys);
        $priceSummaryFieldLabels = collect($data['price_summary_field_labels'] ?? [])
            ->mapWithKeys(static fn ($label, $fieldKey): array => [
                (string) $fieldKey => trim((string) $label),
            ])
            ->all();
        if (! $hasPriceSummaryFieldSettings) {
            $priceSummaryFieldLabels = $summaryFieldLabels;
        }
        $priceSummarySources = collect($data['price_summary_sources'] ?? [])
            ->mapWithKeys(static fn ($sourceOptionId, $fieldKey): array => [
                (string) $fieldKey => trim((string) $sourceOptionId) === '' ? null : (int) $sourceOptionId,
            ])
            ->all();

        $hasPdfSummaryFieldSettings = (bool) ($data['pdf_summary_field_keys_present'] ?? false);
        $pdfSummaryFieldKeys = collect($data['pdf_summary_field_keys'] ?? [])
            ->map(static fn ($key): string => trim((string) $key))
            ->filter()
            ->unique()
            ->values()
            ->all();
        if (! $hasPdfSummaryFieldSettings) {
            $pdfSummaryFieldKeys = $summaryFieldKeys;
        }
        $pdfSummaryFieldLabels = collect($data['pdf_summary_field_labels'] ?? [])
            ->mapWithKeys(static fn ($label, $fieldKey): array => [
                (string) $fieldKey => trim((string) $label),
            ])
            ->all();
        if (! $hasPdfSummaryFieldSettings) {
            $pdfSummaryFieldLabels = $summaryFieldLabels;
        }
        $pdfSummaryCustomRowPayload = collect($data['pdf_summary_custom_rows'] ?? [])
            ->mapWithKeys(static fn (array $row, $fieldKey): array => [
                (string) $fieldKey => [
                    'label' => trim((string) ($row['label'] ?? '')),
                    'content' => trim((string) ($row['content'] ?? '')),
                ],
            ])
            ->all();
        $existingPdfSummaryCustomRows = Schema::hasTable('product_pdf_summary_custom_rows')
            ? ProductPdfSummaryCustomRow::query()
                ->where('product_id', $product->id)
                ->get()
                ->keyBy(static fn (ProductPdfSummaryCustomRow $row): string => 'custom-'.$row->id)
            : collect();
        $pdfSummaryFieldKeys = collect($pdfSummaryFieldKeys)
            ->filter(static function (string $fieldKey) use ($pdfSummaryCustomRowPayload, $existingPdfSummaryCustomRows): bool {
                if (! str_starts_with($fieldKey, 'custom-')) {
                    return true;
                }

                return array_key_exists($fieldKey, $pdfSummaryCustomRowPayload)
                    && ($existingPdfSummaryCustomRows->has($fieldKey)
                        || preg_match('/^custom-new-[A-Za-z0-9_-]+$/', $fieldKey) === 1);
            })
            ->values()
            ->all();
        $pdfSummaryFieldOrderLookup = array_flip($pdfSummaryFieldKeys);

        $stepPayload = collect($data['steps'])
            ->values();
        $stepKeys = $stepPayload->pluck('key')->map(static fn ($key): string => (string) $key);

        if ($stepKeys->unique()->count() !== $stepKeys->count()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'steps' => 'Each Step must have a unique key.',
            ]);
        }

        $summaryStepKey = trim((string) ($data['summary_step_key'] ?? ''));

        $displayTypesByGroup = OptionGroup::query()
            ->whereIn('id', $groupIds)
            ->pluck('display_type', 'id')
            ->mapWithKeys(static fn ($displayType, $groupId): array => [
                (int) $groupId => (string) $displayType,
            ])
            ->all();

        if ($summaryStepKey !== '' && ! $stepKeys->contains($summaryStepKey)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'summary_step_key' => 'The Order Summary must be assigned to an existing Step.',
            ]);
        }

        if ($summaryStepKey === '') {
            $summaryStepKey = (string) ($stepKeys->first() ?? '');
        }

        foreach ($groupIds as $groupId) {
            $stepKey = (string) ($data['option_group_steps'][$groupId] ?? '');

            if (! $stepKeys->contains($stepKey)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'option_group_steps' => 'Every selected Option Group must be assigned to a Step.',
                ]);
            }
        }

        DB::transaction(function () use ($data, $product, $groupIds, $displayTypesByGroup, $summaryFieldKeys, $summaryFieldOrderLookup, $summaryFieldLabels, $previewSummaryFieldKeys, $previewSummaryFieldOrderLookup, $previewSummaryFieldLabels, $priceSummaryFieldKeys, $priceSummaryFieldOrderLookup, $priceSummaryFieldLabels, $priceSummarySources, $pdfSummaryFieldKeys, $pdfSummaryFieldOrderLookup, $pdfSummaryFieldLabels, $pdfSummaryCustomRowPayload, $summaryStepKey, $stepPayload): void {
            if (Schema::hasTable('product_pdf_summary_custom_rows')) {
                $existingCustomRows = ProductPdfSummaryCustomRow::query()
                    ->where('product_id', $product->id)
                    ->get()
                    ->keyBy(static fn (ProductPdfSummaryCustomRow $row): string => 'custom-'.$row->id);
                $submittedCustomIds = collect($pdfSummaryFieldKeys)
                    ->filter(static fn (string $fieldKey): bool => str_starts_with($fieldKey, 'custom-'))
                    ->map(static fn (string $fieldKey): ?int => $existingCustomRows->get($fieldKey)?->id)
                    ->filter()
                    ->values();

                ProductPdfSummaryCustomRow::query()
                    ->where('product_id', $product->id)
                    ->when(
                        $submittedCustomIds->isNotEmpty(),
                        fn ($query) => $query->whereNotIn('id', $submittedCustomIds->all())
                    )
                    ->delete();

                foreach ($pdfSummaryFieldKeys as $fieldPosition => $fieldKey) {
                    if (! str_starts_with($fieldKey, 'custom-')) {
                        continue;
                    }

                    $customRow = $pdfSummaryCustomRowPayload[$fieldKey] ?? null;
                    if ($customRow === null) {
                        continue;
                    }

                    $storedRow = $existingCustomRows->get($fieldKey);
                    if ($storedRow === null) {
                        ProductPdfSummaryCustomRow::query()->create([
                            'product_id' => $product->id,
                            'sort_order' => $fieldPosition + 1,
                            'label' => $customRow['label'],
                            'content' => $customRow['content'],
                        ]);
                    } else {
                        $storedRow->update([
                            'sort_order' => $fieldPosition + 1,
                            'label' => $customRow['label'],
                            'content' => $customRow['content'],
                        ]);
                    }
                }
            }

            $existingStepIds = ProductOptionStep::query()
                ->where('product_id', $product->id)
                ->pluck('id')
                ->map(static fn ($id): int => (int) $id);
            $stepIdsByKey = [];

            foreach ($stepPayload as $position => $step) {
                $stepId = (int) ($step['id'] ?? 0);
                $attributes = [
                    'step_name' => $step['name'],
                    'sort_order' => $position + 1,
                    'is_summary_step' => $step['key'] === $summaryStepKey,
                ];

                if ($stepId > 0 && $existingStepIds->contains($stepId)) {
                    ProductOptionStep::query()->whereKey($stepId)->update($attributes);
                } else {
                    $stepId = ProductOptionStep::query()->create([
                        'product_id' => $product->id,
                        ...$attributes,
                    ])->id;
                }

                $stepIdsByKey[$step['key']] = $stepId;
            }

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
                $stepKey = $data['option_group_steps'][$groupId];
                $isSwitchGroup = ($displayTypesByGroup[$groupId] ?? null) === 'switch';
                $submittedOptionIds = collect($data['option_ids'][$groupId] ?? [])
                    ->map(static fn ($id): int => (int) $id)
                    ->values();
                $groupSummaryKey = 'group-'.$groupId;
                $summaryFieldsForGroup = collect($summaryFieldKeys)
                    ->filter(static function (string $fieldKey) use ($groupId, $submittedOptionIds, $isSwitchGroup): bool {
                        if ($fieldKey === 'group-'.$groupId) {
                            return true;
                        }

                        return $isSwitchGroup
                            && str_starts_with($fieldKey, 'option-')
                            && $submittedOptionIds->contains((int) substr($fieldKey, 7));
                    })
                    ->values();
                $previewSummaryFieldsForGroup = collect($previewSummaryFieldKeys)
                    ->filter(static function (string $fieldKey) use ($groupId, $submittedOptionIds, $isSwitchGroup): bool {
                        if ($fieldKey === 'group-'.$groupId) {
                            return true;
                        }

                        return $isSwitchGroup
                            && str_starts_with($fieldKey, 'option-')
                            && $submittedOptionIds->contains((int) substr($fieldKey, 7));
                    })
                    ->values();
                $summarySortOrder = $summaryFieldsForGroup
                    ->map(fn (string $fieldKey): ?int => $summaryFieldOrderLookup[$fieldKey] ?? null)
                    ->filter(static fn (?int $order): bool => $order !== null)
                    ->min();
                $previewSummarySortOrder = $previewSummaryFieldsForGroup
                    ->map(fn (string $fieldKey): ?int => $previewSummaryFieldOrderLookup[$fieldKey] ?? null)
                    ->filter(static fn (?int $order): bool => $order !== null)
                    ->min();
                $priceSummaryFieldsForGroup = collect($priceSummaryFieldKeys)
                    ->filter(static function (string $fieldKey) use ($groupId, $submittedOptionIds, $isSwitchGroup): bool {
                        if ($fieldKey === 'group-'.$groupId) {
                            return true;
                        }

                        return $isSwitchGroup
                            && str_starts_with($fieldKey, 'option-')
                            && $submittedOptionIds->contains((int) substr($fieldKey, 7));
                    })
                    ->values();
                $priceSummarySortOrder = $priceSummaryFieldsForGroup
                    ->map(fn (string $fieldKey): ?int => $priceSummaryFieldOrderLookup[$fieldKey] ?? null)
                    ->filter(static fn (?int $order): bool => $order !== null)
                    ->min();
                $priceGroupKeyIncluded = $priceSummaryFieldsForGroup->contains($groupSummaryKey);
                $pdfSummaryFieldsForGroup = collect($pdfSummaryFieldKeys)
                    ->filter(static function (string $fieldKey) use ($groupId, $submittedOptionIds, $isSwitchGroup): bool {
                        if ($fieldKey === 'group-'.$groupId) {
                            return true;
                        }

                        return $isSwitchGroup
                            && str_starts_with($fieldKey, 'option-')
                            && $submittedOptionIds->contains((int) substr($fieldKey, 7));
                    })
                    ->values();
                $pdfSummarySortOrder = $pdfSummaryFieldsForGroup
                    ->map(fn (string $fieldKey): ?int => $pdfSummaryFieldOrderLookup[$fieldKey] ?? null)
                    ->filter(static fn (?int $order): bool => $order !== null)
                    ->min();
                $assignment = ProductOptionGroup::query()->updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'option_group_id' => $groupId,
                    ],
                    [
                        'product_option_step_id' => $stepIdsByKey[$stepKey],
                        'sort_order' => $data['option_group_sort_orders'][$groupId] ?? ($position + 1),
                        'has_option_configuration' => true,
                        'show_in_order_summary' => $summaryFieldsForGroup->isNotEmpty(),
                        'summary_label' => ($summaryFieldLabels[$groupSummaryKey] ?? '') !== '' ? $summaryFieldLabels[$groupSummaryKey] : null,
                        'summary_sort_order' => $summarySortOrder === null ? 0 : $summarySortOrder + 1,
                        'show_in_preview_summary' => $previewSummaryFieldsForGroup->isNotEmpty(),
                        'preview_summary_label' => ($previewSummaryFieldLabels[$groupSummaryKey] ?? '') !== '' ? $previewSummaryFieldLabels[$groupSummaryKey] : null,
                        'preview_summary_sort_order' => $previewSummarySortOrder === null ? 0 : $previewSummarySortOrder + 1,
                        'show_in_price_summary' => $priceSummaryFieldsForGroup->isNotEmpty(),
                        'price_summary_label' => ($priceSummaryFieldLabels[$groupSummaryKey] ?? '') !== '' ? $priceSummaryFieldLabels[$groupSummaryKey] : null,
                        'price_summary_sort_order' => $priceSummarySortOrder === null ? 0 : $priceSummarySortOrder + 1,
                        'price_summary_option_id' => $priceGroupKeyIncluded ? ($priceSummarySources[$groupSummaryKey] ?? null) : null,
                        'show_in_pdf_summary' => $pdfSummaryFieldsForGroup->isNotEmpty(),
                        'pdf_summary_label' => ($pdfSummaryFieldLabels[$groupSummaryKey] ?? '') !== '' ? $pdfSummaryFieldLabels[$groupSummaryKey] : null,
                        'pdf_summary_sort_order' => $pdfSummarySortOrder === null ? 0 : $pdfSummarySortOrder + 1,
                    ]
                );

                $existingOptionIds = $submittedOptionIds->isEmpty()
                    ? collect()
                    : ProductOption::query()
                        ->where('option_group_id', $groupId)
                        ->whereIn('id', $submittedOptionIds)
                        ->pluck('id')
                        ->map(static fn ($id): int => (int) $id);

                // Keep the order submitted by the drag-and-drop interface;
                // a SQL WHERE IN query does not guarantee that same order.
                $validOptionIds = $submittedOptionIds
                    ->filter(static fn (int $optionId): bool => $existingOptionIds->contains($optionId))
                    ->values();

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
                        'show_in_order_summary' => $isSwitchGroup && in_array('option-'.$optionId, $summaryFieldKeys, true),
                        'summary_label' => $isSwitchGroup && ($summaryFieldLabels['option-'.$optionId] ?? '') !== '' ? $summaryFieldLabels['option-'.$optionId] : null,
                        'summary_sort_order' => $isSwitchGroup && isset($summaryFieldOrderLookup['option-'.$optionId]) ? $summaryFieldOrderLookup['option-'.$optionId] + 1 : 0,
                        'show_in_preview_summary' => $isSwitchGroup && in_array('option-'.$optionId, $previewSummaryFieldKeys, true),
                        'preview_summary_label' => $isSwitchGroup && ($previewSummaryFieldLabels['option-'.$optionId] ?? '') !== '' ? $previewSummaryFieldLabels['option-'.$optionId] : null,
                        'preview_summary_sort_order' => $isSwitchGroup && isset($previewSummaryFieldOrderLookup['option-'.$optionId]) ? $previewSummaryFieldOrderLookup['option-'.$optionId] + 1 : 0,
                        'show_in_price_summary' => $isSwitchGroup && in_array('option-'.$optionId, $priceSummaryFieldKeys, true),
                        'price_summary_label' => $isSwitchGroup && ($priceSummaryFieldLabels['option-'.$optionId] ?? '') !== '' ? $priceSummaryFieldLabels['option-'.$optionId] : null,
                        'price_summary_sort_order' => $isSwitchGroup && isset($priceSummaryFieldOrderLookup['option-'.$optionId]) ? $priceSummaryFieldOrderLookup['option-'.$optionId] + 1 : 0,
                        'price_summary_option_id' => $isSwitchGroup && in_array('option-'.$optionId, $priceSummaryFieldKeys, true)
                            ? ($priceSummarySources['option-'.$optionId] ?? $optionId)
                            : null,
                        'show_in_pdf_summary' => $isSwitchGroup && in_array('option-'.$optionId, $pdfSummaryFieldKeys, true),
                        'pdf_summary_label' => $isSwitchGroup && ($pdfSummaryFieldLabels['option-'.$optionId] ?? '') !== '' ? $pdfSummaryFieldLabels['option-'.$optionId] : null,
                        'pdf_summary_sort_order' => $isSwitchGroup && isset($pdfSummaryFieldOrderLookup['option-'.$optionId]) ? $pdfSummaryFieldOrderLookup['option-'.$optionId] + 1 : 0,
                    ]);
                }
            }

            $removedStepIds = $existingStepIds->diff(collect($stepIdsByKey)->values());

            if ($removedStepIds->isNotEmpty()) {
                ProductOptionStep::query()
                    ->whereIn('id', $removedStepIds)
                    ->delete();
            }
        });

        return redirect()
            ->route('admin.products.options.edit', $product)
            ->with('status', 'Option Steps and Option Group order were saved.');
    }
}
