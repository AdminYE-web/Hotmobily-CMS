<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\CustomPage;
use Illuminate\View\View;

class CustomPageController extends Controller
{
    public function show(string $customPagePath): View
    {
        $customPage = CustomPage::query()
            ->with('layout')
            ->where('slug', trim($customPagePath, '/'))
            ->where('status', 'active')
            ->firstOrFail();

        if (
            ! $customPage->layout
            || empty($customPage->layout->published_layout_json)
            || empty($customPage->published_content_json)
        ) {
            abort(404);
        }

        return view('products.show', [
            'product' => $customPage,
            'layout' => $customPage->layout->published_layout_json,
            'contents' => $customPage->published_content_json['blocks'] ?? [],
            'publishedAt' => $customPage->published_at,
            'faqData' => [],
            'reviewData' => [],
            'orderSteps' => [],
            'orderPricing' => [],
            'orderDependencies' => [],
            'pdfSummaryCustomRows' => [],
            'confirmSummaryCustomRows' => [],
            'completeSummaryCustomRows' => [],
        ]);
    }
}
