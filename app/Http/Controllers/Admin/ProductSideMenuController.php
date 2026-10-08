<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSideMenuItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductSideMenuController extends Controller
{
    public function index(): View
    {
        return view('admin.side-menu-products.index', [
            'items' => ProductSideMenuItem::query()
                ->with('product:id,name,slug,status')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.side-menu-products.form', [
            'item' => new ProductSideMenuItem(),
            'products' => $this->availableProducts(),
            'usedProductIds' => $this->usedProductIds(),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
                Rule::unique('product_side_menu_items', 'product_id'),
            ],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:10240'],
        ]);

        ProductSideMenuItem::query()->create([
            'name' => trim($data['name']),
            'product_id' => $data['product_id'],
            'image_path' => $request->file('image')->store('side-menu/products', 'public'),
            'sort_order' => ((int) ProductSideMenuItem::query()->max('sort_order')) + 10,
        ]);

        return redirect()
            ->route('admin.side-menu.products.index')
            ->with('status', 'Product side menu item added.');
    }

    public function edit(ProductSideMenuItem $productSideMenuItem): View
    {
        return view('admin.side-menu-products.form', [
            'item' => $productSideMenuItem->load('product:id,name,slug,status'),
            'products' => $this->availableProducts(),
            'usedProductIds' => $this->usedProductIds((int) $productSideMenuItem->id),
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, ProductSideMenuItem $productSideMenuItem): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
                Rule::unique('product_side_menu_items', 'product_id')->ignore($productSideMenuItem->id),
            ],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:10240'],
        ]);

        $oldImagePath = $productSideMenuItem->image_path;
        $newImagePath = $request->file('image')?->store('side-menu/products', 'public');

        $productSideMenuItem->update([
            'name' => trim($data['name']),
            'product_id' => $data['product_id'],
            'image_path' => $newImagePath ?? $oldImagePath,
        ]);

        if ($newImagePath !== null && $oldImagePath !== '') {
            Storage::disk('public')->delete($oldImagePath);
        }

        return redirect()
            ->route('admin.side-menu.products.index')
            ->with('status', 'Product side menu item updated.');
    }

    public function destroy(ProductSideMenuItem $productSideMenuItem): RedirectResponse
    {
        $imagePath = $productSideMenuItem->image_path;
        $productSideMenuItem->delete();

        if ($imagePath !== '') {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()
            ->route('admin.side-menu.products.index')
            ->with('status', 'Product side menu item removed.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $data = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['required', 'integer', 'distinct', 'exists:product_side_menu_items,id'],
        ]);

        $submittedIds = collect($data['order'])->map(static fn ($id): int => (int) $id)->values();
        $currentIds = ProductSideMenuItem::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->pluck('id')
            ->map(static fn ($id): int => (int) $id)
            ->values();

        abort_unless(
            $submittedIds->sort()->values()->all() === $currentIds->sort()->values()->all(),
            422,
            'The submitted order does not match the current Product side menu items.'
        );

        DB::transaction(function () use ($submittedIds): void {
            foreach ($submittedIds as $position => $id) {
                ProductSideMenuItem::query()
                    ->whereKey($id)
                    ->update(['sort_order' => ($position + 1) * 10]);
            }
        });

        return response()->json(['message' => 'Product side menu order saved.']);
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
    private function usedProductIds(?int $exceptItemId = null): array
    {
        return ProductSideMenuItem::query()
            ->when($exceptItemId !== null, fn ($query) => $query->where('id', '<>', $exceptItemId))
            ->pluck('product_id')
            ->map(static fn ($id): int => (int) $id)
            ->all();
    }
}
