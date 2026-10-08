<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomPage;
use App\Models\CustomPageMenuItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CustomPageMenuController extends Controller
{
    public function index(): View
    {
        return view('admin.custom-page-menu.index', [
            'items' => CustomPageMenuItem::query()
                ->with('customPage:id,name,slug,status')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.custom-page-menu.form', [
            'item' => new CustomPageMenuItem(),
            'pages' => $this->availablePages(),
            'usedPageIds' => $this->usedPageIds(),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'custom_page_id' => [
                'required',
                'integer',
                'exists:custom_pages,id',
                Rule::unique('custom_page_menu_items', 'custom_page_id'),
            ],
        ]);

        CustomPageMenuItem::query()->create([
            'name' => trim($data['name']),
            'custom_page_id' => $data['custom_page_id'],
            'sort_order' => ((int) CustomPageMenuItem::query()->max('sort_order')) + 10,
        ]);

        return redirect()
            ->route('admin.custom-page-menu.index')
            ->with('status', 'Production Details menu item added.');
    }

    public function edit(CustomPageMenuItem $customPageMenuItem): View
    {
        return view('admin.custom-page-menu.form', [
            'item' => $customPageMenuItem->load('customPage:id,name,slug,status'),
            'pages' => $this->availablePages(),
            'usedPageIds' => $this->usedPageIds((int) $customPageMenuItem->id),
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, CustomPageMenuItem $customPageMenuItem): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'custom_page_id' => [
                'required',
                'integer',
                'exists:custom_pages,id',
                Rule::unique('custom_page_menu_items', 'custom_page_id')->ignore($customPageMenuItem->id),
            ],
        ]);

        $customPageMenuItem->update([
            'name' => trim($data['name']),
            'custom_page_id' => $data['custom_page_id'],
        ]);

        return redirect()
            ->route('admin.custom-page-menu.index')
            ->with('status', 'Production Details menu item updated.');
    }

    public function destroy(CustomPageMenuItem $customPageMenuItem): RedirectResponse
    {
        $customPageMenuItem->delete();

        return redirect()
            ->route('admin.custom-page-menu.index')
            ->with('status', 'Production Details menu item removed.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $data = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['required', 'integer', 'distinct', 'exists:custom_page_menu_items,id'],
        ]);

        $submittedIds = collect($data['order'])
            ->map(static fn ($id): int => (int) $id)
            ->values();
        $currentIds = CustomPageMenuItem::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->pluck('id')
            ->map(static fn ($id): int => (int) $id)
            ->values();

        abort_unless(
            $submittedIds->sort()->values()->all() === $currentIds->sort()->values()->all(),
            422,
            'The submitted order does not match the current Production Details menu items.'
        );

        DB::transaction(function () use ($submittedIds): void {
            foreach ($submittedIds as $position => $id) {
                CustomPageMenuItem::query()
                    ->whereKey($id)
                    ->update(['sort_order' => ($position + 1) * 10]);
            }
        });

        return response()->json(['message' => 'Production Details menu order saved.']);
    }

    /** @return \Illuminate\Database\Eloquent\Collection<int, CustomPage> */
    private function availablePages()
    {
        return CustomPage::query()
            ->orderBy('name')
            ->orderBy('id')
            ->get(['id', 'name', 'slug', 'status']);
    }

    /** @return list<int> */
    private function usedPageIds(?int $exceptMenuItemId = null): array
    {
        return CustomPageMenuItem::query()
            ->when($exceptMenuItemId !== null, fn ($query) => $query->where('id', '<>', $exceptMenuItemId))
            ->pluck('custom_page_id')
            ->map(static fn ($id): int => (int) $id)
            ->all();
    }
}
