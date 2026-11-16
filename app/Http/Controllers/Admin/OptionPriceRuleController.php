<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OptionPriceRule;
use App\Models\OptionGroup;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OptionPriceRuleController extends Controller
{
    public function index(Request $request): View
    {
        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'product' => (string) $request->query('product', ''),
            'price_type' => (string) $request->query('price_type', ''),
        ];

        $rules = OptionPriceRule::query()
            ->with([
                'product:id,name,slug',
                'targetOption:id,option_group_id,option_name,option_code',
                'conditions.productOption:id,option_name,option_code',
            ])
            ->withCount('tiers')
            ->when($filters['q'] !== '', function ($query) use ($filters): void {
                $like = '%'.addcslashes($filters['q'], '%_\\').'%';

                $query->where(function ($query) use ($like): void {
                    $query->where('rule_name', 'like', $like)
                        ->orWhereHas('product', fn ($q) => $q->where('name', 'like', $like)->orWhere('slug', 'like', $like))
                        ->orWhereHas('targetOption', fn ($q) => $q->where('option_name', 'like', $like)->orWhere('option_code', 'like', $like))
                        ->orWhereHas('conditions.productOption', fn ($q) => $q->where('option_name', 'like', $like)->orWhere('option_code', 'like', $like));
                });
            })
            ->when($filters['product'] === 'global', fn ($query) => $query->whereNull('product_id'))
            ->when(ctype_digit($filters['product']), fn ($query) => $query->where('product_id', (int) $filters['product']))
            ->when(in_array($filters['price_type'], ['per_piece', 'per_order'], true), fn ($query) => $query->where('price_type', $filters['price_type']))
            ->orderByDesc('id')
            ->paginate(30)
            ->withQueryString();

        return view('admin.option-price-rules.index', [
            'rules' => $rules,
            'filters' => $filters,
            'productOptions' => Product::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function create(): View
    {
        $products = $this->products();

        return view('admin.option-price-rules.form', [
            'rule' => new OptionPriceRule([
                'price_type' => 'per_order',
                'tax_rate' => 10,
            ]),
            'products' => $products,
            'productCatalog' => $this->productCatalog($products),
            'globalOptionGroups' => $this->globalOptionGroups(),
            'selectedConditionIds' => [],
            'isEditing' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $product = $data['product_id'] === null ? null : $this->productWithOptions($data['product_id']);
        $this->validateProductOptions($data, $product);

        $rule = DB::transaction(function () use ($data): OptionPriceRule {
            return $this->persistRule(new OptionPriceRule(), $data);
        });

        return redirect()
            ->route('admin.option-price-rules.index')
            ->with('status', "Option Price Rule {$rule->rule_name} was created.");
    }

    public function edit(OptionPriceRule $optionPriceRule): View
    {
        $optionPriceRule->load(['conditions', 'tiers']);
        $products = $this->products();

        return view('admin.option-price-rules.form', [
            'rule' => $optionPriceRule,
            'products' => $products,
            'productCatalog' => $this->productCatalog($products),
            'globalOptionGroups' => $this->globalOptionGroups(),
            'selectedConditionIds' => $optionPriceRule->conditions
                ->pluck('product_option_id')
                ->map(static fn ($id): int => (int) $id)
                ->all(),
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, OptionPriceRule $optionPriceRule): RedirectResponse
    {
        $data = $this->validatedData($request);
        $product = $data['product_id'] === null ? null : $this->productWithOptions($data['product_id']);
        $this->validateProductOptions($data, $product);

        DB::transaction(function () use ($data, $optionPriceRule): void {
            $this->persistRule($optionPriceRule, $data);
        });

        return redirect()
            ->route('admin.option-price-rules.index')
            ->with('status', "Option Price Rule {$optionPriceRule->rule_name} was updated.");
    }

    /** @return EloquentCollection<int, Product> */
    private function products(): EloquentCollection
    {
        return Product::query()
            ->with([
                'optionGroupAssignments.optionGroup.productOptions',
                'optionGroupAssignments.items.productOption',
            ])
            ->orderBy('name')
            ->get();
    }

    private function productWithOptions(int $productId): Product
    {
        return Product::query()
            ->with([
                'optionGroupAssignments.optionGroup.productOptions',
                'optionGroupAssignments.items.productOption',
            ])
            ->findOrFail($productId);
    }

    /** @param EloquentCollection<int, Product> $products */
    private function productCatalog(EloquentCollection $products): Collection
    {
        return $products->map(fn (Product $product): array => [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'groups' => $this->groupsForProduct($product)->all(),
        ])->values();
    }

    /** @return Collection<int, array<string, mixed>> */
    private function groupsForProduct(Product $product): Collection
    {
        return $product->optionGroupAssignments
            ->filter(static fn ($assignment): bool => $assignment->optionGroup !== null && $assignment->optionGroup->is_active)
            ->sortBy('sort_order')
            ->values()
            ->map(function ($assignment): array {
                $group = $assignment->optionGroup;
                $options = $assignment->has_option_configuration
                    ? $assignment->items
                        ->filter(static fn ($item): bool => $item->productOption !== null && $item->is_active && $item->productOption->is_active)
                        ->sortBy('sort_order')
                        ->map(static fn ($item) => $item->productOption)
                    : $group->productOptions->where('is_active', true);

                return [
                    'id' => $group->id,
                    'group_code' => $group->group_code,
                    'group_name' => $group->group_name,
                    'is_main_price_group' => (bool) $group->is_main_price_group,
                    'options' => $options
                        ->unique('id')
                        ->values()
                        ->map(static fn ($option): array => [
                            'id' => $option->id,
                            'option_code' => $option->option_code,
                            'option_name' => $option->option_name,
                        ])
                        ->all(),
                ];
            });
    }

    private function globalOptionGroups(): Collection
    {
        return OptionGroup::where('is_active', true)->with(['productOptions' => fn ($query) => $query->where('is_active', true)])
            ->orderBy('group_name')->get()->map(static fn (OptionGroup $group): array => [
                'id' => $group->id, 'group_code' => $group->group_code, 'group_name' => $group->group_name,
                'is_main_price_group' => (bool) $group->is_main_price_group,
                'options' => $group->productOptions->sortBy('option_name', SORT_NATURAL | SORT_FLAG_CASE)->values()->map(static fn ($option): array => [
                    'id' => $option->id, 'option_code' => $option->option_code, 'option_name' => $option->option_name,
                ])->all(),
            ])->values();
    }

    /** @return array<string, mixed> */
    private function validatedData(Request $request): array
    {
        $global = $request->boolean('applies_to_all_products');
        $data = $request->validate([
            'applies_to_all_products' => ['sometimes', 'boolean'],
            'product_id' => [Rule::excludeIf($global), Rule::requiredIf(!$global), 'nullable', 'integer', 'exists:products,id'],
            'rule_name' => ['required', 'string', 'max:255'],
            'price_type' => ['required', 'in:per_order,per_piece'],
            'target_product_option_id' => ['required', 'integer', 'exists:product_options,id'],
            'condition_product_option_ids' => ['nullable', 'array'],
            'condition_product_option_ids.*' => ['integer', 'distinct', 'exists:product_options,id'],
            'tax_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'tiers' => ['required', 'array', 'min:1'],
            'tiers.*.quantity' => ['required', 'integer', 'min:1', 'distinct'],
            'tiers.*.additional_price' => ['required', 'numeric', 'min:0'],
            'tiers.*.additional_price_with_tax' => ['required', 'numeric', 'min:0'],
        ]);
        $data['product_id'] = $global ? null : (int) $data['product_id'];
        return $data;
    }

    /** @param array<string, mixed> $data */
    private function validateProductOptions(array $data, ?Product $product): void
    {
        $groups = $product ? $this->groupsForProduct($product) : $this->globalOptionGroups();
        $allOptionIds = $groups->pluck('options')->flatten(1)->pluck('id')->map(static fn ($id): int => (int) $id);
        $targetId = (int) $data['target_product_option_id'];
        $conditionIds = collect($data['condition_product_option_ids'] ?? [])
            ->map(static fn ($id): int => (int) $id);

        if (! $allOptionIds->contains($targetId)) {
            throw ValidationException::withMessages([
                'target_product_option_id' => $product ? 'The target option must belong to an active Option Group assigned to this product.' : 'The target option must be active and belong to an active Option Group.',
            ]);
        }

        if ($conditionIds->diff($allOptionIds)->isNotEmpty()) {
            throw ValidationException::withMessages([
                'condition_product_option_ids' => $product ? 'Every condition option must belong to an active Option Group assigned to this product.' : 'Every condition option must be active and belong to an active Option Group.',
            ]);
        }
    }

    /** @param array<string, mixed> $data */
    private function persistRule(OptionPriceRule $rule, array $data): OptionPriceRule
    {
        $rule->fill([
            'product_id' => $data['product_id'],
            'rule_name' => $data['rule_name'],
            'price_type' => $data['price_type'],
            'target_product_option_id' => $data['target_product_option_id'],
            'tax_rate' => $data['tax_rate'],
        ])->save();

        $rule->conditions()->delete();
        foreach ($data['condition_product_option_ids'] ?? [] as $optionId) {
            $rule->conditions()->create(['product_option_id' => $optionId]);
        }

        $rule->tiers()->delete();
        foreach ($data['tiers'] as $tier) {
            $rule->tiers()->create([
                'quantity' => $tier['quantity'],
                'additional_price' => $tier['additional_price'],
                'additional_price_with_tax' => floor((float) $tier['additional_price_with_tax']),
            ]);
        }

        return $rule;
    }
}
