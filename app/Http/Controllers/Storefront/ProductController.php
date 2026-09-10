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

            ]
        );
    }
}
