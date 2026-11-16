<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OptionGroup;
use App\Support\RichTextSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OptionGroupController extends Controller
{
    public function index(Request $request): View
    {
        $displayTypes = [
            'button' => 'Button',
            'button_group' => 'Button group',
            'image_card' => 'Image card',
            'image_grid' => 'Image grid',
            'paper_preview' => 'Paper preview',
            'previous_order' => 'Previous order',
            'radio_list' => 'Radio list',
            'switch' => 'Switch',
            'quantity_input' => 'Quantity input',
        ];

        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'display_type' => (string) $request->query('display_type', ''),
            'status' => (string) $request->query('status', ''),
        ];

        $optionGroups = OptionGroup::query()
            ->when($filters['q'] !== '', function ($query) use ($filters): void {
                $like = '%'.addcslashes($filters['q'], '%_\\').'%';

                $query->where(fn ($query) => $query->where('group_code', 'like', $like)->orWhere('group_name', 'like', $like));
            })
            ->when(array_key_exists($filters['display_type'], $displayTypes), fn ($query) => $query->where('display_type', $filters['display_type']))
            ->when($filters['status'] === 'active', fn ($query) => $query->where('is_active', true))
            ->when($filters['status'] === 'inactive', fn ($query) => $query->where('is_active', false))
            ->orderBy('group_name')
            ->paginate(30)
            ->withQueryString();

        return view('admin.option-groups.index', [
            'optionGroups' => $optionGroups,
            'filters' => $filters,
            'displayTypes' => $displayTypes,
        ]);
    }

    public function create(): View
    {
        return view('admin.option-groups.form', [
            'optionGroup' => new OptionGroup([
                'display_type' => 'button',
                'is_required' => true,
                'show_in_order_summary' => true,
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

    /** @return array<string, mixed> */
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
            'display_type' => ['required', Rule::in(['button', 'button_group', 'image_card', 'image_grid', 'paper_preview', 'previous_order', 'radio_list', 'switch', 'quantity_input'])],
            'help_text' => ['nullable', 'string', 'max:2000'],
            'description' => ['nullable', 'string', 'max:50000'],
            'remark_text' => ['nullable', 'string', 'max:2000'],
        ]);

        return [
            ...$data,
            'description' => (new RichTextSanitizer)->sanitize($data['description'] ?? null),
            'is_main_price_group' => $request->boolean('is_main_price_group'),
            'is_required' => $request->boolean('is_required'),
            'show_in_order_summary' => $request->boolean('show_in_order_summary'),
            'is_active' => $request->boolean('is_active'),
        ];
    }
}
