<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductDataPage;
use App\Support\RichTextSanitizer;
use App\Support\UploadedImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductDataPageController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => ProductDataPage::query()
                ->with('layout:id,name,slug,status')
                ->latest()
                ->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->normalizeSlug($data['slug']);

        $page = ProductDataPage::query()->create($data);

        return response()->json([
            'success' => true,
            'data' => $page->load('layout:id,name,slug,status'),
        ], 201);
    }

    public function show(ProductDataPage $productDataPage): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $productDataPage->load('layout:id,name,slug,status'),
        ]);
    }

    public function update(Request $request, ProductDataPage $productDataPage): JsonResponse
    {
        $data = $this->validatedData($request, $productDataPage);
        $data['slug'] = $this->normalizeSlug($data['slug']);
        $productDataPage->update($data);

        return response()->json([
            'success' => true,
            'data' => $productDataPage->fresh()->load('layout:id,name,slug,status'),
        ]);
    }

    public function destroy(ProductDataPage $productDataPage): JsonResponse
    {
        $productDataPage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product data deleted.',
        ]);
    }

    public function editContent(ProductDataPage $productDataPage): JsonResponse
    {
        $productDataPage->load('layout');

        if (! $productDataPage->layout) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a Product Data Layout first.',
            ], 422);
        }

        $page = $productDataPage->draft_content_json === null
            ? tap($productDataPage)->update([
                'draft_content_json' => [
                    'version' => 1,
                    'blocks' => [],
                ],
            ])
            : $productDataPage;

        $layout = $productDataPage->layout->draft_layout_json
            ?? $productDataPage->layout->published_layout_json;

        return response()->json([
            'success' => true,
            'data' => [
                'product' => [
                    'id' => $productDataPage->id,
                    'name' => $productDataPage->name,
                    'slug' => $productDataPage->slug,
                    'product_code' => null,
                    'status' => $productDataPage->status,
                ],
                'product_layout' => [
                    'id' => $productDataPage->layout->id,
                    'name' => $productDataPage->layout->name,
                    'status' => $productDataPage->layout->status,
                    'layout' => $layout,
                ],
                'product_data_layout' => [
                    'id' => $productDataPage->layout->id,
                    'name' => $productDataPage->layout->name,
                    'status' => $productDataPage->layout->status,
                    'layout' => $layout,
                ],
                'content' => $page->draft_content_json ?? ['version' => 1, 'blocks' => []],
                'published_at' => $page->published_at,
                'faq_products' => [],
                'review_product_types' => [],
            ],
        ]);
    }

    public function updateContent(Request $request, ProductDataPage $productDataPage): JsonResponse
    {
        $productDataPage->load('layout');

        if (! $productDataPage->layout) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a Product Data Layout first.',
            ], 422);
        }

        $layout = $productDataPage->layout->draft_layout_json
            ?? $productDataPage->layout->published_layout_json;

        if (empty($layout['rows'] ?? [])) {
            return response()->json([
                'success' => false,
                'message' => 'Selected Product Data Layout is empty.',
            ], 422);
        }

        $request->validate(['blocks' => ['present', 'array']]);
        $layoutBlocks = $this->collectLayoutBlocks($layout);
        $incoming = $request->input('blocks', []);
        $cleanContent = [];

        foreach ($layoutBlocks as $blockId => $blockType) {
            if (array_key_exists($blockId, $incoming)) {
                $cleanContent[$blockId] = $this->sanitizeBlockContent(
                    $blockType,
                    $incoming[$blockId]
                );
            }
        }

        $productDataPage->update([
            'draft_content_json' => [
                'version' => 1,
                'blocks' => $cleanContent,
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product Data content draft saved.',
            'data' => [
                'draft_content_json' => $productDataPage->fresh()->draft_content_json,
            ],
        ]);
    }

    public function publishContent(ProductDataPage $productDataPage): JsonResponse
    {
        $productDataPage->load('layout');

        if (! $productDataPage->layout) {
            return response()->json([
                'success' => false,
                'message' => 'Product Data Layout is not selected.',
            ], 422);
        }

        if (empty($productDataPage->layout->published_layout_json)) {
            return response()->json([
                'success' => false,
                'message' => 'Please publish the Product Data Layout first.',
            ], 422);
        }

        if (empty($productDataPage->draft_content_json)) {
            return response()->json([
                'success' => false,
                'message' => 'Product Data content draft not found.',
            ], 422);
        }

        $productDataPage->update([
            'published_content_json' => $productDataPage->draft_content_json,
            'published_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product Data page published.',
            'data' => [
                'published_at' => $productDataPage->fresh()->published_at,
            ],
        ]);
    }

    public function uploadImage(Request $request, ProductDataPage $productDataPage): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'file', 'max:10240'],
        ]);

        $file = $request->file('image');
        $mime = $file->getMimeType();
        $extension = UploadedImage::detectExtension($file);

        if ($extension === null) {
            return response()->json([
                'success' => false,
                'message' => 'The uploaded file is not a valid supported image.',
            ], 422);
        }

        $filename = Str::uuid().'.'.$extension;
        $path = $file->storeAs('product-data/'.$productDataPage->id, $filename, 'public');

        return response()->json([
            'success' => true,
            'data' => [
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $mime,
            ],
        ], 201);
    }

    public function uploadFile(Request $request, ProductDataPage $productDataPage): JsonResponse
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:pdf,zip,rar,7z,ai,psd,eps,svg,doc,docx,xls,xlsx,ppt,pptx,txt,csv,jpg,jpeg,png,webp,gif',
                'max:51200',
            ],
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = Str::uuid().($extension !== '' ? '.'.$extension : '');
        $path = $file->storeAs(
            'product-data/'.$productDataPage->id.'/content-files',
            $filename,
            'public'
        );

        return response()->json([
            'success' => true,
            'data' => [
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
            ],
        ], 201);
    }

    public function uploadTemplate(Request $request, ProductDataPage $productDataPage): JsonResponse
    {
        $request->validate([
            'template' => [
                'required',
                'file',
                'mimes:pdf,zip,ai,psd,eps,svg,doc,docx,xls,xlsx,ppt,pptx',
                'max:51200',
            ],
        ]);

        $file = $request->file('template');
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = Str::uuid().'.'.$extension;
        $path = $file->storeAs(
            'product-data/'.$productDataPage->id.'/templates',
            $filename,
            'public'
        );

        return response()->json([
            'success' => true,
            'data' => [
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
            ],
        ], 201);
    }

    private function collectLayoutBlocks(array $layout): array
    {
        $blocks = [];

        foreach ($layout['rows'] ?? [] as $row) {
            foreach ($row['columns'] ?? [] as $column) {
                foreach ($column['blocks'] ?? [] as $block) {
                    if (isset($block['id'], $block['type'])) {
                        $blocks[$block['id']] = $block['type'];
                    }

                    foreach ($block['children'] ?? [] as $child) {
                        if (isset($child['id'], $child['type'])) {
                            $blocks[$child['id']] = $child['type'];
                        }
                    }
                }
            }
        }

        return $blocks;
    }

    private function sanitizeBlockContent(string $type, mixed $content): array
    {
        $content = is_array($content) ? $content : [];
        $clean = $this->sanitizeNestedValues($content);

        if ($type === 'rich_text' && array_key_exists('content', $clean)) {
            $clean['content'] = app(RichTextSanitizer::class)->sanitize($clean['content']);
            $clean['content_format'] = 'html';
        }

        if ($type === 'image') {
            $clean['open_in_modal'] = (bool) ($content['open_in_modal'] ?? false);
        }

        return $clean;
    }

    private function sanitizeNestedValues(mixed $value, int $depth = 0): mixed
    {
        if ($depth > 8) {
            return null;
        }

        if (is_array($value)) {
            $clean = [];

            foreach (array_slice($value, 0, 300, true) as $key => $item) {
                $clean[$key] = $this->sanitizeNestedValues($item, $depth + 1);
            }

            return $clean;
        }

        if (is_string($value)) {
            return mb_substr(trim($value), 0, 20000);
        }

        return is_scalar($value) || $value === null ? $value : null;
    }

    private function validatedData(Request $request, ?ProductDataPage $page = null): array
    {
        $uniqueSlug = Rule::unique('product_data_pages', 'slug');

        if ($page !== null) {
            $uniqueSlug->ignore($page->id);
        }

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9][A-Za-z0-9_.-]*(\/[A-Za-z0-9][A-Za-z0-9_.-]*)*$/',
                $uniqueSlug,
            ],
            'description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:1000'],
            'meta_description' => ['nullable', 'string', 'max:1000'],
            'product_data_layout_id' => ['nullable', 'integer', 'exists:product_data_layouts,id'],
            'status' => ['required', Rule::in(['draft', 'active', 'inactive'])],
        ]);
    }

    private function normalizeSlug(string $slug): string
    {
        return trim(preg_replace('#/+#', '/', trim($slug)), '/');
    }
}
