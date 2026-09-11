<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Product;
use App\Models\Review;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Product Page
    |--------------------------------------------------------------------------
    |
    | Examples:
    |
    | /products/rubberstrap
    |
    | /products/acrylic/figure
    |
    | /products/acrylic/keyholder
    |
    */

    public function show(
        string $productPath
    ) {

        /*
        |--------------------------------------------------------------------------
        | Normalize Product Path
        |--------------------------------------------------------------------------
        */

        $productPath =
            trim(
                $productPath,
                '/'
            );

        /*
        |--------------------------------------------------------------------------
        | Find Product
        |--------------------------------------------------------------------------
        */

        $product = Product::query()
            ->where(
                'slug',
                $productPath
            )
            ->where(
                'status',
                'active'
            )
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Load Relations
        |--------------------------------------------------------------------------
        */

        $product->load([
            'layout',
            'page',
            'optionSteps',
            'optionGroupAssignments.optionGroup.productOptions',
            'optionGroupAssignments.items.productOption',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Published Layout
        |--------------------------------------------------------------------------
        */

        if (
            ! $product->layout
            ||
            empty(
                $product
                    ->layout
                    ->published_layout_json
            )
        ) {

            abort(404);

        }

        /*
        |--------------------------------------------------------------------------
        | Published Content
        |--------------------------------------------------------------------------
        */

        if (
            ! $product->page
            ||
            empty(
                $product
                    ->page
                    ->published_content_json
            )
        ) {

            abort(404);

        }

        /*
        |--------------------------------------------------------------------------
        | Data
        |--------------------------------------------------------------------------
        */

        $layout =
            $product
                ->layout
                ->published_layout_json;

        $content =
            $product
                ->page
                ->published_content_json;

        $blocks =
            $content['blocks']
            ??
            [];

        $selectedFaqProductIds = collect($blocks)
            ->filter(
                fn (mixed $blockContent): bool => is_array($blockContent)
            )
            ->map(
                fn (array $blockContent): int => (int) (
                    $blockContent['faq_product_id']
                    ?? 0
                )
            )
            ->filter()
            ->unique()
            ->values();

        $faqData = [];

        if ($selectedFaqProductIds->isNotEmpty()) {
            $faqProducts = Faq::query()
                ->whereIn('id', $selectedFaqProductIds->all())
                ->where('category', 'product')
                ->where('entry_type', 'product')
                ->where('is_active', true)
                ->get([
                    'id',
                    'material',
                    'question_name',
                ])
                ->keyBy('id');

            $productFaqItems = Faq::query()
                ->whereIn('product_id', $faqProducts->keys()->all())
                ->where('category', 'product')
                ->where('entry_type', 'faq')
                ->where('is_active', true)
                ->whereNotNull('question')
                ->where('question', '<>', '')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get([
                    'id',
                    'product_id',
                    'question',
                    'answer',
                ])
                ->groupBy('product_id');

            foreach ($blocks as $blockId => $blockContent) {
                if (! is_array($blockContent)) {
                    continue;
                }

                $faqProductId = (int) (
                    $blockContent['faq_product_id']
                    ?? 0
                );

                if (! $faqProductId || ! $faqProducts->has($faqProductId)) {
                    continue;
                }

                $faqData[(string) $blockId] = [
                    'product' => $faqProducts->get($faqProductId),
                    'faqs' => $productFaqItems
                        ->get($faqProductId, collect())
                        ->take(3)
                        ->values(),
                ];
            }
        }

        $selectedReviewProductTypes = collect($blocks)
            ->filter(
                fn (mixed $blockContent): bool => is_array($blockContent)
            )
            ->map(
                fn (array $blockContent): string => trim((string) (
                    $blockContent['review_product_type']
                    ?? ''
                ))
            )
            ->filter()
            ->unique()
            ->values();

        $reviewData = [];

        if (
            $selectedReviewProductTypes->isNotEmpty()
            &&
            Review::tableExists()
        ) {
            $reviewsByProductType = Review::query()
                ->whereIn('product_type', $selectedReviewProductTypes->all())
                ->orderByDesc('date_reviews')
                ->orderByDesc('id')
                ->get([
                    'id',
                    'comment',
                    'service',
                    'product',
                    'product_type',
                    'images',
                    'sale_name',
                    'date_reviews',
                ])
                ->groupBy(
                    static fn (Review $review): string => trim((string) $review->product_type)
                );

            foreach ($blocks as $blockId => $blockContent) {
                if (! is_array($blockContent)) {
                    continue;
                }

                $reviewProductType = trim((string) (
                    $blockContent['review_product_type']
                    ?? ''
                ));

                if (
                    $reviewProductType === ''
                    ||
                    ! $reviewsByProductType->has($reviewProductType)
                ) {
                    continue;
                }

                $reviewData[(string) $blockId] = [
                    'product_type' => $reviewProductType,
                    'reviews' => $reviewsByProductType
                        ->get($reviewProductType, collect())
                        ->take(3)
                        ->values(),
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Render
        |--------------------------------------------------------------------------
        */

        return view(
            'products.show',
            [

                'product' => $product,

                'layout' => $layout,

                'contents' => $blocks,

                'publishedAt' => $product
                    ->page
                    ->published_at,

                'faqData' => $faqData,

                'reviewData' => $reviewData,

                'orderSteps' => $this->storefrontOrderSteps($product),

            ]
        );
    }

    /**
     * Build the storefront-safe order configuration from the product options
     * selected in the Admin "Manage Options" screen.
     *
     * @return list<array{id: int|null, name: string, groups: list<array<string, mixed>>}>
     */
    private function storefrontOrderSteps(Product $product): array
    {
        $assignmentsByStep = $product->optionGroupAssignments
            ->groupBy('product_option_step_id');

        $groupsForAssignments = static function ($assignments): array {
            return $assignments
                ->map(static function ($assignment): ?array {
                    $group = $assignment->optionGroup;

                    if ($group === null || ! $group->is_active) {
                        return null;
                    }

                    $optionRows = $assignment->has_option_configuration
                        ? $assignment->items
                            ->filter(static fn ($item): bool => $item->is_active && $item->productOption !== null && $item->productOption->is_active)
                            ->sortBy('sort_order')
                            ->map(static fn ($item): array => [
                                'option' => $item->productOption,
                                'is_default' => $item->is_default,
                                'quantity_rule' => $item->quantity_rule,
                                'min_qty' => $item->min_qty,
                                'max_qty' => $item->max_qty,
                                'exact_qty' => $item->exact_qty,
                            ])
                        : $group->productOptions
                            ->filter(static fn ($option): bool => $option->is_active)
                            ->map(static fn ($option): array => [
                                'option' => $option,
                                'is_default' => false,
                                'quantity_rule' => 'no_limit',
                                'min_qty' => null,
                                'max_qty' => null,
                                'exact_qty' => null,
                            ]);

                    $options = $optionRows
                        ->map(static function (array $row): array {
                            $option = $row['option'];

                            return [
                                'id' => $option->id,
                                'code' => $option->option_code,
                                'name' => $option->option_name,
                                'color_code' => $option->color_code,
                                'detail' => $option->option_detail,
                                'images' => collect($option->option_images ?? [])
                                    ->map(static fn ($image): string => basename((string) $image))
                                    ->filter()
                                    ->values()
                                    ->all(),
                                'is_default' => (bool) $row['is_default'],
                                'quantity_rule' => $row['quantity_rule'],
                                'min_qty' => $row['min_qty'],
                                'max_qty' => $row['max_qty'],
                                'exact_qty' => $row['exact_qty'],
                            ];
                        })
                        ->values()
                        ->all();

                    if ($options === []) {
                        return null;
                    }

                    return [
                        'id' => $group->id,
                        'code' => $group->group_code,
                        'name' => $group->group_name,
                        'display_type' => $group->display_type ?: 'button',
                        'help_text' => $group->help_text,
                        'is_required' => (bool) $group->is_required,
                        'show_in_order_summary' => (bool) $group->show_in_order_summary,
                        'options' => $options,
                    ];
                })
                ->filter()
                ->values()
                ->all();
        };

        $steps = $product->optionSteps
            ->map(static function ($step) use ($assignmentsByStep, $groupsForAssignments): array {
                return [
                    'id' => $step->id,
                    'name' => $step->step_name,
                    'groups' => $groupsForAssignments($assignmentsByStep->get($step->id, collect())),
                ];
            })
            ->filter(static fn (array $step): bool => $step['groups'] !== [])
            ->values();

        $unassignedGroups = $groupsForAssignments(
            $product->optionGroupAssignments
                ->filter(static fn ($assignment): bool => $assignment->product_option_step_id === null)
        );

        if ($unassignedGroups !== []) {
            $steps->push([
                'id' => null,
                'name' => $steps->isEmpty() ? 'Options' : 'Other options',
                'groups' => $unassignedGroups,
            ]);
        }

        return $steps->all();
    }
}
