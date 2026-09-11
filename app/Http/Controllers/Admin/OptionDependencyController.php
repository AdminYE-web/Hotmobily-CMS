<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OptionDependency;
use App\Models\OptionGroup;
use App\Models\ProductOption;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OptionDependencyController extends Controller
{
    public function index(): View
    {
        return view('admin.option-dependencies.index', [
            'dependencies' => OptionDependency::query()
                ->with([
                    'triggerOption.optionGroup:id,group_code,group_name',
                    'targetOption.optionGroup:id,group_code,group_name',
                    'targetGroup:id,group_code,group_name',
                ])
                ->latest('id')
                ->paginate(30),
        ]);
    }

    public function create(): View
    {
        return view('admin.option-dependencies.form', [
            'dependency' => new OptionDependency([
                'target_type' => 'option',
                'action_type' => 'show',
                'is_active' => true,
            ]),
            ...$this->selectionData(),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $dependency = OptionDependency::create($this->validatedData($request));

        return redirect()
            ->route('admin.option-dependencies.index')
            ->with('status', 'Option Dependency was created.');
    }

    public function edit(OptionDependency $optionDependency): View
    {
        return view('admin.option-dependencies.form', [
            'dependency' => $optionDependency,
            ...$this->selectionData(),
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, OptionDependency $optionDependency): RedirectResponse
    {
        $optionDependency->update($this->validatedData($request));

        return redirect()
            ->route('admin.option-dependencies.index')
            ->with('status', 'Option Dependency was updated.');
    }

    /** @return array{productOptions: \Illuminate\Support\Collection<int, ProductOption>, optionGroups: \Illuminate\Support\Collection<int, OptionGroup>} */
    private function selectionData(): array
    {
        return [
            'productOptions' => ProductOption::query()
                ->with('optionGroup:id,group_code,group_name')
                ->orderBy('option_group_id')
                ->orderBy('option_name')
                ->get(),
            'optionGroups' => OptionGroup::query()
                ->orderBy('group_name')
                ->get(['id', 'group_code', 'group_name', 'is_active']),
        ];
    }

    /** @return array<string, mixed> */
    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'trigger_product_option_id' => ['required', 'integer', 'exists:product_options,id'],
            'target_type' => ['required', Rule::in(['option', 'group'])],
            'target_id' => ['required', 'integer'],
            'action_type' => ['required', Rule::in(['show', 'hide', 'lock', 'disable'])],
        ]);

        $targetIsOption = $data['target_type'] === 'option';
        $targetExists = $targetIsOption
            ? ProductOption::query()->whereKey($data['target_id'])->exists()
            : OptionGroup::query()->whereKey($data['target_id'])->exists();

        if (! $targetExists) {
            throw ValidationException::withMessages([
                'target_id' => 'Select a valid target for the chosen Target Type.',
            ]);
        }

        if ($targetIsOption && (int) $data['target_id'] === (int) $data['trigger_product_option_id']) {
            throw ValidationException::withMessages([
                'target_id' => 'Trigger Option and Target Option cannot be the same Option.',
            ]);
        }

        return [
            'trigger_product_option_id' => $data['trigger_product_option_id'],
            'target_type' => $data['target_type'],
            'target_product_option_id' => $targetIsOption ? $data['target_id'] : null,
            'target_option_group_id' => $targetIsOption ? null : $data['target_id'],
            'action_type' => $data['action_type'],
            'is_active' => $request->boolean('is_active'),
        ];
    }
}
