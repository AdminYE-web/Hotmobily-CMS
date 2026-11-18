<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomTablePreset;
use App\Http\Controllers\Api\V1\Admin\ProductPageController as ProductContentController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomTablePresetController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => CustomTablePreset::orderBy('name')->get(['id', 'name', 'updated_at'])]);
    }

    public function show(CustomTablePreset $customTablePreset): JsonResponse
    {
        return response()->json(['data' => $customTablePreset]);
    }

    public function store(Request $request): JsonResponse
    {
        return response()->json(['data' => CustomTablePreset::create($this->validated($request))], 201);
    }

    public function update(Request $request, CustomTablePreset $customTablePreset): JsonResponse
    {
        $customTablePreset->update($this->validated($request, $customTablePreset));
        return response()->json(['data' => $customTablePreset->fresh()]);
    }

    public function destroy(CustomTablePreset $customTablePreset): JsonResponse
    {
        $customTablePreset->delete();
        return response()->json(['success' => true]);
    }

    private function validated(Request $request, ?CustomTablePreset $preset = null): array
    {
        $request->merge(['name' => trim((string) $request->input('name', ''))]);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150', Rule::unique('custom_table_presets', 'name')->ignore($preset?->id)],
            'content' => ['required', 'array'],
            'content.rows' => ['required', 'array', 'min:1', 'max:100'],
        ]);

        $layout = ['rows' => [['columns' => [['blocks' => [['id' => 'custom-table-preset', 'type' => 'custom_table']]]]]]];
        $normalized = app(ProductContentController::class)->sanitizePreviewContent($layout, ['custom-table-preset' => $data['content']]);

        return ['name' => $data['name'], 'content_json' => $normalized['custom-table-preset']];
    }
}
