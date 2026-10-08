<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SideMenuLinkItem;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SideMenuLinkController extends Controller
{
    public function index(): View
    {
        return view('admin.side-menu-links.index', [
            'items' => SideMenuLinkItem::query()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.side-menu-links.form', [
            'item' => new SideMenuLinkItem(),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:2048', $this->validLink()],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:10240'],
        ]);

        SideMenuLinkItem::query()->create([
            'name' => trim($data['name']),
            'url' => trim($data['url']),
            'image_path' => $request->file('image')->store('side-menu/links', 'public'),
            'sort_order' => ((int) SideMenuLinkItem::query()->max('sort_order')) + 10,
        ]);

        return redirect()
            ->route('admin.side-menu.links.index')
            ->with('status', 'Side menu link added.');
    }

    public function edit(SideMenuLinkItem $sideMenuLink): View
    {
        return view('admin.side-menu-links.form', [
            'item' => $sideMenuLink,
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, SideMenuLinkItem $sideMenuLink): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'url' => ['required', 'string', 'max:2048', $this->validLink()],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:10240'],
        ]);

        $oldImagePath = $sideMenuLink->image_path;
        $newImagePath = $request->file('image')?->store('side-menu/links', 'public');

        $sideMenuLink->update([
            'name' => trim($data['name']),
            'url' => trim($data['url']),
            'image_path' => $newImagePath ?? $oldImagePath,
        ]);

        if ($newImagePath !== null) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return redirect()
            ->route('admin.side-menu.links.index')
            ->with('status', 'Side menu link updated.');
    }

    public function destroy(SideMenuLinkItem $sideMenuLink): RedirectResponse
    {
        $imagePath = $sideMenuLink->image_path;
        $sideMenuLink->delete();
        Storage::disk('public')->delete($imagePath);

        return redirect()
            ->route('admin.side-menu.links.index')
            ->with('status', 'Side menu link removed.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $data = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['required', 'integer', 'distinct', 'exists:side_menu_link_items,id'],
        ]);

        $submittedIds = collect($data['order'])->map(static fn ($id): int => (int) $id)->values();
        $currentIds = SideMenuLinkItem::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->pluck('id')
            ->map(static fn ($id): int => (int) $id)
            ->values();

        abort_unless(
            $submittedIds->sort()->values()->all() === $currentIds->sort()->values()->all(),
            422,
            'The submitted order does not match the current Side Menu links.'
        );

        DB::transaction(function () use ($submittedIds): void {
            foreach ($submittedIds as $position => $id) {
                SideMenuLinkItem::query()
                    ->whereKey($id)
                    ->update(['sort_order' => ($position + 1) * 10]);
            }
        });

        return response()->json(['message' => 'Side menu link order saved.']);
    }

    private function validLink(): Closure
    {
        return static function (string $attribute, mixed $value, Closure $fail): void {
            if (is_string($value)
                && str_starts_with($value, '/')
                && ! str_starts_with($value, '//')) {
                return;
            }

            $scheme = is_string($value) ? strtolower((string) parse_url($value, PHP_URL_SCHEME)) : '';
            if (! is_string($value)
                || ! filter_var($value, FILTER_VALIDATE_URL)
                || ! in_array($scheme, ['http', 'https'], true)) {
                $fail('The link must be a site path such as /meeting_date/ or a valid http(s) URL.');
            }
        };
    }
}
