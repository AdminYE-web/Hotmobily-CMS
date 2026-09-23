<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TemplateBlock;
use App\Models\TemplateDownload;
use App\Models\TemplateProduct;
use App\Models\TemplateRow;
use App\Support\LegacyTemplateImporter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class TemplateProductController extends Controller
{
    public function index(): View
    {
        return view('admin.template-products.index', [
            'templateProducts' => TemplateProduct::query()
                ->withCount(['blocks'])
                ->withCount(['blocks as rows_count' => fn ($query) => $query
                    ->join('template_rows', 'template_blocks.id', '=', 'template_rows.template_block_id')])
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.template-products.form', [
            'templateProduct' => new TemplateProduct([
                'is_active' => true,
                'sort_order' => ((int) TemplateProduct::query()->max('sort_order')) + 10,
            ]),
            'isEditing' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $product = new TemplateProduct;
        $this->saveProduct($request, $product);

        return redirect()
            ->route('admin.template-products.index')
            ->with('status', "Template product {$product->name} was created.");
    }

    public function edit(TemplateProduct $templateProduct): View
    {
        $templateProduct->load('blocks.rows.downloads');

        return view('admin.template-products.form', [
            'templateProduct' => $templateProduct,
            'isEditing' => true,
        ]);
    }

    public function update(Request $request, TemplateProduct $templateProduct): RedirectResponse
    {
        $this->saveProduct($request, $templateProduct);

        return redirect()
            ->route('admin.template-products.index')
            ->with('status', "Template product {$templateProduct->name} was updated.");
    }

    public function destroy(TemplateProduct $templateProduct): RedirectResponse
    {
        $templateProduct->load('blocks.rows.downloads');
        $paths = $this->productManagedPaths($templateProduct);
        $name = $templateProduct->name;
        $templateProduct->delete();
        $this->deleteManagedFiles($paths);

        return redirect()
            ->route('admin.template-products.index')
            ->with('status', "Template product {$name} was deleted.");
    }

    public function import(LegacyTemplateImporter $importer): RedirectResponse
    {
        $stats = $importer->import();

        return redirect()
            ->route('admin.template-products.index')
            ->with('status', sprintf(
                'Imported %d products, %d blocks, %d rows, and %d download buttons. Skipped %d existing or empty products.',
                $stats['products'],
                $stats['blocks'],
                $stats['rows'],
                $stats['downloads'],
                $stats['skipped'],
            ));
    }

    public function reorder(Request $request): JsonResponse
    {
        $data = $request->validate([
            'order' => ['required', 'array', 'min:1', 'max:1000'],
            'order.*' => ['required', 'integer', 'distinct'],
        ]);

        $ids = array_map('intval', $data['order']);
        $existingIds = TemplateProduct::query()
            ->whereIn('id', $ids)
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->all();

        abort_unless(count($existingIds) === count($ids), 422, 'The template product order is out of date.');

        DB::transaction(function () use ($ids): void {
            foreach ($ids as $index => $id) {
                TemplateProduct::query()
                    ->whereKey($id)
                    ->update(['sort_order' => ($index + 1) * 10]);
            }
        });

        return response()->json(['ok' => true]);
    }

    private function saveProduct(Request $request, TemplateProduct $product): void
    {
        $data = $this->validatedData($request, $product);
        $uploadedPaths = [];
        $obsoletePaths = [];

        try {
            DB::transaction(function () use ($request, $data, $product, &$uploadedPaths, &$obsoletePaths): void {
                $product->fill([
                    'name' => $data['name'],
                    'sort_order' => $data['sort_order'],
                    'is_active' => $request->boolean('is_active'),
                ])->save();

                $keptBlockIds = [];

                foreach ($data['blocks'] as $blockKey => $blockData) {
                    $block = $this->ownedBlock($product, $blockData['id'] ?? null);
                    $block->fill([
                        'heading' => $blockData['heading'],
                        'sort_order' => count($keptBlockIds) * 10 + 10,
                    ]);
                    $product->blocks()->save($block);
                    $keptBlockIds[] = $block->id;

                    $keptRowIds = [];

                    foreach ($blockData['rows'] as $rowKey => $rowData) {
                        $row = $this->ownedRow($block, $rowData['id'] ?? null);
                        $row->fill([
                            'size_template' => $rowData['size_template'],
                            'sort_order' => count($keptRowIds) * 10 + 10,
                        ]);
                        $block->rows()->save($row);
                        $keptRowIds[] = $row->id;

                        $keptDownloadIds = [];

                        foreach ($rowData['downloads'] as $downloadKey => $downloadData) {
                            $download = $this->ownedDownload($row, $downloadData['id'] ?? null);
                            $file = $request->file("blocks.{$blockKey}.rows.{$rowKey}.downloads.{$downloadKey}.file");

                            if ($file instanceof UploadedFile) {
                                $newPath = $this->storeFile($file);
                                $uploadedPaths[] = $newPath;

                                if ($download->exists && $this->isManagedPath($download->file_path)) {
                                    $obsoletePaths[] = $download->file_path;
                                }

                                $download->file_path = $newPath;
                                $download->original_name = $file->getClientOriginalName();
                            }

                            $download->fill([
                                'button_label' => $downloadData['button_label'],
                                'sort_order' => count($keptDownloadIds) * 10 + 10,
                            ]);
                            $row->downloads()->save($download);
                            $keptDownloadIds[] = $download->id;
                        }

                        $removedDownloads = $row->downloads()
                            ->when($keptDownloadIds !== [], fn ($query) => $query->whereNotIn('id', $keptDownloadIds))
                            ->get();
                        $obsoletePaths = [...$obsoletePaths, ...$removedDownloads
                            ->pluck('file_path')
                            ->filter(fn (string $path) => $this->isManagedPath($path))
                            ->all()];
                        $row->downloads()
                            ->when($keptDownloadIds !== [], fn ($query) => $query->whereNotIn('id', $keptDownloadIds))
                            ->delete();
                    }

                    $removedRows = $block->rows()
                        ->with('downloads')
                        ->when($keptRowIds !== [], fn ($query) => $query->whereNotIn('id', $keptRowIds))
                        ->get();
                    foreach ($removedRows as $removedRow) {
                        $obsoletePaths = [...$obsoletePaths, ...$removedRow->downloads
                            ->pluck('file_path')
                            ->filter(fn (string $path) => $this->isManagedPath($path))
                            ->all()];
                    }
                    $block->rows()
                        ->when($keptRowIds !== [], fn ($query) => $query->whereNotIn('id', $keptRowIds))
                        ->delete();
                }

                $removedBlocks = $product->blocks()
                    ->with('rows.downloads')
                    ->when($keptBlockIds !== [], fn ($query) => $query->whereNotIn('id', $keptBlockIds))
                    ->get();
                foreach ($removedBlocks as $removedBlock) {
                    foreach ($removedBlock->rows as $removedRow) {
                        $obsoletePaths = [...$obsoletePaths, ...$removedRow->downloads
                            ->pluck('file_path')
                            ->filter(fn (string $path) => $this->isManagedPath($path))
                            ->all()];
                    }
                }
                $product->blocks()
                    ->when($keptBlockIds !== [], fn ($query) => $query->whereNotIn('id', $keptBlockIds))
                    ->delete();
            });
        } catch (Throwable $exception) {
            $this->deleteManagedFiles($uploadedPaths);
            throw $exception;
        }

        $this->deleteManagedFiles(array_values(array_unique($obsoletePaths)));
    }

    /** @return array<string, mixed> */
    private function validatedData(Request $request, TemplateProduct $product): array
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:template_products,name,'.$product->getKey()],
            'sort_order' => ['required', 'integer', 'between:-100000,100000'],
            'is_active' => ['nullable', 'boolean'],
            'blocks' => ['required', 'array', 'min:1', 'max:100'],
            'blocks.*.id' => ['nullable', 'integer'],
            'blocks.*.heading' => ['required', 'string', 'max:500'],
            'blocks.*.rows' => ['required', 'array', 'min:1', 'max:200'],
            'blocks.*.rows.*.id' => ['nullable', 'integer'],
            'blocks.*.rows.*.size_template' => ['required', 'string', 'max:500'],
            'blocks.*.rows.*.downloads' => ['required', 'array', 'min:1', 'max:20'],
            'blocks.*.rows.*.downloads.*.id' => ['nullable', 'integer'],
            'blocks.*.rows.*.downloads.*.button_label' => ['required', 'string', 'max:255'],
            'blocks.*.rows.*.downloads.*.file' => [
                'nullable',
                'file',
                'max:51200',
                'extensions:ai,psd,clip,zip,pdf,eps,rar,7z',
            ],
        ]);

        $validator->after(function ($validator) use ($request): void {
            foreach ((array) $request->input('blocks', []) as $blockKey => $block) {
                foreach ((array) ($block['rows'] ?? []) as $rowKey => $row) {
                    foreach ((array) ($row['downloads'] ?? []) as $downloadKey => $download) {
                        $id = $download['id'] ?? null;
                        $file = $request->file("blocks.{$blockKey}.rows.{$rowKey}.downloads.{$downloadKey}.file");

                        if (! $id && ! $file) {
                            $validator->errors()->add(
                                "blocks.{$blockKey}.rows.{$rowKey}.downloads.{$downloadKey}.file",
                                'Please upload a file for each new download button.'
                            );
                        }
                    }
                }
            }
        });

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    private function ownedBlock(TemplateProduct $product, mixed $id): TemplateBlock
    {
        return $id
            ? $product->blocks()->whereKey((int) $id)->firstOrFail()
            : new TemplateBlock;
    }

    private function ownedRow(TemplateBlock $block, mixed $id): TemplateRow
    {
        return $id
            ? $block->rows()->whereKey((int) $id)->firstOrFail()
            : new TemplateRow;
    }

    private function ownedDownload(TemplateRow $row, mixed $id): TemplateDownload
    {
        return $id
            ? $row->downloads()->whereKey((int) $id)->firstOrFail()
            : new TemplateDownload;
    }

    private function storeFile(UploadedFile $file): string
    {
        $directory = public_path('template/uploads');
        File::ensureDirectoryExists($directory);
        $extension = strtolower($file->getClientOriginalExtension());
        $name = Str::uuid()->toString().'.'.$extension;
        $file->move($directory, $name);

        return '/template/uploads/'.$name;
    }

    private function isManagedPath(?string $path): bool
    {
        return is_string($path) && str_starts_with($path, '/template/uploads/');
    }

    /** @param array<int, string> $paths */
    private function deleteManagedFiles(array $paths): void
    {
        foreach ($paths as $path) {
            if (! $this->isManagedPath($path)) {
                continue;
            }

            $fullPath = public_path('template/uploads/'.basename($path));
            if (File::isFile($fullPath)) {
                File::delete($fullPath);
            }
        }
    }

    /** @return array<int, string> */
    private function productManagedPaths(TemplateProduct $product): array
    {
        return $product->blocks
            ->flatMap(fn (TemplateBlock $block) => $block->rows)
            ->flatMap(fn (TemplateRow $row) => $row->downloads)
            ->pluck('file_path')
            ->filter(fn (string $path) => $this->isManagedPath($path))
            ->values()
            ->all();
    }
}
