<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\V1\Admin\GuidePageController as ContentController;
use App\Http\Controllers\Storefront\GuideController as StorefrontController;
use App\Models\GuidePage;
use Illuminate\Http\Request;

class GuideContentPreviewController extends Controller
{
    public function __invoke(Request $request, GuidePage $guidePage)
    {
        $data = $request->validate(['blocks' => ['present', 'array']]);
        $guidePage->load('layout');
        $layout = $guidePage->layout?->draft_layout_json ?? $guidePage->layout?->published_layout_json;
        abort_unless(is_array($layout) && ! empty($layout['rows']), 422, 'Guide layout is empty.');

        $content = app(ContentController::class)->sanitizePreviewContent($layout, $data['blocks']);
        $html = app(StorefrontController::class)->renderPage($guidePage, true, $content)->render();

        return response($html)->header('Cache-Control', 'no-store, private')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }
}
