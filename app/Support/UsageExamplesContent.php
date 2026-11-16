<?php

namespace App\Support;

use Illuminate\Support\Facades\Validator;

class UsageExamplesContent
{
    public static function defaults(): array
    {
        return [
            'title' => '利用事例', 'description' => '',
            'columns' => 2, 'mobile_columns' => 1,
            'zoom_label' => '📷クリックすると拡大します', 'items' => [],
        ];
    }

    public static function normalize(array $input): array
    {
        $data = array_replace(self::defaults(), $input);
        Validator::make($data, [
            'columns' => ['required', 'integer', 'in:1,2,3,4'],
            'items' => ['present', 'array', 'max:100'],
            'items.*' => ['required', 'array'],
            'items.*.date' => ['nullable', 'date_format:Y-m-d'],
            'items.*.description' => ['nullable', 'string', 'max:50000'],
        ])->validate();

        // Share image URL, identifier and section validation with the existing gallery.
        $galleryInput = $data;
        // This component validates its own column range, including a single column.
        $galleryInput['columns'] = 2;
        $galleryInput['items'] = array_map(static function (array $item): array {
            unset($item['description']);
            return $item;
        }, $data['items']);
        $gallery = AttachmentGalleryContent::normalize($galleryInput);
        $clean = array_intersect_key($gallery, self::defaults());
        $clean['columns'] = (int) $data['columns'];
        $sanitizer = new RichTextSanitizer;
        $clean['items'] = array_map(static function (array $item, array $original) use ($sanitizer): array {
            unset($item['price']);
            $item['date'] = $original['date'] ?? '';
            $item['description'] = $sanitizer->sanitize($original['description'] ?? '') ?? '';
            return $item;
        }, $gallery['items'], array_values($data['items']));

        return $clean;
    }
}
