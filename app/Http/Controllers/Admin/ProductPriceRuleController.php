<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPriceRule;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProductPriceRuleController extends Controller
{
    public function index(): View
    {
        return view('admin.product-price-rules.index', [
            'rules' => ProductPriceRule::query()
                ->with([
                    'product:id,name,slug',
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

        return view('admin.product-price-rules.form', [
            'rule' => new ProductPriceRule(['tax_rate' => 10]),
            'products' => $products,
            'productCatalog' => $this->productCatalog($products),
            'selectedConditionIds' => [],
            'displayTierIndex' => 0,
            'isEditing' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $product = $this->productWithOptions($data['product_id']);
        $this->validateProductOptions($data, $product);

        $rule = DB::transaction(function () use ($data): ProductPriceRule {
            return $this->persistRule(new ProductPriceRule(), $data);
        });

        return redirect()
            ->route('admin.product-price-rules.index')
            ->with('status', "Product Price Rule {$rule->rule_name} was created.");
    }

    public function edit(ProductPriceRule $productPriceRule): View
    {
        $productPriceRule->load(['conditions', 'tiers']);
        $products = $this->products();
        $displayTierIndex = $productPriceRule->tiers->search(static fn ($tier): bool => $tier->is_display);

        return view('admin.product-price-rules.form', [
            'rule' => $productPriceRule,
            'products' => $products,
            'productCatalog' => $this->productCatalog($products),
            'selectedConditionIds' => $productPriceRule->conditions
                ->pluck('product_option_id')
                ->map(static fn ($id): int => (int) $id)
                ->all(),
            'displayTierIndex' => $displayTierIndex === false ? 0 : $displayTierIndex,
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, ProductPriceRule $productPriceRule): RedirectResponse
    {
        $data = $this->validatedData($request);
        $product = $this->productWithOptions($data['product_id']);
        $this->validateProductOptions($data, $product);

        DB::transaction(function () use ($data, $productPriceRule): void {
            $this->persistRule($productPriceRule, $data);
        });

        return redirect()
            ->route('admin.product-price-rules.index')
            ->with('status', "Product Price Rule {$productPriceRule->rule_name} was updated.");
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
                    'group_code' => $group->group_code,
                    'group_name' => $group->group_name,
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
            'condition_product_option_ids' => ['required', 'array', 'min:1'],
            'condition_product_option_ids.*' => ['integer', 'distinct', 'exists:product_options,id'],
            'tax_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'tiers' => ['required', 'array', 'min:1'],
            'tiers.*.quantity' => ['required', 'integer', 'min:1', 'distinct'],
            'tiers.*.unit_price' => ['required', 'numeric', 'min:0'],
            'tiers.*.unit_price_with_tax' => ['required', 'numeric', 'min:0'],
            'display_tier_index' => ['required', 'integer', 'min:0'],
        ]);
    }

    /** @param array<string, mixed> $data */
    private function validateProductOptions(array $data, Product $product): void
    {
        $validOptionIds = $this->groupsForProduct($product)
            ->pluck('options')
            ->flatten(1)
            ->pluck('id')
            ->map(static fn ($id): int => (int) $id);
        $conditionIds = collect($data['condition_product_option_ids'])
            ->map(static fn ($id): int => (int) $id);
        $displayTierIndex = (int) $data['display_tier_index'];

        if ($conditionIds->diff($validOptionIds)->isNotEmpty()) {
            throw ValidationException::withMessages([
                'condition_product_option_ids' => 'Every required option must belong to an active Option Group assigned to this product.',
            ]);
        }

        if (! array_key_exists($displayTierIndex, $data['tiers'])) {
            throw ValidationException::withMessages([
                'display_tier_index' => 'Choose a price tier to display.',
            ]);
        }
    }

    /** @param array<string, mixed> $data */
    private function persistRule(ProductPriceRule $rule, array $data): ProductPriceRule
    {
        $rule->fill([
            'product_id' => $data['product_id'],
            'rule_name' => $data['rule_name'],
            'tax_rate' => $data['tax_rate'],
        ])->save();

        $rule->conditions()->delete();
        foreach ($data['condition_product_option_ids'] as $optionId) {
            $rule->conditions()->create(['product_option_id' => $optionId]);
        }

        $displayTierIndex = (int) $data['display_tier_index'];
        $rule->tiers()->delete();
        foreach ($data['tiers'] as $index => $tier) {
            $rule->tiers()->create([
                'quantity' => $tier['quantity'],
                'unit_price' => $tier['unit_price'],
                'unit_price_with_tax' => $tier['unit_price_with_tax'],
                'is_display' => (int) $index === $displayTierIndex,
            ]);
        }

        return $rule;
    }
}
