<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttachmentGalleryPreset;
use App\Support\AttachmentGalleryContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttachmentGalleryPresetController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => AttachmentGalleryPreset::orderBy('name')->get(['id', 'name', 'updated_at'])]);
    }

    public function show(AttachmentGalleryPreset $attachmentGalleryPreset): JsonResponse
    {
        return response()->json(['data' => $attachmentGalleryPreset]);
    }

    public function store(Request $request): JsonResponse
    {
        $preset = AttachmentGalleryPreset::create($this->validated($request));
        return response()->json(['data' => $preset], 201);
    }

    public function update(Request $request, AttachmentGalleryPreset $attachmentGalleryPreset): JsonResponse
    {
        $attachmentGalleryPreset->update($this->validated($request, $attachmentGalleryPreset));
        return response()->json(['data' => $attachmentGalleryPreset->fresh()]);
    }

    public function destroy(AttachmentGalleryPreset $attachmentGalleryPreset): JsonResponse
    {
        // Product galleries are independent copies; leave their files and content intact.
        $attachmentGalleryPreset->delete();
        return response()->json(['success' => true]);
    }

    private function validated(Request $request, ?AttachmentGalleryPreset $preset = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150', Rule::unique('attachment_gallery_presets', 'name')->ignore($preset?->id)],
            'content' => ['required', 'array'],
            'content.items' => ['required', 'array', 'min:1', 'max:100'],
        ]);
        // Normalize the complete gallery; nested validation returns only its items.
        return ['name' => trim($data['name']), 'content_json' => AttachmentGalleryContent::normalize($request->input('content'))];
    }
}
