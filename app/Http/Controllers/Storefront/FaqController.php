<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Product;
use Illuminate\Support\Str;

class FaqController extends Controller
{
    /**
     * Product FAQ List
     *
     * GET /faq/product
     */
    public function productIndex()
    {
        $products = Product::query()
            ->select([
                'id',
                'name',
                'slug',
                'product_code',
            ])
            ->orderBy('id')
            ->get();

        $productFaqs = Faq::query()
            ->where('category', 'product')
            ->where('is_active', true)
            ->whereNotNull('question_name')
            ->where('question_name', '<>', '')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get([
                'material',
                'question_name',
            ]);

        $products->each(function (Product $product) use ($productFaqs): void {
            $faq = $productFaqs->first(
                fn (Faq $faq): bool => $this->faqBelongsToProduct($faq, $product)
            );

            $product->question_name = $faq?->question_name;
        });

        return view(
            'faq.product',
            compact('products')
        );
    }
    public function productShow(Product $product)
    {
        $faqs = Faq::query()
            ->where('category', 'product')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get([
                'id',
                'material',
                'question',
                'answer',
                'product_link',
                'product_link_text',
                'question_name',
            ])
            ->filter(
                fn (Faq $faq): bool => $this->faqBelongsToProduct($faq, $product)
            )
            ->values();

        $productFaq = $faqs->first(
            fn (Faq $faq): bool => trim((string) $faq->product_link) !== ''
                || trim((string) $faq->product_link_text) !== ''
        ) ?? $faqs->first();

        return view(
            'faq.product-show',
            [
                'product' => $product,
                'faqs' => $faqs,
                'productFaq' => $productFaq,
            ]
        );
    }


    private function faqBelongsToProduct(Faq $faq, Product $product): bool
    {
        $material = Str::lower(trim((string) $faq->material));

        if ($material === '') {
            return false;
        }

        foreach ([
            $product->product_code,
            $product->slug,
            $product->name,
        ] as $value) {
            $productKey = Str::lower(trim((string) $value));

            if (
                $productKey !== ''
                && (
                    $productKey === $material
                    || Str::contains($productKey, $material)
                    || Str::contains($material, $productKey)
                )
            ) {
                return true;
            }
        }

        return false;
    }
}
