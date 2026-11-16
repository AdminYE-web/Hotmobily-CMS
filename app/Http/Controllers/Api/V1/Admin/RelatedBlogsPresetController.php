<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\RelatedBlogsPreset;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RelatedBlogsPresetController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => RelatedBlogsPreset::orderBy('name')->get(['id', 'name', 'updated_at'])]);
    }

    public function show(RelatedBlogsPreset $relatedBlogsPreset): JsonResponse
    {
        return response()->json(['data' => $relatedBlogsPreset]);
    }

    public function store(Request $request): JsonResponse
    {
        return response()->json(['data' => RelatedBlogsPreset::create($this->validated($request))], 201);
    }

    public function update(Request $request, RelatedBlogsPreset $relatedBlogsPreset): JsonResponse
    {
        $relatedBlogsPreset->update($this->validated($request, $relatedBlogsPreset));
        return response()->json(['data' => $relatedBlogsPreset->fresh()]);
    }

    public function destroy(RelatedBlogsPreset $relatedBlogsPreset): JsonResponse
    {
        $relatedBlogsPreset->delete();
        return response()->json(['success' => true]);
    }

    private function validated(Request $request, ?RelatedBlogsPreset $preset = null): array
    {
        $safeUrl = static function (string $attribute, mixed $value, \Closure $fail): void {
            if ($value === null || $value === '') return;
            if (is_string($value) && !preg_match('/[\x00-\x20\\\\]/', $value)) {
                if (str_starts_with($value, '/') && !str_starts_with($value, '//')) return;
                if (filter_var($value, FILTER_VALIDATE_URL) && in_array(strtolower(parse_url($value, PHP_URL_SCHEME) ?? ''), ['http', 'https'], true)) return;
            }
            $fail('Use a local path or an HTTP/HTTPS URL.');
        };
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150', Rule::unique('related_blogs_presets', 'name')->ignore($preset?->id)],
            'content' => ['required', 'array'],
            'content.title' => ['nullable', 'string', 'max:1000'],
            'content.articles' => ['required', 'array', 'min:1', 'max:20'],
            'content.articles.*' => ['required', 'array'],
            'content.articles.*.title' => ['nullable', 'string', 'max:1000'],
            'content.articles.*.underline' => ['sometimes', 'boolean'],
            'content.articles.*.url' => ['nullable', 'string', 'max:2000', $safeUrl],
            'content.articles.*.image_url' => ['nullable', 'string', 'max:2000', $safeUrl],
        ]);
        $content = ['title' => trim($data['content']['title'] ?? ''), 'articles' => []];
        foreach ($data['content']['articles'] as $article) {
            $item = [];
            foreach (['title', 'url', 'image_url'] as $key) $item[$key] = trim($article[$key] ?? '');
            if (array_filter($item)) {
                $item['underline'] = (bool) ($article['underline'] ?? false);
                $content['articles'][] = $item;
            }
        }
        if (!$content['articles']) throw \Illuminate\Validation\ValidationException::withMessages(['content.articles' => 'Add at least one article before saving a preset.']);
        return ['name' => trim($data['name']), 'content_json' => $content];
    }
}
