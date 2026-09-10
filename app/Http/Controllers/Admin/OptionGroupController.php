<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OptionGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OptionGroupController extends Controller
{
    public function index(): View
    {
        return view('admin.option-groups.index', [
            'optionGroups' => OptionGroup::query()
                ->orderBy('group_name')
                ->paginate(30),
        ]);
    }

    public function create(): View
    {
        return view('admin.option-groups.form', [
            'optionGroup' => new OptionGroup([
                'display_type' => 'button',
                'is_active' => true,
            ]),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $optionGroup = OptionGroup::create($this->validatedData($request));

        return redirect()
            ->route('admin.option-groups.index')
            ->with('status', "Option Group {$optionGroup->group_code} was created.");
    }

    public function edit(OptionGroup $optionGroup): View
    {
        return view('admin.option-groups.form', compact('optionGroup') + [
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, OptionGroup $optionGroup): RedirectResponse
    {
        $optionGroup->update($this->validatedData($request, $optionGroup));

        return redirect()
            ->route('admin.option-groups.index')
            ->with('status', "Option Group {$optionGroup->group_code} was updated.");
    }

    /** @return array{group_code: string, group_name: string, display_type: string, help_text: string|null, is_main_price_group: bool, is_required: bool, is_active: bool} */
    private function validatedData(Request $request, ?OptionGroup $optionGroup = null): array
    {
        $data = $request->validate([
            'group_code' => [
                'required',
                'string',
                'alpha_dash:ascii',
                'max:100',
                Rule::unique('option_groups', 'group_code')->ignore($optionGroup),
            ],
            'group_name' => ['required', 'string', 'max:255'],
            'display_type' => ['required', Rule::in(['button', 'image_card'])],
            'help_text' => ['nullable', 'string', 'max:2000'],
        ]);

        return [
            ...$data,
            'is_main_price_group' => $request->boolean('is_main_price_group'),
            'is_required' => $request->boolean('is_required'),
            'is_active' => $request->boolean('is_active'),
        ];
    }
}
