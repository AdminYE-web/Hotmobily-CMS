<?php

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\GalleryPage;
use App\Services\GalleryItems;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function show(string $galleryPage, GalleryItems $items): View
    {
        $page = GalleryPage::query()->active()->where('public_slug', $galleryPage)->firstOrFail();
        return view('gallery.rubber-keyholder', [
            'galleryPage' => $page,
            'galleries' => $items->forPage($page),
        ]);
    }
}
