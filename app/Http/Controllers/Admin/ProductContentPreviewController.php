<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\V1\Admin\ProductPageController;
use App\Http\Controllers\Storefront\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductContentPreviewController extends Controller
{
    public function __invoke(Request $request, Product $product)
    {
        $data = $request->validate(['blocks' => ['present', 'array']]);
        $product->load('layout');
        $layout = $product->layout?->draft_layout_json ?? $product->layout?->published_layout_json;
        abort_unless(is_array($layout) && ! empty($layout['rows']), 422, 'Product layout is empty.');

        $content = app(ProductPageController::class)->sanitizePreviewContent($layout, $data['blocks']);
        $html = app(ProductController::class)->renderProduct($product, true, $content)->render();

        return response($html)->header('Cache-Control', 'no-store, private')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }
}
