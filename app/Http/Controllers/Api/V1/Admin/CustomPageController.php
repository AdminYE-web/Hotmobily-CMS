<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomPage;
use App\Support\RichTextSanitizer;
use App\Support\UploadedImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CustomPageController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => CustomPage::query()
                ->with('layout:id,name,slug,status')
                ->latest()
                ->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->merge(['slug' => $this->normalizeSlug((string) $request->input('slug'))]);
        $data = $this->validatedData($request);

        $page = CustomPage::query()->create($data);

        return response()->json([
            'success' => true,
            'data' => $page->load('layout:id,name,slug,status'),
        ], 201);
    }

    public function show(CustomPage $customPage): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $customPage->load('layout:id,name,slug,status'),
        ]);
    }

    public function update(Request $request, CustomPage $customPage): JsonResponse
    {
        $request->merge(['slug' => $this->normalizeSlug((string) $request->input('slug'))]);
        $data = $this->validatedData($request, $customPage);
        $customPage->update($data);

        return response()->json([
            'success' => true,
            'data' => $customPage->fresh()->load('layout:id,name,slug,status'),
        ]);
    }

    public function destroy(CustomPage $customPage): JsonResponse
    {
        $customPage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Custom Page deleted.',
        ]);
    }

    public function editContent(CustomPage $customPage): JsonResponse
    {
        $customPage->load('layout');

        if (! $customPage->layout) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a Custom Page Layout first.',
            ], 422);
        }

        $page = $customPage->draft_content_json === null
            ? tap($customPage)->update([
                'draft_content_json' => [
                    'version' => 1,
                    'blocks' => [],
                ],
            ])
            : $customPage;

        $layout = $customPage->layout->draft_layout_json
            ?? $customPage->layout->published_layout_json;

        return response()->json([
            'success' => true,
            'data' => [
                'product' => [
                    'id' => $customPage->id,
                    'name' => $customPage->name,
                    'slug' => $customPage->slug,
                    'product_code' => null,
                    'status' => $customPage->status,
                ],
                'product_layout' => [
                    'id' => $customPage->layout->id,
                    'name' => $customPage->layout->name,
                    'status' => $customPage->layout->status,
                    'layout' => $layout,
                ],
                'content' => $page->draft_content_json ?? ['version' => 1, 'blocks' => []],
                'published_at' => $page->published_at,
                'faq_products' => [],
                'review_product_types' => [],
            ],
        ]);
    }

    public function updateContent(Request $request, CustomPage $customPage): JsonResponse
    {
        $customPage->load('layout');

        if (! $customPage->layout) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a Custom Page Layout first.',
            ], 422);
        }

        $layout = $customPage->layout->draft_layout_json
            ?? $customPage->layout->published_layout_json;

        if (empty($layout['rows'] ?? [])) {
            return response()->json([
                'success' => false,
                'message' => 'Selected Custom Page Layout is empty.',
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

        $customPage->update([
            'draft_content_json' => [
                'version' => 1,
                'blocks' => $cleanContent,
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Custom Page content draft saved.',
            'data' => [
                'draft_content_json' => $customPage->fresh()->draft_content_json,
            ],
        ]);
    }

    public function publishContent(CustomPage $customPage): JsonResponse
    {
        $customPage->load('layout');

        if (! $customPage->layout) {
            return response()->json([
                'success' => false,
                'message' => 'Custom Page Layout is not selected.',
            ], 422);
        }

        if (empty($customPage->layout->published_layout_json)) {
            return response()->json([
                'success' => false,
                'message' => 'Please publish the Custom Page Layout first.',
            ], 422);
        }

        if (empty($customPage->draft_content_json)) {
            return response()->json([
                'success' => false,
                'message' => 'Custom Page content draft not found.',
            ], 422);
        }

        $customPage->update([
            'published_content_json' => $customPage->draft_content_json,
            'published_at' => now(),
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Custom Page published.',
            'data' => [
                'published_at' => $customPage->fresh()->published_at,
            ],
        ]);
    }

    public function uploadImage(Request $request, CustomPage $customPage): JsonResponse
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
        $path = $file->storeAs('custom-pages/'.$customPage->id, $filename, 'public');

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

    public function uploadFile(Request $request, CustomPage $customPage): JsonResponse
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:pdf,zip,rar,7z,ai,psd,eps,svg,doc,docx,xls,xlsx,ppt,pptx,txt,csv,jpg,jpeg,png,webp,gif',
                'max:51200',
            ],
        ]);

        return $this->storeUploadedFile($request->file('file'), $customPage, 'content-files', 'file');
    }

    public function uploadTemplate(Request $request, CustomPage $customPage): JsonResponse
    {
        $request->validate([
            'template' => [
                'required',
                'file',
                'mimes:pdf,zip,ai,psd,eps,svg,doc,docx,xls,xlsx,ppt,pptx',
                'max:51200',
            ],
        ]);

        return $this->storeUploadedFile($request->file('template'), $customPage, 'templates', 'template');
    }

    private function storeUploadedFile($file, CustomPage $customPage, string $folder, string $field): JsonResponse
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = Str::uuid().($extension !== '' ? '.'.$extension : '');
        $path = $file->storeAs('custom-pages/'.$customPage->id.'/'.$folder, $filename, 'public');

        return response()->json([
            'success' => true,
            'data' => [
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'field' => $field,
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

    private function validatedData(Request $request, ?CustomPage $page = null): array
    {
        $uniqueSlug = Rule::unique('custom_pages', 'slug');
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
            'custom_page_layout_id' => ['nullable', 'integer', 'exists:custom_page_layouts,id'],
            'status' => ['required', Rule::in(['draft', 'active', 'inactive'])],
        ]);
    }

    private function normalizeSlug(string $slug): string
    {
        return trim((string) preg_replace('#/+#', '/', trim($slug)), '/');
    }
}
