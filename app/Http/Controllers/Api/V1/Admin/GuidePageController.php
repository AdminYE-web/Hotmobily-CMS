<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuidePage;
use App\Support\RichTextSanitizer;
use App\Support\UploadedImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GuidePageController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => GuidePage::query()
                ->with('layout:id,name,slug,status')
                ->latest()
                ->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->merge(['slug' => $this->normalizeSlug((string) $request->input('slug'))]);
        $data = $this->validatedData($request);

        $page = GuidePage::query()->create($data);

        return response()->json([
            'success' => true,
            'data' => $page->load('layout:id,name,slug,status'),
        ], 201);
    }

    public function show(GuidePage $guidePage): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $guidePage->load('layout:id,name,slug,status'),
        ]);
    }

    public function update(Request $request, GuidePage $guidePage): JsonResponse
    {
        $request->merge(['slug' => $this->normalizeSlug((string) $request->input('slug'))]);
        $data = $this->validatedData($request, $guidePage);
        $guidePage->update($data);

        return response()->json([
            'success' => true,
            'data' => $guidePage->fresh()->load('layout:id,name,slug,status'),
        ]);
    }

    public function destroy(GuidePage $guidePage): JsonResponse
    {
        $guidePage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Guide deleted.',
        ]);
    }

    public function editContent(GuidePage $guidePage): JsonResponse
    {
        $guidePage->load('layout');

        if (! $guidePage->layout) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a Guide Layout first.',
            ], 422);
        }

        $page = $guidePage->draft_content_json === null
            ? tap($guidePage)->update([
                'draft_content_json' => [
                    'version' => 1,
                    'blocks' => [],
                ],
            ])
            : $guidePage;

        $layout = $guidePage->layout->draft_layout_json
            ?? $guidePage->layout->published_layout_json;

        return response()->json([
            'success' => true,
            'data' => [
                'product' => [
                    'id' => $guidePage->id,
                    'name' => $guidePage->name,
                    'slug' => $guidePage->slug,
                    'product_code' => null,
                    'status' => $guidePage->status,
                ],
                'product_layout' => [
                    'id' => $guidePage->layout->id,
                    'name' => $guidePage->layout->name,
                    'status' => $guidePage->layout->status,
                    'layout' => $layout,
                ],
                'content' => $page->draft_content_json ?? ['version' => 1, 'blocks' => []],
                'published_at' => $page->published_at,
                'faq_products' => [],
                'review_product_types' => [],
            ],
        ]);
    }

    public function updateContent(Request $request, GuidePage $guidePage): JsonResponse
    {
        $guidePage->load('layout');

        if (! $guidePage->layout) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a Guide Layout first.',
            ], 422);
        }

        $layout = $guidePage->layout->draft_layout_json
            ?? $guidePage->layout->published_layout_json;

        if (empty($layout['rows'] ?? [])) {
            return response()->json([
                'success' => false,
                'message' => 'Selected Guide Layout is empty.',
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

        $guidePage->update([
            'draft_content_json' => [
                'version' => 1,
                'blocks' => $cleanContent,
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Guide content draft saved.',
            'data' => [
                'draft_content_json' => $guidePage->fresh()->draft_content_json,
            ],
        ]);
    }

    public function publishContent(GuidePage $guidePage): JsonResponse
    {
        $guidePage->load('layout');

        if (! $guidePage->layout) {
            return response()->json([
                'success' => false,
                'message' => 'Guide Layout is not selected.',
            ], 422);
        }

        if (empty($guidePage->layout->published_layout_json)) {
            return response()->json([
                'success' => false,
                'message' => 'Please publish the Guide Layout first.',
            ], 422);
        }

        if (empty($guidePage->draft_content_json)) {
            return response()->json([
                'success' => false,
                'message' => 'Guide content draft not found.',
            ], 422);
        }

        $guidePage->update([
            'published_content_json' => $guidePage->draft_content_json,
            'published_at' => now(),
            'status' => 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Guide published.',
            'data' => [
                'published_at' => $guidePage->fresh()->published_at,
            ],
        ]);
    }

    public function uploadImage(Request $request, GuidePage $guidePage): JsonResponse
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
        $path = $file->storeAs('guides/'.$guidePage->id, $filename, 'public');

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

    public function uploadFile(Request $request, GuidePage $guidePage): JsonResponse
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:pdf,zip,rar,7z,ai,psd,eps,svg,doc,docx,xls,xlsx,ppt,pptx,txt,csv,jpg,jpeg,png,webp,gif',
                'max:51200',
            ],
        ]);

        return $this->storeUploadedFile($request->file('file'), $guidePage, 'content-files', 'file');
    }

    public function uploadTemplate(Request $request, GuidePage $guidePage): JsonResponse
    {
        $request->validate([
            'template' => [
                'required',
                'file',
                'mimes:pdf,zip,ai,psd,eps,svg,doc,docx,xls,xlsx,ppt,pptx',
                'max:51200',
            ],
        ]);

        return $this->storeUploadedFile($request->file('template'), $guidePage, 'templates', 'template');
    }

    private function storeUploadedFile($file, GuidePage $guidePage, string $folder, string $field): JsonResponse
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $filename = Str::uuid().($extension !== '' ? '.'.$extension : '');
        $path = $file->storeAs('guides/'.$guidePage->id.'/'.$folder, $filename, 'public');

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

    public function sanitizePreviewContent(array $layout, array $incoming): array
    {
        $clean = [];
        foreach ($this->collectLayoutBlocks($layout) as $blockId => $type) {
            if (array_key_exists($blockId, $incoming)) {
                $clean[$blockId] = $this->sanitizeBlockContent($type, $incoming[$blockId]);
            }
        }

        return $clean;
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

        if ($type === 'step_information' && array_key_exists('text', $clean)) {
            $clean['text'] = app(RichTextSanitizer::class)->sanitize($clean['text']);
            $clean['text_format'] = 'html';
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

    private function validatedData(Request $request, ?GuidePage $page = null): array
    {
        $uniqueSlug = Rule::unique('guide_pages', 'slug');

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
            'guide_layout_id' => ['nullable', 'integer', 'exists:guide_layouts,id'],
            'status' => ['required', Rule::in(['draft', 'active', 'inactive'])],
        ]);
    }

    private function normalizeSlug(string $slug): string
    {
        return trim((string) preg_replace('#/+#', '/', trim($slug)), '/');
    }
}
