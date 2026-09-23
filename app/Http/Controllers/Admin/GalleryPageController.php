<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcrylicGallery;
use App\Models\GalleryPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class GalleryPageController extends Controller
{
    public function index(): View
    {
        $galleryPages = GalleryPage::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // Query counts by values instead of comparing the two table columns.
        // Legacy installations may use a different collation on
        // hm_acrylic_gallery.type until the alignment migration is run.
        $itemCounts = AcrylicGallery::query()
            ->whereIn('type', $galleryPages->pluck('gallery_type'))
            ->selectRaw('type, COUNT(*) AS item_count')
            ->groupBy('type')
            ->pluck('item_count', 'type');

        $galleryPages->each(function (GalleryPage $page) use ($itemCounts): void {
            $page->setAttribute('items_count', (int) ($itemCounts[$page->gallery_type] ?? 0));
        });

        return view('admin.gallery-pages.index', [
            'galleryPages' => $galleryPages,
        ]);
    }

    public function create(): View
    {
        return view('admin.gallery-pages.form', [
            'galleryPage' => new GalleryPage([
                'media_directory' => 'gallery/uploads',
                'legacy_extension' => 'webp',
                'heading' => '製作事例紹介',
                'show_website' => true,
                'show_tags' => true,
                'is_active' => true,
                'sort_order' => (int) GalleryPage::query()->max('sort_order') + 10,
            ]),
            'isEditing' => false,
            'hasItems' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $galleryPage = GalleryPage::create($this->validatedData($request));

        return redirect()
            ->route('admin.gallery-pages.index')
            ->with('status', "Gallery page {$galleryPage->name} was created.");
    }

    public function edit(GalleryPage $galleryPage): View
    {
        return view('admin.gallery-pages.form', [
            'galleryPage' => $galleryPage,
            'isEditing' => true,
            'hasItems' => $galleryPage->items()->exists(),
        ]);
    }

    public function update(Request $request, GalleryPage $galleryPage): RedirectResponse
    {
        $hasItems = $galleryPage->items()->exists();

        if ($hasItems) {
            $request->merge(['gallery_type' => $galleryPage->gallery_type]);
        }

        $data = $this->validatedData($request, $galleryPage);

        if ($hasItems) {
            $data['gallery_type'] = $galleryPage->gallery_type;
        }

        $galleryPage->update($data);

        return redirect()
            ->route('admin.gallery-pages.index')
            ->with('status', "Gallery page {$galleryPage->name} was updated.");
    }

    public function destroy(GalleryPage $galleryPage): RedirectResponse
    {
        if ($galleryPage->items()->exists()) {
            return redirect()
                ->route('admin.gallery-pages.index')
                ->with('error', 'This page has legacy gallery data. Deactivate it instead so the old data stays available.');
        }

        $name = $galleryPage->name;
        $galleryPage->delete();

        return redirect()
            ->route('admin.gallery-pages.index')
            ->with('status', "Empty gallery page {$name} was deleted. No legacy gallery rows were removed.");
    }

    /** @return array<string, mixed> */
    private function validatedData(Request $request, ?GalleryPage $galleryPage = null): array
    {
        $id = $galleryPage?->getKey();
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'heading' => ['nullable', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('gallery_pages', 'slug')->ignore($id),
            ],
            'public_slug' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-z0-9]+(?:[_-][a-z0-9]+)*$/',
                Rule::unique('gallery_pages', 'public_slug')->ignore($id),
            ],
            'gallery_type' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-z0-9]+(?:_[a-z0-9]+)*$/',
                Rule::unique('gallery_pages', 'gallery_type')->ignore($id),
            ],
            'media_directory' => [
                'required',
                'string',
                'max:255',
                'regex:/^gallery\/[A-Za-z0-9_.\/-]+$/',
            ],
            'legacy_extension' => ['nullable', 'string', 'max:10', 'regex:/^[A-Za-z0-9]+$/'],
            'sort_order' => ['required', 'integer', 'between:-100000,100000'],
            'description' => ['nullable', 'string', 'max:65535'],
            'show_website' => ['nullable', 'boolean'],
            'show_tags' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'slug.regex' => 'Admin slug may contain lowercase letters, numbers, and hyphens only.',
            'public_slug.regex' => 'Public slug may contain lowercase letters, numbers, underscores, and hyphens only.',
            'gallery_type.regex' => 'Database type may contain lowercase letters, numbers, and underscores only.',
            'media_directory.regex' => 'Image directory must be inside public/gallery, for example gallery/img-rubber.',
        ]);

        if (str_contains($data['media_directory'], '..')) {
            throw ValidationException::withMessages([
                'media_directory' => 'Image directory cannot contain .. path segments.',
            ]);
        }

        $data['show_website'] = $request->boolean('show_website');
        $data['show_tags'] = $request->has('show_tags')
            ? $request->boolean('show_tags')
            : true;
        $data['is_active'] = $request->boolean('is_active');
        $data['media_directory'] = trim($data['media_directory'], '/');
        $data['legacy_extension'] = strtolower((string) ($data['legacy_extension'] ?? '')) ?: null;

        return $data;
    }
}
