<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryPage;
use App\Services\GalleryItems;
use Illuminate\Http\JsonResponse;

class GalleryShowcaseController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => GalleryPage::active()->orderBy('sort_order')->orderBy('id')
            ->get(['id', 'name', 'slug', 'public_slug', 'heading'])]);
    }

    public function show(int $id, GalleryItems $items): JsonResponse
    {
        $page = GalleryPage::active()->findOrFail($id);
        return response()->json(['data' => ['id' => $page->id, 'items' => $items->choices($page)]]);
    }
}
