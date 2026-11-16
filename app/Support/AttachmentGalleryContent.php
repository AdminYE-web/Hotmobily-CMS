<?php

namespace App\Support;

use Illuminate\Support\Facades\Validator;

class AttachmentGalleryContent
{
    public static function defaults(): array
    {
        return [
            'title' => 'アタッチメント',
            'description' => '<p>写真をクリックすると拡大写真と詳細説明を確認頂けます。</p>',
            'columns' => 3, 'mobile_columns' => 2,
            'collapsible' => true, 'collapsed_height' => 390,
            'more_label' => 'もっと見る', 'less_label' => '閉じる',
            'zoom_label' => '📷クリックすると拡大します', 'items' => [],
        ];
    }

    public static function normalize(array $input): array
    {
        $data = array_replace(self::defaults(), $input);
        $safeUrl = static function (string $attribute, mixed $value, \Closure $fail): void {
            if ($value === null || $value === '') return;
            if (!is_string($value) || preg_match('/[\x00-\x20\\\\]/', $value)) {
                $fail('Image URLs must be a local path or an HTTP/HTTPS URL.');
                return;
            }
            if (str_starts_with($value, '/') && !str_starts_with($value, '//')) return;
            if (filter_var($value, FILTER_VALIDATE_URL) && in_array(strtolower(parse_url($value, PHP_URL_SCHEME) ?? ''), ['http', 'https'], true)) return;
            $fail('Image URLs must be a local path or an HTTP/HTTPS URL.');
        };
        Validator::make($data, [
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:50000'],
            'columns' => ['required', 'integer', 'in:2,3,4'],
            'mobile_columns' => ['required', 'integer', 'in:1,2'],
            'collapsible' => ['required', 'boolean'],
            'collapsed_height' => ['required', 'integer', 'min:100', 'max:2000'],
            'more_label' => ['required', 'string', 'max:100'],
            'less_label' => ['required', 'string', 'max:100'],
            'zoom_label' => ['nullable', 'string', 'max:255'],
            'items' => ['present', 'array', 'max:100'],
            'items.*.id' => ['required', 'string', 'max:80', 'regex:/^[A-Za-z0-9_-]+$/', 'distinct'],
            'items.*.title' => ['nullable', 'string', 'max:255'],
            'items.*.alt' => ['nullable', 'string', 'max:500'],
            'items.*.price' => ['nullable', 'string', 'max:100'],
            'items.*.description' => ['nullable', 'string', 'max:5000'],
            'items.*.image_url' => ['required', 'string', 'max:2048', $safeUrl],
            'items.*.zoom_url' => ['nullable', 'string', 'max:2048', $safeUrl],
        ])->validate();

        $clean = [];
        foreach (['title', 'more_label', 'less_label', 'zoom_label'] as $field) $clean[$field] = trim($data[$field] ?? '');
        $clean['description'] = (new RichTextSanitizer)->sanitize($data['description'] ?? '') ?? '';
        $clean['columns'] = (int) $data['columns'];
        $clean['mobile_columns'] = (int) $data['mobile_columns'];
        $clean['collapsible'] = (bool) $data['collapsible'];
        $clean['collapsed_height'] = (int) $data['collapsed_height'];
        $clean['items'] = array_values(array_map(static function (array $item): array {
            $row = ['id' => $item['id']];
            foreach (['title', 'alt', 'price', 'description', 'image_url', 'zoom_url'] as $field) $row[$field] = trim($item[$field] ?? '');
            if ($row['price'] === '') $row['price'] = '+0円';
            return $row;
        }, $data['items']));

        return $clean;
    }
}
