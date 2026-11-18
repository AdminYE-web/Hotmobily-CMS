<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\V1\Admin\ProductLayoutController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Storefront\ProductController;
use App\Models\Product;
use App\Models\ProductLayout;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductLayoutPreviewController extends Controller
{
    public function __invoke(Request $request, ProductLayout $productLayout, Product $product, ProductLayoutController $layouts, ProductController $storefront)
    {
        abort_unless((int) $product->product_layout_id === (int) $productLayout->id, 404);

        $layout = $layouts->validateLayoutSnapshot($request);
        if ($layout instanceof JsonResponse) {
            return $layout;
        }

        $page = $product->page;
        $content = $page?->draft_content_json ?? $page?->published_content_json ?? [];
        $html = $storefront->renderProduct($product, true, $content['blocks'] ?? [], $layout)->render();

        return response($html)
            ->header('Cache-Control', 'no-store, private')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }
}
