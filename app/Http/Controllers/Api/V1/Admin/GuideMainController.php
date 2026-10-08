<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuideMain;
use App\Support\RichTextSanitizer;
use App\Support\UploadedImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GuideMainController extends Controller
{
    public function show(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->main()->load([
                'items.guidePage:id,name,slug,status',
            ]),
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $data = $request->validate([
            'heading' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:20000'],
            'items' => ['present', 'array', 'max:100'],
            'items.*.guide_page_id' => [
                'required',
                'integer',
                Rule::exists('guide_pages', 'id'),
            ],
            'items.*.title' => ['required', 'string', 'max:255'],
            'items.*.title_color' => [
                'nullable',
                'string',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],
            'items.*.image_path' => ['nullable', 'string', 'max:2000'],
            'items.*.image_alt' => ['nullable', 'string', 'max:500'],
            'items.*.description' => ['nullable', 'string', 'max:20000'],
            'items.*.sort_order' => ['nullable', 'integer', 'min:0', 'max:100000'],
        ]);

        $main = $this->main();
        $main->update([
            'heading' => trim((string) ($data['heading'] ?? '')) ?: null,
            'description' => app(RichTextSanitizer::class)->sanitize($data['description'] ?? null),
        ]);

        $main->items()->delete();

        foreach ($data['items'] as $index => $item) {
            $main->items()->create([
                'guide_page_id' => $item['guide_page_id'],
                'title' => trim($item['title']),
                'title_color' => $item['title_color'] ?? '#000000',
                'image_path' => trim((string) ($item['image_path'] ?? '')) ?: null,
                'image_alt' => trim((string) ($item['image_alt'] ?? '')) ?: null,
                'description' => app(RichTextSanitizer::class)->sanitize($item['description'] ?? null),
                'sort_order' => (int) ($item['sort_order'] ?? $index),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Guide Main settings saved.',
            'data' => $main->fresh()->load([
                'items.guidePage:id,name,slug,status',
            ]),
        ]);
    }

    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'file', 'max:10240'],
        ]);

        $file = $request->file('image');
        $extension = UploadedImage::detectExtension($file);

        if ($extension === null) {
            return response()->json([
                'success' => false,
                'message' => 'The uploaded file is not a valid supported image.',
            ], 422);
        }

        $filename = Str::uuid().'.'.$extension;
        $path = $file->storeAs('guide-main/1', $filename, 'public');

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

    private function main(): GuideMain
    {
        return GuideMain::query()->firstOrCreate(['id' => 1]);
    }
}
