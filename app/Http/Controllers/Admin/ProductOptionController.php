<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OptionGroup;
use App\Models\ProductOption;
use App\Support\RichTextSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductOptionController extends Controller
{
    public function index(Request $request): View
    {
        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'group' => (string) $request->query('group', ''),
            'status' => (string) $request->query('status', ''),
            'disabled' => (string) $request->query('disabled', ''),
        ];

        $productOptions = ProductOption::query()
            ->with('optionGroup:id,group_code,group_name')
            ->when($filters['q'] !== '', function ($query) use ($filters): void {
                $like = '%'.addcslashes($filters['q'], '%_\\').'%';

                $query->where(fn ($query) => $query->where('option_code', 'like', $like)->orWhere('option_name', 'like', $like));
            })
            ->when(ctype_digit($filters['group']), fn ($query) => $query->where('option_group_id', (int) $filters['group']))
            ->when($filters['status'] === 'active', fn ($query) => $query->where('is_active', true))
            ->when($filters['status'] === 'inactive', fn ($query) => $query->where('is_active', false))
            ->when($filters['disabled'] === 'yes', fn ($query) => $query->where('is_disabled', true))
            ->when($filters['disabled'] === 'no', fn ($query) => $query->where('is_disabled', false))
            ->orderBy('option_group_id')
            ->orderBy('option_name')
            ->paginate(30)
            ->withQueryString();

        return view('admin.product-options.index', [
            'productOptions' => $productOptions,
            'optionGroups' => $this->optionGroups(),
            'filterGroups' => OptionGroup::query()->orderBy('group_name')->get(['id', 'group_code', 'group_name']),
            'filters' => $filters,
        ]);
    }

    public function bulkUpload(Request $request): JsonResponse
    {
        $data = $request->validate([
            'option_group_id' => ['required', 'integer', Rule::exists('option_groups', 'id')->where('is_active', true)],
            'upload_id' => ['required', 'uuid'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,webp,bmp', 'max:5120'],
        ]);
        $file = $request->file('image');
        $stem = trim(preg_replace('/[\x00-\x1f\x7f]/u', '', pathinfo(basename(str_replace('\\', '/', $file->getClientOriginalName())), PATHINFO_FILENAME)) ?? '');
        if ($stem === '') {
            throw \Illuminate\Validation\ValidationException::withMessages(['image' => 'The image must have a filename before its extension.']);
        }
        $storedName = null;
        try {
            [$option, $created] = DB::transaction(function () use ($data, $file, $stem, &$storedName): array {
                // Serialize bulk uploads to a group while choosing a unique filename-based code.
                OptionGroup::whereKey($data['option_group_id'])->lockForUpdate()->firstOrFail();
                $existing = ProductOption::where('bulk_upload_key', $data['upload_id'])->first();
                if ($existing) {
                    abort_if((int) $existing->option_group_id !== (int) $data['option_group_id'], 409, 'This upload was already used for another Option Group.');
                    return [$existing, false];
                }
                $base = Str::substr($stem, 0, 100);
                $code = $base;
                for ($suffix = 2; ProductOption::where('option_group_id', $data['option_group_id'])->where('option_code', $code)->exists(); $suffix++) {
                    $ending = '_'.$suffix;
                    $code = Str::substr($base, 0, 100 - strlen($ending)).$ending;
                }
                $directory = public_path('product-options');
                File::ensureDirectoryExists($directory);
                $storedName = Str::uuid()->toString().'.'.$file->extension();
                $file->move($directory, $storedName);
                $option = new ProductOption([
                    'option_group_id' => $data['option_group_id'], 'option_code' => $code,
                    'option_name' => Str::substr($stem, 0, 255), 'option_images' => [$storedName],
                    'is_active' => true, 'is_disabled' => false,
                ]);
                $option->bulk_upload_key = $data['upload_id'];
                $option->save();
                return [$option, true];
            });
        } catch (\Throwable $error) {
            if ($storedName !== null) $this->deleteStoredImages([$storedName]);
            throw $error;
        }
        return response()->json(['data' => [
            'id' => $option->id, 'option_name' => $option->option_name, 'option_code' => $option->option_code,
            'edit_url' => route('admin.product-options.edit', $option), 'created' => $created,
        ]], $created ? 201 : 200);
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

    public function destroy(ProductOption $productOption): RedirectResponse
    {
        $references = [
            'product_option_group_items' => ['product_option_id', 'price_summary_option_id', 'confirm_price_summary_option_id', 'complete_price_summary_option_id'],
            'product_option_groups' => ['price_summary_option_id', 'confirm_price_summary_option_id', 'complete_price_summary_option_id'],
            'option_dependencies' => ['trigger_product_option_id', 'target_product_option_id'],
            'option_price_rules' => ['target_product_option_id'],
            'option_price_rule_conditions' => ['product_option_id'],
            'product_price_rule_conditions' => ['product_option_id'],
        ];

        foreach ($references as $table => $columns) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            foreach ($columns as $column) {
                if (Schema::hasColumn($table, $column) && DB::table($table)->where($column, $productOption->id)->exists()) {
                    return redirect()->route('admin.product-options.index')
                        ->with('error', 'Cannot delete this option because it is used by a product, dependency, or price rule. Remove those references first.');
                }
            }
        }

        $images = $productOption->option_images ?? [];
        $optionCode = $productOption->option_code;
        $productOption->delete();
        $this->deleteStoredImages($images);

        return redirect()->route('admin.product-options.index')
            ->with('status', "Product Option {$optionCode} was deleted.");
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
                'not_regex:/[\x00-\x1f\x7f]/u',
                'max:100',
                Rule::unique('product_options', 'option_code')
                    ->where('option_group_id', $request->integer('option_group_id'))
                    ->ignore($productOption),
            ],
            'option_name' => ['required', 'string', 'max:255'],
            'color_code' => ['nullable', 'string', 'max:20', 'regex:/^#[0-9A-Fa-f]{3}([0-9A-Fa-f]{3})?$/'],
            'option_detail' => ['nullable', 'string', 'max:10000'],
            'disable_text' => ['nullable', 'string', 'max:10000'],
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

        $data['disable_text'] = (new RichTextSanitizer())->sanitize($data['disable_text'] ?? null);

        return [
            ...$data,
            'option_images' => [
                ...$currentImages,
                ...$this->storeImages($request),
            ],
            'is_disabled' => $request->boolean('is_disabled'),
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
