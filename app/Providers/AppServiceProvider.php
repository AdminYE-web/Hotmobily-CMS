<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\CustomPageMenuItem;
use App\Models\GalleryMenuItem;
use App\Models\GalleryPage;
use App\Models\ProductDataMenuItem;
use App\Models\ProductSideMenuItem;
use App\Models\SideMenuLinkItem;
use App\Models\UserManualMenuItem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('partials.legacy-sidebar', function ($view): void {
            $hasConfiguredItems = Schema::hasTable('product_side_menu_items')
                && ProductSideMenuItem::query()->exists();

            $items = collect();
            if (Schema::hasTable('product_side_menu_items')
                && Schema::hasTable('products')
                && Schema::hasTable('product_layouts')
                && Schema::hasTable('product_pages')) {
                $items = ProductSideMenuItem::query()
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
                    ->filter(static function (ProductSideMenuItem $item): bool {
                        $product = $item->product;

                        return $product !== null
                            && $product->layout !== null
                            && ! empty($product->layout->published_layout_json)
                            && $product->page !== null
                            && ! empty($product->page->published_content_json)
                            && $item->image_path !== '';
                    })
                    ->values();
            }

            $view->with([
                'sideMenuProductItems' => $items,
                'hasConfiguredSideMenuProducts' => $hasConfiguredItems,
            ]);
        });

        View::composer('partials.legacy-sidebar', function ($view): void {
            $hasConfiguredItems = Schema::hasTable('side_menu_link_items')
                && SideMenuLinkItem::query()->exists();
            $items = Schema::hasTable('side_menu_link_items')
                ? SideMenuLinkItem::query()
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->get()
                : collect();

            $view->with([
                'sideMenuLinkItems' => $items,
                'hasConfiguredSideMenuLinks' => $hasConfiguredItems,
            ]);
        });

        View::composer('partials.legacy-navigation', function ($view): void {
            $navigationItems = Schema::hasTable('product_data_menu_items')
                && Schema::hasTable('product_data_pages')
                && Schema::hasTable('product_data_layouts')
                ? ProductDataMenuItem::query()
                    ->with('productDataPage.layout')
                    ->whereHas('productDataPage', function ($query): void {
                        $query
                            ->where('status', 'active')
                            ->whereNotNull('published_content_json')
                            ->whereHas('layout', fn ($layoutQuery) => $layoutQuery->whereNotNull('published_layout_json'));
                    })
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->get()
                    ->filter(static function (ProductDataMenuItem $item): bool {
                        $page = $item->productDataPage;

                        return $page !== null
                            && ! empty($page->published_content_json)
                            && $page->layout !== null
                            && ! empty($page->layout->published_layout_json);
                    })
                    ->values()
                : collect();

            $view->with('productDataNavigationItems', $navigationItems);

            $galleryNavigationItems = Schema::hasTable('gallery_menu_items')
                && Schema::hasTable('gallery_pages')
                ? GalleryMenuItem::query()
                    ->with('galleryPage')
                    ->whereHas('galleryPage', fn ($query) => $query->active())
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->get()
                    ->filter(static fn (GalleryMenuItem $item): bool => $item->galleryPage !== null)
                    ->values()
                : collect();

            $view->with('galleryNavigationItems', $galleryNavigationItems);

            $customPageNavigationItems = Schema::hasTable('custom_page_menu_items')
                && Schema::hasTable('custom_pages')
                && Schema::hasTable('custom_page_layouts')
                ? CustomPageMenuItem::query()
                    ->with('customPage.layout')
                    ->whereHas('customPage', function ($query): void {
                        $query
                            ->where('status', 'active')
                            ->whereNotNull('published_content_json')
                            ->whereHas('layout', fn ($layoutQuery) => $layoutQuery->whereNotNull('published_layout_json'));
                    })
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->get()
                    ->filter(static function (CustomPageMenuItem $item): bool {
                        $page = $item->customPage;

                        return $page !== null
                            && ! empty($page->published_content_json)
                            && $page->layout !== null
                            && ! empty($page->layout->published_layout_json);
                    })
                    ->values()
                : collect();

            $view->with('customPageNavigationItems', $customPageNavigationItems);

            $userManualNavigationItems = Schema::hasTable('user_manual_menu_items')
                && Schema::hasTable('custom_pages')
                && Schema::hasTable('custom_page_layouts')
                ? UserManualMenuItem::query()
                    ->with('customPage.layout')
                    ->whereHas('customPage', function ($query): void {
                        $query
                            ->where('status', 'active')
                            ->whereNotNull('published_content_json')
                            ->whereHas('layout', fn ($layoutQuery) => $layoutQuery->whereNotNull('published_layout_json'));
                    })
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->get()
                    ->filter(static function (UserManualMenuItem $item): bool {
                        $page = $item->customPage;

                        return $page !== null
                            && ! empty($page->published_content_json)
                            && $page->layout !== null
                            && ! empty($page->layout->published_layout_json);
                    })
                    ->values()
                : collect();

            $view->with('userManualNavigationItems', $userManualNavigationItems);
        });

        View::composer('admin.partials.sidebar', function ($view): void {
            $galleryPages = Schema::hasTable('gallery_pages')
                ? GalleryPage::query()
                    ->active()
                    ->orderBy('sort_order')
                    ->orderBy('name')
                    ->get()
                : collect();

            $view->with('adminGalleryPages', $galleryPages);
        });

        View::composer('partials.header', function ($view): void {
            $headerBanner = Schema::hasTable('banners')
                ? Banner::query()
                    ->header()
                    ->first()
                : null;
            $contactBanner = Schema::hasTable('banners')
                ? Banner::query()
                    ->contact()
                    ->first()
                : null;

            $view->with([
                'headerBanner' => $headerBanner,
                'contactBanner' => $contactBanner,
            ]);
        });
    }
}
