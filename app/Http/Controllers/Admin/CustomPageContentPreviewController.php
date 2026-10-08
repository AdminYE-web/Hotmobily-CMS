<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\V1\Admin\CustomPageController as ContentController;
use App\Http\Controllers\Storefront\CustomPageController as StorefrontController;
use App\Models\CustomPage;
use Illuminate\Http\Request;

class CustomPageContentPreviewController extends Controller
{
    public function __invoke(Request $request, CustomPage $customPage)
    {
        $data = $request->validate(['blocks' => ['present', 'array']]);
        $customPage->load('layout');
        $layout = $customPage->layout?->draft_layout_json ?? $customPage->layout?->published_layout_json;
        abort_unless(is_array($layout) && ! empty($layout['rows']), 422, 'Custom Page layout is empty.');

        $content = app(ContentController::class)->sanitizePreviewContent($layout, $data['blocks']);
        $html = app(StorefrontController::class)->renderPage($customPage, true, $content)->render();

        return response($html)->header('Cache-Control', 'no-store, private')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }
}
