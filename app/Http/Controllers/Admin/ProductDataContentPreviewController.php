<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\V1\Admin\ProductDataPageController;
use App\Http\Controllers\Storefront\ProductController;
use App\Models\ProductDataPage;
use Illuminate\Http\Request;

class ProductDataContentPreviewController extends Controller
{
    public function __invoke(Request $request, ProductDataPage $productDataPage)
    {
        $data = $request->validate(['blocks' => ['present', 'array']]);
        $productDataPage->load('layout');
        $layout = $productDataPage->layout?->draft_layout_json ?? $productDataPage->layout?->published_layout_json;
        abort_unless(is_array($layout) && ! empty($layout['rows']), 422, 'Product Data layout is empty.');

        $content = app(ProductDataPageController::class)->sanitizePreviewContent($layout, $data['blocks']);
        $html = app(ProductController::class)->showProductDataPage($productDataPage, true, $content)->render();

        return response($html)->header('Cache-Control', 'no-store, private')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }
}
