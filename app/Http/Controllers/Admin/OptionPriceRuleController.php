<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OptionPriceRule;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OptionPriceRuleController extends Controller
{
    public function index(): View
    {
        return view('admin.option-price-rules.index', [
            'rules' => OptionPriceRule::query()
                ->with([
                    'product:id,name,slug',
                    'targetOption:id,option_group_id,option_name,option_code',
                    'conditions.productOption:id,option_name,option_code',
                ])
                ->withCount('tiers')
                ->orderBy('product_id')
                ->orderBy('rule_name')
                ->paginate(30),
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
            'selectedConditionIds' => [],
            'isEditing' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $product = $this->productWithOptions($data['product_id']);
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
        $product = $this->productWithOptions($data['product_id']);
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

    /** @return array<string, mixed> */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
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
    }

    /** @param array<string, mixed> $data */
    private function validateProductOptions(array $data, Product $product): void
    {
        $groups = $this->groupsForProduct($product);
        $allOptionIds = $groups->pluck('options')->flatten(1)->pluck('id')->map(static fn ($id): int => (int) $id);
        $mainOptionIds = $groups
            ->where('is_main_price_group', true)
            ->pluck('options')
            ->flatten(1)
            ->pluck('id')
            ->map(static fn ($id): int => (int) $id);
        $targetId = (int) $data['target_product_option_id'];
        $conditionIds = collect($data['condition_product_option_ids'] ?? [])
            ->map(static fn ($id): int => (int) $id);

        if (! $mainOptionIds->contains($targetId)) {
            throw ValidationException::withMessages([
                'target_product_option_id' => 'The target option must belong to an active Main Price Group assigned to this product.',
            ]);
        }

        if ($conditionIds->diff($allOptionIds)->isNotEmpty()) {
            throw ValidationException::withMessages([
                'condition_product_option_ids' => 'Every condition option must belong to an active Option Group assigned to this product.',
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
                'additional_price_with_tax' => $tier['additional_price_with_tax'],
            ]);
        }

        return $rule;
    }
}
