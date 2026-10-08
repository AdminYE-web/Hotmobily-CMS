<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomeBannerSettingController extends Controller
{
    public function index(): View
    {
        return view('admin.home-settings.banners.index', [
            'items' => HomeBanner::query()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.home-settings.banners.form', [
            'item' => new HomeBanner(),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules(true));
        $data['image_path'] = $request->file('image')->store('home/banners', 'public');
        $data['mobile_image_path'] = $request->file('mobile_image')?->store('home/banners', 'public');
        $data['alt_text'] = $this->cleanAltText($data['alt_text'] ?? null);
        $data['link_url'] = $this->cleanLink($data['link_url'] ?? null);
        $data['sort_order'] = ((int) HomeBanner::query()->max('sort_order')) + 10;
        $data['is_active'] = $request->boolean('is_active');

        HomeBanner::query()->create($data);

        return redirect()
            ->route('admin.home-settings.banners.index')
            ->with('status', 'Home Banner added.');
    }

    public function edit(HomeBanner $homeBanner): View
    {
        return view('admin.home-settings.banners.form', [
            'item' => $homeBanner,
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, HomeBanner $homeBanner): RedirectResponse
    {
        $data = $request->validate($this->rules(false));
        $oldImagePath = $homeBanner->image_path;
        $oldMobileImagePath = $homeBanner->mobile_image_path;
        $newImagePath = $request->file('image')?->store('home/banners', 'public');
        $newMobileImagePath = $request->file('mobile_image')?->store('home/banners', 'public');
        $removeMobileImage = $request->boolean('remove_mobile_image');

        $homeBanner->update([
            'image_path' => $newImagePath ?? $oldImagePath,
            'mobile_image_path' => $newMobileImagePath ?? ($removeMobileImage ? null : $oldMobileImagePath),
            'alt_text' => $this->cleanAltText($data['alt_text'] ?? null),
            'link_url' => $this->cleanLink($data['link_url'] ?? null),
            'is_active' => $request->boolean('is_active'),
        ]);

        if ($newImagePath !== null) {
            $this->deleteUploadedImage($oldImagePath);
        }

        if ($newMobileImagePath !== null || $removeMobileImage) {
            $this->deleteUploadedImage($oldMobileImagePath);
        }

        return redirect()
            ->route('admin.home-settings.banners.index')
            ->with('status', 'Home Banner updated.');
    }

    public function destroy(HomeBanner $homeBanner): RedirectResponse
    {
        $imagePath = $homeBanner->image_path;
        $mobileImagePath = $homeBanner->mobile_image_path;
        $homeBanner->delete();
        $this->deleteUploadedImage($imagePath);
        $this->deleteUploadedImage($mobileImagePath);

        return redirect()
            ->route('admin.home-settings.banners.index')
            ->with('status', 'Home Banner removed.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $data = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['required', 'integer', 'distinct', 'exists:home_banners,id'],
        ]);

        $submittedIds = collect($data['order'])->map(static fn ($id): int => (int) $id)->values();
        $currentIds = HomeBanner::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->pluck('id')
            ->map(static fn ($id): int => (int) $id)
            ->values();

        abort_unless(
            $submittedIds->sort()->values()->all() === $currentIds->sort()->values()->all(),
            422,
            'The submitted order does not match the current Home Banners.'
        );

        DB::transaction(function () use ($submittedIds): void {
            foreach ($submittedIds as $position => $id) {
                HomeBanner::query()
                    ->whereKey($id)
                    ->update(['sort_order' => ($position + 1) * 10]);
            }
        });

        return response()->json(['message' => 'Home Banner order saved.']);
    }

    /** @return array<string, mixed> */
    private function rules(bool $imageRequired): array
    {
        return [
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:20480'],
            'mobile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:20480'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'remove_mobile_image' => ['nullable', 'boolean'],
            'link_url' => [
                'nullable',
                'string',
                'max:2048',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (! is_string($value) || trim($value) === '') {
                        return;
                    }

                    $value = trim($value);
                    if (str_starts_with($value, '/') && ! str_starts_with($value, '//')) {
                        return;
                    }

                    $parts = parse_url($value);
                    if (! is_array($parts)
                        || ! in_array(strtolower((string) ($parts['scheme'] ?? '')), ['http', 'https'], true)
                        || empty($parts['host'])) {
                        $fail('Link must be an internal path or an http/https URL.');
                    }
                },
            ],
        ];
    }

    private function cleanLink(?string $value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    private function cleanAltText(?string $value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }

    private function deleteUploadedImage(?string $path): void
    {
        if ($path !== null && str_starts_with($path, 'home/banners/')) {
            Storage::disk('public')->delete($path);
        }
    }
}
