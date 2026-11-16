<?php

namespace App\Services;

use App\Models\Faq;
use App\Models\HomeProductCard;
use App\Models\OptionPriceRule;
use App\Models\Product;
use App\Models\ProductCompleteSummaryCustomRow;
use App\Models\ProductConfirmSummaryCustomRow;
use App\Models\ProductOptionGroup;
use App\Models\ProductOptionStep;
use App\Models\ProductPage;
use App\Models\ProductPdfSummaryCustomRow;
use App\Models\ProductPriceRule;
use App\Models\ProductSideMenuItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductDuplicator
{
    public function duplicate(Product $product): Product
    {
        return DB::transaction(function () use ($product) {
            $source = Product::query()->lockForUpdate()->findOrFail($product->id);
            $copy = $source->replicate();
            $copy->name = Str::substr($source->name, 0, 248).' (Copy)';
            $copy->slug = $this->uniqueSlug($source);
            $copy->status = 'draft';

            // Preserve block IDs so draft and published content still match the layout.
            if ($source->layout) {
                $layout = $source->layout->replicate();
                $layout->name = Str::substr($layout->name, 0, 248).' (Copy)';
                $layout->slug = $this->uniqueSlug($source->layout);
                $layout->save();
                $copy->product_layout_id = $layout->id;
            }
            $copy->save();

            $steps = [];
            foreach ($this->records(ProductOptionStep::class, $source->id) as $step) {
                $steps[$step->id] = $this->copyRecord($step, ['product_id' => $copy->id])->id;
            }

            // Options and groups are shared catalog definitions; copy their product settings.
            foreach ($this->records(ProductOptionGroup::class, $source->id) as $group) {
                $attributes = ['product_id' => $copy->id];
                if (array_key_exists('product_option_step_id', $group->getAttributes())) {
                    $attributes['product_option_step_id'] = $steps[$group->product_option_step_id] ?? null;
                }
                $groupCopy = $this->copyRecord($group, $attributes);
                foreach ($group->items as $item) {
                    $this->copyRecord($item, ['product_option_group_id' => $groupCopy->id]);
                }
            }

            foreach ([ProductPriceRule::class, OptionPriceRule::class] as $model) {
                foreach ($this->records($model, $source->id) as $rule) {
                    $ruleCopy = $this->copyRecord($rule, ['product_id' => $copy->id]);
                    foreach (['conditions', 'tiers'] as $relation) {
                        $foreignKey = $rule->$relation()->getForeignKeyName();
                        foreach ($rule->$relation as $child) {
                            $this->copyRecord($child, [$foreignKey => $ruleCopy->id]);
                        }
                    }
                }
            }

            foreach ([
                ProductPage::class,
                ProductPdfSummaryCustomRow::class,
                ProductConfirmSummaryCustomRow::class,
                ProductCompleteSummaryCustomRow::class,
                Faq::class,
                ProductSideMenuItem::class,
                HomeProductCard::class,
            ] as $model) {
                foreach ($this->records($model, $source->id) as $record) {
                    $this->copyRecord($record, ['product_id' => $copy->id]);
                }
            }

            return $copy->fresh()->load(['layout', 'page']);
        });
    }

    private function uniqueSlug(Model $source): string
    {
        $base = Str::substr($source->slug, 0, 230).'-copy';
        $slug = $base;
        $number = 2;
        while ($source->newQuery()->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$number++;
        }

        return $slug;
    }

    private function records(string $model, int $productId): Collection
    {
        // Older installations may not have the optional settings tables yet.
        if (! Schema::hasTable((new $model)->getTable())) {
            return new Collection;
        }

        return $model::query()->where('product_id', $productId)->orderBy('id')->get();
    }

    private function copyRecord(Model $source, array $attributes): Model
    {
        $copy = $source->replicate();
        $copy->forceFill($attributes)->save();

        return $copy;
    }
}
