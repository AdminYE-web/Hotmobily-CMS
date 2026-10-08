<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\CustomPage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomPageController extends Controller
{
    public function show(Request $request, string $customPagePath): View
    {
        $previewDraft =
            $request->boolean('draft')
            && auth('admin')->check();

        $customPage = CustomPage::query()
            ->with('layout')
            ->where('slug', trim($customPagePath, '/'))
            ->when(
                ! $previewDraft,
                fn ($query) => $query->where('status', 'active')
            )
            ->firstOrFail();

        return $this->renderPage($customPage, $previewDraft);
    }

    public function renderPage(CustomPage $customPage, bool $previewDraft = false, ?array $snapshot = null): View
    {

        if (! $customPage->layout) {
            abort(404);
        }

        $layout = $previewDraft
            ? ($customPage->layout->draft_layout_json
                ?? $customPage->layout->published_layout_json)
            : $customPage->layout->published_layout_json;

        $content = $snapshot !== null ? ['blocks' => $snapshot] : ($previewDraft
            ? ($customPage->draft_content_json
                ?? $customPage->published_content_json)
            : $customPage->published_content_json);

        if (empty($layout) || empty($content)) {
            abort(404);
        }

        return view('products.show', [
            'product' => $customPage,
            'layout' => $layout,
            'contents' => $content['blocks'] ?? [],
            'visualEditorPreview' => $snapshot !== null,
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
