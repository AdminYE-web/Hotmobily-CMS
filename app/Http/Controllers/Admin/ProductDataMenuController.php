<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductDataMenuItem;
use App\Models\ProductDataPage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductDataMenuController extends Controller
{
    public function index(): View
    {
        $items = ProductDataMenuItem::query()
            ->with('productDataPage:id,name,slug,status')
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.product-data-menu.index', [
            'items' => $items,
        ]);
    }

    public function create(): View
    {
        return view('admin.product-data-menu.form', [
            'item' => new ProductDataMenuItem(),
            'pages' => $this->availablePages(),
            'usedPageIds' => $this->usedPageIds(),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'product_data_page_id' => [
                'required',
                'integer',
                'exists:product_data_pages,id',
                Rule::unique('product_data_menu_items', 'product_data_page_id'),
            ],
        ]);

        $nextOrder = ((int) ProductDataMenuItem::query()->max('sort_order')) + 1;

        ProductDataMenuItem::query()->create([
            'name' => trim($data['name']),
            'product_data_page_id' => $data['product_data_page_id'],
            'sort_order' => $nextOrder,
        ]);

        return redirect()
            ->route('admin.product-data-menu.index')
            ->with('status', 'Product Data menu item added.');
    }

    public function edit(ProductDataMenuItem $productDataMenuItem): View
    {
        return view('admin.product-data-menu.form', [
            'item' => $productDataMenuItem->load('productDataPage:id,name,slug,status'),
            'pages' => $this->availablePages(),
            'usedPageIds' => $this->usedPageIds((int) $productDataMenuItem->id),
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, ProductDataMenuItem $productDataMenuItem): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'product_data_page_id' => [
                'required',
                'integer',
                'exists:product_data_pages,id',
                Rule::unique('product_data_menu_items', 'product_data_page_id')
                    ->ignore($productDataMenuItem->id),
            ],
        ]);

        $productDataMenuItem->update([
            'name' => trim($data['name']),
            'product_data_page_id' => $data['product_data_page_id'],
        ]);

        return redirect()
            ->route('admin.product-data-menu.index')
            ->with('status', 'Product Data menu item updated.');
    }

    public function destroy(ProductDataMenuItem $productDataMenuItem): RedirectResponse
    {
        $productDataMenuItem->delete();

        return redirect()
            ->route('admin.product-data-menu.index')
            ->with('status', 'Product Data menu item removed.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $data = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['required', 'integer', 'distinct', 'exists:product_data_menu_items,id'],
        ]);

        $submittedIds = collect($data['order'])
            ->map(static fn ($id): int => (int) $id)
            ->values();
        $currentIds = ProductDataMenuItem::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->pluck('id')
            ->map(static fn ($id): int => (int) $id)
            ->values();

        abort_unless(
            $submittedIds->sort()->values()->all() === $currentIds->sort()->values()->all(),
            422,
            'The submitted order does not match the current menu items.'
        );

        DB::transaction(function () use ($submittedIds): void {
            foreach ($submittedIds as $position => $id) {
                ProductDataMenuItem::query()
                    ->whereKey($id)
                    ->update(['sort_order' => $position + 1]);
            }
        });

        return response()->json([
            'message' => 'Menu order saved.',
        ]);
    }

    /** @return \Illuminate\Database\Eloquent\Collection<int, ProductDataPage> */
    private function availablePages()
    {
        return ProductDataPage::query()
            ->orderBy('name')
            ->orderBy('id')
            ->get(['id', 'name', 'slug', 'status']);
    }

    /** @return list<int> */
    private function usedPageIds(?int $exceptMenuItemId = null): array
    {
        return ProductDataMenuItem::query()
            ->when($exceptMenuItemId !== null, fn ($query) => $query->where('id', '<>', $exceptMenuItemId))
            ->pluck('product_data_page_id')
            ->map(static fn ($id): int => (int) $id)
            ->all();
    }
}
