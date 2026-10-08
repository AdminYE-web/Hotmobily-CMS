<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomPage;
use App\Models\UserManualMenuItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserManualMenuController extends Controller
{
    public function index(): View
    {
        return view('admin.user-manual-menu.index', [
            'items' => UserManualMenuItem::query()
                ->with('customPage:id,name,slug,status')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.user-manual-menu.form', [
            'item' => new UserManualMenuItem(),
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
                Rule::unique('user_manual_menu_items', 'custom_page_id'),
            ],
        ]);

        UserManualMenuItem::query()->create([
            'name' => trim($data['name']),
            'custom_page_id' => $data['custom_page_id'],
            'sort_order' => ((int) UserManualMenuItem::query()->max('sort_order')) + 10,
        ]);

        return redirect()
            ->route('admin.user-manual-menu.index')
            ->with('status', 'User Manual menu item added.');
    }

    public function edit(UserManualMenuItem $userManualMenuItem): View
    {
        return view('admin.user-manual-menu.form', [
            'item' => $userManualMenuItem->load('customPage:id,name,slug,status'),
            'pages' => $this->availablePages(),
            'usedPageIds' => $this->usedPageIds((int) $userManualMenuItem->id),
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, UserManualMenuItem $userManualMenuItem): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'custom_page_id' => [
                'required',
                'integer',
                'exists:custom_pages,id',
                Rule::unique('user_manual_menu_items', 'custom_page_id')->ignore($userManualMenuItem->id),
            ],
        ]);

        $userManualMenuItem->update([
            'name' => trim($data['name']),
            'custom_page_id' => $data['custom_page_id'],
        ]);

        return redirect()
            ->route('admin.user-manual-menu.index')
            ->with('status', 'User Manual menu item updated.');
    }

    public function destroy(UserManualMenuItem $userManualMenuItem): RedirectResponse
    {
        $userManualMenuItem->delete();

        return redirect()
            ->route('admin.user-manual-menu.index')
            ->with('status', 'User Manual menu item removed.');
    }

    public function reorder(Request $request): JsonResponse
    {
        $data = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['required', 'integer', 'distinct', 'exists:user_manual_menu_items,id'],
        ]);

        $submittedIds = collect($data['order'])
            ->map(static fn ($id): int => (int) $id)
            ->values();
        $currentIds = UserManualMenuItem::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->pluck('id')
            ->map(static fn ($id): int => (int) $id)
            ->values();

        abort_unless(
            $submittedIds->sort()->values()->all() === $currentIds->sort()->values()->all(),
            422,
            'The submitted order does not match the current User Manual menu items.'
        );

        DB::transaction(function () use ($submittedIds): void {
            foreach ($submittedIds as $position => $id) {
                UserManualMenuItem::query()
                    ->whereKey($id)
                    ->update(['sort_order' => ($position + 1) * 10]);
            }
        });

        return response()->json(['message' => 'User Manual menu order saved.']);
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
        return UserManualMenuItem::query()
            ->when($exceptMenuItemId !== null, fn ($query) => $query->where('id', '<>', $exceptMenuItemId))
            ->pluck('custom_page_id')
            ->map(static fn ($id): int => (int) $id)
            ->all();
    }
}
