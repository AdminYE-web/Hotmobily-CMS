<?php

namespace App\Support;

use Illuminate\Support\Facades\Validator;

class GalleryShowcaseContent
{
    public static function defaults(): array
    {
        return ['title' => '', 'description' => '', 'gallery_page_id' => null, 'columns' => 3,
            'mobile_columns' => 1, 'show_tags' => true, 'show_more' => true,
            'more_label' => 'もっと製作事例を見る', 'zoom_label' => '📷クリックすると拡大します', 'items' => []];
    }

    public static function normalize(array $input): array
    {
        $data = array_replace(self::defaults(), $input);
        Validator::make($data, [
            'title' => 'nullable|string|max:255', 'description' => 'nullable|string|max:50000',
            'gallery_page_id' => 'nullable|required_with:items|integer|exists:gallery_pages,id',
            'columns' => 'required|integer|between:1,4', 'mobile_columns' => 'required|integer|between:1,2',
            'show_tags' => 'required|boolean', 'show_more' => 'required|boolean',
            'more_label' => 'nullable|string|max:255', 'zoom_label' => 'nullable|string|max:255',
            'items' => 'present|array|max:200', 'items.*' => 'required|array',
            'items.*.key' => 'required|string|max:100|distinct', 'items.*.title' => 'nullable|string|max:255',
        ])->validate();
        $clean = array_intersect_key($data, self::defaults());
        $clean['title'] = (string) ($data['title'] ?? '');
        $clean['gallery_page_id'] = !empty($data['gallery_page_id']) ? (int) $data['gallery_page_id'] : null;
        $clean['description'] = (new RichTextSanitizer)->sanitize($data['description'] ?? '') ?? '';
        $clean['columns'] = (int) $data['columns'];
        $clean['mobile_columns'] = (int) $data['mobile_columns'];
        $clean['show_tags'] = (bool) $data['show_tags'];
        $clean['show_more'] = (bool) $data['show_more'];
        $clean['items'] = array_map(fn ($item) => ['key' => $item['key'], 'title' => (string) ($item['title'] ?? '')], array_values($data['items']));
        // Store references only. Image URLs and tags always come from the gallery.
        return $clean;
    }
}
