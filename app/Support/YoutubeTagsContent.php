<?php

namespace App\Support;

use Illuminate\Support\Facades\Validator;

class YoutubeTagsContent
{
    public static function defaults(): array
    {
        return ['tags_enabled' => true, 'tag_background_color' => '#58aede', 'tag_text_color' => '#ffffff', 'tags' => []];
    }

    public static function normalize(array $input): array
    {
        $data = array_replace(self::defaults(), array_intersect_key($input, self::defaults()));
        $safeUrl = static function (string $attribute, mixed $value, \Closure $fail): void {
            if (!is_string($value) || preg_match('/[\x00-\x20\\\\]/', $value)) {
                $fail('Use a local path or an HTTP/HTTPS URL.');
                return;
            }
            if (str_starts_with($value, '/') && !str_starts_with($value, '//')) return;
            if (filter_var($value, FILTER_VALIDATE_URL) && in_array(strtolower(parse_url($value, PHP_URL_SCHEME) ?? ''), ['http', 'https'], true)) return;
            $fail('Use a local path or an HTTP/HTTPS URL.');
        };
        Validator::make($data, [
            'tags_enabled' => 'required|boolean',
            'tag_background_color' => ['required', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'tag_text_color' => ['required', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'tags' => 'present|array|max:50',
            'tags.*' => 'required|array',
            'tags.*.id' => ['required', 'string', 'max:80', 'regex:/^[A-Za-z0-9_-]+$/', 'distinct'],
            'tags.*.label' => 'required|string|max:120',
            'tags.*.url' => ['nullable', 'string', 'max:2000', $safeUrl],
        ])->validate();
        return [
            'tags_enabled' => (bool) $data['tags_enabled'],
            'tag_background_color' => strtolower($data['tag_background_color']),
            'tag_text_color' => strtolower($data['tag_text_color']),
            'tags' => array_map(fn ($tag) => ['id' => $tag['id'], 'label' => trim($tag['label']), 'url' => trim((string) ($tag['url'] ?? ''))], array_values($data['tags'])),
        ];
    }
}
