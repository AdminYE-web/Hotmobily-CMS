<?php

namespace App\Providers;

use App\Models\GalleryPage;
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
    }
}
