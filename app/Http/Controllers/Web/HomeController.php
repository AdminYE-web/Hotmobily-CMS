<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use App\Models\HomeProductCard;
use App\Models\News;
use App\Models\Review;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Schema;
use Throwable;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $homeBanners = Schema::hasTable('home_banners')
            ? HomeBanner::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
            : HomeBanner::legacyDefaults();

        $hasConfiguredHomeProductCards = Schema::hasTable('home_product_cards')
            && HomeProductCard::query()->exists();
        $homeProductCards = collect();

        if (Schema::hasTable('home_product_cards')
            && Schema::hasTable('products')
            && Schema::hasTable('product_layouts')
            && Schema::hasTable('product_pages')) {
            $homeProductCards = HomeProductCard::query()
                ->with(['product:id,name,slug,status,product_layout_id', 'product.layout', 'product.page'])
                ->whereHas('product', function ($query): void {
                    $query
                        ->where('status', 'active')
                        ->whereHas('layout', fn ($layoutQuery) => $layoutQuery->whereNotNull('published_layout_json'))
                        ->whereHas('page', fn ($pageQuery) => $pageQuery->whereNotNull('published_content_json'));
                })
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
                ->filter(static function (HomeProductCard $card): bool {
                    $product = $card->product;

                    return $product !== null
                        && $product->layout !== null
                        && ! empty($product->layout->published_layout_json)
                        && $product->page !== null
                        && ! empty($product->page->published_content_json);
                })
                ->values();
        }

        $news = News::tableExists()
            ? News::query()
                ->activeInCategory('top')
                ->orderByDesc('published_at')
                ->orderByDesc('id')
                ->limit(3)
                ->get()
            : collect();

        $reviews = $this->loadReviews();

        return view('home', compact(
            'news',
            'reviews',
            'homeBanners',
            'homeProductCards',
            'hasConfiguredHomeProductCards'
        ));
    }

    private function loadReviews(): array
    {
        if (! Review::tableExists()) {
            return [];
        }

        try {
            return Review::query()
                ->orderByDesc('date_reviews')
                ->orderByDesc('id')
                ->limit((int) config('reviews.display_limit', 20))
                ->get()
                ->map(static fn (Review $review): array => $review->toDisplayArray())
                ->all();
        } catch (Throwable) {
            return [];
        }
    }
}
