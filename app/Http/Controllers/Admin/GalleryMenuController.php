<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryMenuItem;
use App\Models\GalleryPage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GalleryMenuController extends Controller
{
    public function index(): View
    {
        return view('admin.gallery-menu.index', [
            'items' => GalleryMenuItem::query()
                ->with('galleryPage:id,name,slug,public_slug,is_active')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.gallery-menu.form', [
            'item' => new GalleryMenuItem(),
            'pages' => $this->availablePages(),
            'usedPageIds' => $this->usedPageIds(),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gallery_page_id' => [
                'required',
                'integer',
                'exists:gallery_pages,id',
                Rule::unique('gallery_menu_items', 'gallery_page_id'),
            ],
        ]);

        GalleryMenuItem::query()->create([
            'name' => trim($data['name']),
            'gallery_page_id' => $data['gallery_page_id'],
            'sort_order' => ((int) GalleryMenuItem::query()->max('sort_order')) + 10,
        ]);

        return redirect()
            ->route('admin.gallery-menu.index')
            ->with('status', 'Gallery menu item added.');
    }

    public function edit(GalleryMenuItem $galleryMenuItem): View
    {
        return view('admin.gallery-menu.form', [
            'item' => $galleryMenuItem->load('galleryPage:id,name,slug,public_slug,is_active'),
            'pages' => $this->availablePages(),
            'usedPageIds' => $this->usedPageIds((int) $galleryMenuItem->id),
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, GalleryMenuItem $galleryMenuItem): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'gallery_page_id' => [
                'required',
                'integer',
                'exists:gallery_pages,id',
                Rule::unique('gallery_menu_items', 'gallery_page_id')->ignore($galleryMenuItem->id),
            ],
        ]);

        $galleryMenuItem->update([
            'name' => trim($data['name']),
            'gallery_page_id' => $data['gallery_page_id'],
        ]);

        return redirect()
            ->route('admin.gallery-menu.index')
            ->with('status', 'Gallery menu item updated.');
    }

    public function destroy(GalleryMenuItem $galleryMenuItem): RedirectResponse
    {
        $galleryMenuItem->delete();

        return redirect()
            ->route('admin.gallery-menu.index')
            ->with('status', 'Gallery menu item removed.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $data = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['required', 'integer', 'distinct', 'exists:gallery_menu_items,id'],
        ]);

        $submittedIds = collect($data['order'])
            ->map(static fn ($id): int => (int) $id)
            ->values();
        $currentIds = GalleryMenuItem::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->pluck('id')
            ->map(static fn ($id): int => (int) $id)
            ->values();

        abort_unless(
            $submittedIds->sort()->values()->all() === $currentIds->sort()->values()->all(),
            422,
            'The submitted order does not match the current Gallery menu items.'
        );

        DB::transaction(function () use ($submittedIds): void {
            foreach ($submittedIds as $position => $id) {
                GalleryMenuItem::query()
                    ->whereKey($id)
                    ->update(['sort_order' => ($position + 1) * 10]);
            }
        });

        return response()->json(['message' => 'Gallery menu order saved.']);
    }

    /** @return \Illuminate\Database\Eloquent\Collection<int, GalleryPage> */
    private function availablePages()
    {
        return GalleryPage::query()
            ->orderBy('name')
            ->orderBy('id')
            ->get(['id', 'name', 'slug', 'public_slug', 'is_active']);
    }

    /** @return list<int> */
    private function usedPageIds(?int $exceptMenuItemId = null): array
    {
        return GalleryMenuItem::query()
            ->when($exceptMenuItemId !== null, fn ($query) => $query->where('id', '<>', $exceptMenuItemId))
            ->pluck('gallery_page_id')
            ->map(static fn ($id): int => (int) $id)
            ->all();
    }
}
