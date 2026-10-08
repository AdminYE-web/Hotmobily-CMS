<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\GuideMain;
use App\Models\GuidePage;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class GuideController extends Controller
{
    public function index(): View
    {
        $guideMain = GuideMain::query()
            ->with('items.guidePage')
            ->first();

        $guideItems = $guideMain?->items
            ?->filter(fn ($item): bool => $item->guidePage?->status === 'active')
            ->values()
            ?? new Collection();

        return view('guide.index', [
            'guideMain' => $guideMain,
            'guideItems' => $guideItems,
        ]);
    }

    public function show(Request $request, string $guidePath): View
    {
        $previewDraft =
            $request->boolean('draft')
            && auth('admin')->check();

        $guidePage = GuidePage::query()
            ->with('layout')
            ->where('slug', trim($guidePath, '/'))
            ->when(
                ! $previewDraft,
                fn ($query) => $query->where('status', 'active')
            )
            ->firstOrFail();

        return $this->renderPage($guidePage, $previewDraft);
    }

    public function renderPage(GuidePage $guidePage, bool $previewDraft = false, ?array $snapshot = null): View
    {

        if (! $guidePage->layout) {
            abort(404);
        }

        $layout = $previewDraft
            ? ($guidePage->layout->draft_layout_json
                ?? $guidePage->layout->published_layout_json)
            : $guidePage->layout->published_layout_json;

        $content = $snapshot !== null ? ['blocks' => $snapshot] : ($previewDraft
            ? ($guidePage->draft_content_json
                ?? $guidePage->published_content_json)
            : $guidePage->published_content_json);

        if (empty($layout) || empty($content)) {
            abort(404);
        }

        $guideMain = GuideMain::query()
            ->with('items.guidePage')
            ->first();

        $guideItems = $guideMain?->items
            ?->filter(fn ($item): bool => $item->guidePage?->status === 'active')
            ->values()
            ?? new Collection();

        return view('products.show', [
            'product' => $guidePage,
            'guideMain' => $guideMain,
            'guideItems' => $guideItems,
            'layout' => $layout,
            'contents' => $content['blocks'] ?? [],
            'visualEditorPreview' => $snapshot !== null,
            'publishedAt' => $guidePage->published_at,
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
