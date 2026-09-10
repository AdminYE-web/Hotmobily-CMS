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
            ->where('entry_type', 'product')
            ->where('is_active', true)
            ->whereNotNull('question_name')
            ->where('question_name', '<>', '')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get([
                'entry_type',
                'material',
                'question_name',
                'product_link',
                'product_link_text',
            ]);

        $products->each(function (Product $product) use ($productFaqs): void {
            $faq = $productFaqs->first(
                fn (Faq $faq): bool => ($faq->entry_type ?? 'faq') === 'product'
                    && $this->faqBelongsToProduct($faq, $product)
            ) ?? $productFaqs->first(
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
        $productEntries = Faq::query()
            ->where('category', 'product')
            ->where('entry_type', 'product')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get([
                'id',
                'entry_type',
                'material',
                'product_link',
                'product_link_text',
                'question_name',
            ])
            ->filter(
                fn (Faq $faq): bool => $this->faqBelongsToProduct($faq, $product)
            )
            ->values();

        $productFaq = $productEntries->first();

        $faqs = Faq::query()
            ->where('category', 'product')
            ->where('entry_type', 'faq')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get([
                'id',
                'product_id',
                'material',
                'question',
                'answer',
            ])
            ->filter(
                function (Faq $faq) use ($product, $productFaq): bool {
                    if (trim((string) $faq->question) === '') {
                        return false;
                    }

                    if ($productFaq && $faq->product_id !== null) {
                        return (int) $faq->product_id === (int) $productFaq->id;
                    }

                    if ($faq->product_id !== null) {
                        return false;
                    }

                    return $this->faqBelongsToProduct($faq, $product);
                }
            )
            ->values();

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
