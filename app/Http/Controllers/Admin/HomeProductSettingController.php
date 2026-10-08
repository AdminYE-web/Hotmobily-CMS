<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeProductCard;
use App\Models\Product;
use App\Support\RichTextSanitizer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class HomeProductSettingController extends Controller
{
    public function index(): View
    {
        return view('admin.home-settings.products.index', [
            'items' => HomeProductCard::query()
                ->with('product:id,name,slug,status')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.home-settings.products.form', [
            'item' => new HomeProductCard(),
            'products' => $this->availableProducts(),
            'usedProductIds' => $this->usedProductIds(),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request, RichTextSanitizer $sanitizer): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
                Rule::unique('home_product_cards', 'product_id'),
            ],
            'name' => ['required', 'string', 'max:255'],
            'description_html' => ['nullable', 'string', 'max:20000'],
            'features_html' => ['nullable', 'string', 'max:20000'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:10240'],
        ]);

        HomeProductCard::query()->create([
            'product_id' => $data['product_id'],
            'name' => trim($data['name']),
            'description_html' => $sanitizer->sanitize($data['description_html'] ?? ''),
            'features_html' => $sanitizer->sanitize($data['features_html'] ?? ''),
            'image_path' => $request->file('image')->store('home/products', 'public'),
            'sort_order' => ((int) HomeProductCard::query()->max('sort_order')) + 10,
        ]);

        return redirect()
            ->route('admin.home-settings.products.index')
            ->with('status', 'Home Product card added.');
    }

    public function edit(HomeProductCard $homeProductCard): View
    {
        return view('admin.home-settings.products.form', [
            'item' => $homeProductCard->load('product:id,name,slug,status'),
            'products' => $this->availableProducts(),
            'usedProductIds' => $this->usedProductIds((int) $homeProductCard->id),
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, HomeProductCard $homeProductCard, RichTextSanitizer $sanitizer): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
                Rule::unique('home_product_cards', 'product_id')->ignore($homeProductCard->id),
            ],
            'name' => ['required', 'string', 'max:255'],
            'description_html' => ['nullable', 'string', 'max:20000'],
            'features_html' => ['nullable', 'string', 'max:20000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:10240'],
        ]);

        $oldImagePath = $homeProductCard->image_path;
        $newImagePath = $request->file('image')?->store('home/products', 'public');

        $homeProductCard->update([
            'product_id' => $data['product_id'],
            'name' => trim($data['name']),
            'description_html' => $sanitizer->sanitize($data['description_html'] ?? ''),
            'features_html' => $sanitizer->sanitize($data['features_html'] ?? ''),
            'image_path' => $newImagePath ?? $oldImagePath,
        ]);

        if ($newImagePath !== null) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return redirect()
            ->route('admin.home-settings.products.index')
            ->with('status', 'Home Product card updated.');
    }

    public function destroy(HomeProductCard $homeProductCard): RedirectResponse
    {
        $imagePath = $homeProductCard->image_path;
        $homeProductCard->delete();
        Storage::disk('public')->delete($imagePath);

        return redirect()
            ->route('admin.home-settings.products.index')
            ->with('status', 'Home Product card removed.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $data = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['required', 'integer', 'distinct', 'exists:home_product_cards,id'],
        ]);

        $submittedIds = collect($data['order'])->map(static fn ($id): int => (int) $id)->values();
        $currentIds = HomeProductCard::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->pluck('id')
            ->map(static fn ($id): int => (int) $id)
            ->values();

        abort_unless(
            $submittedIds->sort()->values()->all() === $currentIds->sort()->values()->all(),
            422,
            'The submitted order does not match the current Home Product cards.'
        );

        DB::transaction(function () use ($submittedIds): void {
            foreach ($submittedIds as $position => $id) {
                HomeProductCard::query()
                    ->whereKey($id)
                    ->update(['sort_order' => ($position + 1) * 10]);
            }
        });

        return response()->json(['message' => 'Home Product card order saved.']);
    }

    /** @return \Illuminate\Database\Eloquent\Collection<int, Product> */
    private function availableProducts()
    {
        return Product::query()
            ->orderBy('name')
            ->orderBy('id')
            ->get(['id', 'name', 'slug', 'status']);
    }

    /** @return list<int> */
    private function usedProductIds(?int $exceptCardId = null): array
    {
        return HomeProductCard::query()
            ->when($exceptCardId !== null, fn ($query) => $query->where('id', '<>', $exceptCardId))
            ->pluck('product_id')
            ->map(static fn ($id): int => (int) $id)
            ->all();
    }
}
