<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OptionGroup;
use App\Models\ProductOption;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductOptionController extends Controller
{
    public function index(): View
    {
        return view('admin.product-options.index', [
            'productOptions' => ProductOption::query()
                ->with('optionGroup:id,group_code,group_name')
                ->orderBy('option_group_id')
                ->orderBy('option_name')
                ->paginate(30),
        ]);
    }

    public function create(): View
    {
        return view('admin.product-options.form', [
            'productOption' => new ProductOption([
                'is_active' => true,
                'option_images' => [],
            ]),
            'optionGroups' => $this->optionGroups(),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $productOption = ProductOption::create($this->validatedData($request));

        return redirect()
            ->route('admin.product-options.index')
            ->with('status', "Product Option {$productOption->option_code} was created.");
    }

    public function edit(ProductOption $productOption): View
    {
        return view('admin.product-options.form', [
            'productOption' => $productOption,
            'optionGroups' => $this->optionGroups(),
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, ProductOption $productOption): RedirectResponse
    {
        $data = $this->validatedData($request, $productOption);
        $previousImages = collect($productOption->option_images ?? [])
            ->map(static fn ($image): string => basename((string) $image))
            ->filter()
            ->values()
            ->all();

        $productOption->update($data);

        $this->deleteStoredImages(array_values(array_diff($previousImages, $data['option_images'])));

        return redirect()
            ->route('admin.product-options.index')
            ->with('status', "Product Option {$productOption->option_code} was updated.");
    }

    /** @return \Illuminate\Support\Collection<int, OptionGroup> */
    private function optionGroups()
    {
        return OptionGroup::query()
            ->where('is_active', true)
            ->orderBy('group_name')
            ->get(['id', 'group_code', 'group_name']);
    }

    /** @return array<string, mixed> */
    private function validatedData(Request $request, ?ProductOption $productOption = null): array
    {
        $data = $request->validate([
            'option_group_id' => ['required', 'integer', 'exists:option_groups,id'],
            'option_code' => [
                'required',
                'string',
                'alpha_dash:ascii',
                'max:100',
                Rule::unique('product_options', 'option_code')
                    ->where('option_group_id', $request->integer('option_group_id'))
                    ->ignore($productOption),
            ],
            'option_name' => ['required', 'string', 'max:255'],
            'color_code' => ['nullable', 'string', 'max:20', 'regex:/^#[0-9A-Fa-f]{3}([0-9A-Fa-f]{3})?$/'],
            'option_detail' => ['nullable', 'string', 'max:10000'],
            'option_images' => ['nullable', 'array'],
            'option_images.*' => ['image', 'max:5120'],
            'remove_images' => ['nullable', 'array'],
            'remove_images.*' => ['string', 'max:255'],
        ]);

        $imagesToRemove = collect($data['remove_images'] ?? [])
            ->map(static fn ($image): string => basename((string) $image))
            ->filter()
            ->unique()
            ->all();

        $currentImages = collect($productOption?->option_images ?? [])
            ->map(static fn ($image): string => basename((string) $image))
            ->filter()
            ->reject(static fn (string $image): bool => in_array($image, $imagesToRemove, true))
            ->values()
            ->all();

        unset($data['option_images'], $data['remove_images']);

        return [
            ...$data,
            'option_images' => [
                ...$currentImages,
                ...$this->storeImages($request),
            ],
            'is_active' => $request->boolean('is_active'),
        ];
    }

    /** @return list<string> */
    private function storeImages(Request $request): array
    {
        $files = $request->file('option_images', []);

        if ($files === [] || $files === null) {
            return [];
        }

        $directory = public_path('product-options');
        File::ensureDirectoryExists($directory);

        $names = [];

        foreach ($files as $file) {
            if ($file === null || ! $file->isValid()) {
                continue;
            }

            $name = Str::uuid()->toString().'.'.$file->extension();
            $file->move($directory, $name);
            $names[] = $name;
        }

        return $names;
    }

    /** @param list<string> $images */
    private function deleteStoredImages(array $images): void
    {
        foreach ($images as $image) {
            $filename = basename($image);

            if ($filename === '') {
                continue;
            }

            $path = public_path('product-options'.DIRECTORY_SEPARATOR.$filename);

            if (File::isFile($path)) {
                File::delete($path);
            }
        }
    }
}
