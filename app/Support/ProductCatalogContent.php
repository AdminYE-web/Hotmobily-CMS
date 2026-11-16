<?php

namespace App\Support;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductCatalogContent
{
    public static function defaults(): array
    {
        return [
            'title' => '',
            'description' => '<p>ボタンをクリックして表示する商品を切り替えることができます。</p>',
            'columns' => 3, 'mobile_columns' => 2,
            'default_category' => '',
            'empty_label' => '該当する商品はありません。',
            'categories' => [], 'items' => [],
        ];
    }

    public static function normalize(array $input): array
    {
        $data = array_replace(self::defaults(), $input);
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
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:50000'],
            'columns' => ['required', 'integer', 'in:2,3,4'],
            'mobile_columns' => ['required', 'integer', 'in:1,2'],
            'empty_label' => ['required', 'string', 'max:500'],
            'default_category' => ['nullable', 'string', 'max:80'],
            'categories' => ['present', 'array', 'max:50'],
            'categories.*' => ['required', 'array'],
            'categories.*.id' => ['required', 'string', 'max:80', 'regex:/^[A-Za-z0-9_-]+$/', 'distinct'],
            'categories.*.name' => ['required', 'string', 'max:100'],
            'items' => ['present', 'array', 'max:100'],
            'items.*' => ['required', 'array'],
            'items.*.id' => ['required', 'string', 'max:80', 'regex:/^[A-Za-z0-9_-]+$/', 'distinct'],
            'items.*.product_id' => ['nullable', 'integer', Rule::exists('products', 'id')],
            'items.*.title' => ['required', 'string', 'max:255'],
            'items.*.alt' => ['nullable', 'string', 'max:500'],
            'items.*.image_url' => ['required', 'string', 'max:2048', $safeUrl],
            'items.*.url' => ['required', 'string', 'max:2048', $safeUrl],
            'items.*.price_prefix' => ['nullable', 'string', 'max:100'],
            'items.*.price' => ['nullable', 'string', 'max:100'],
            'items.*.price_suffix' => ['nullable', 'string', 'max:100'],
            'items.*.delivery' => ['nullable', 'string', 'max:500'],
            'items.*.details_html' => ['nullable', 'string', 'max:50000'],
            'items.*.badge' => ['nullable', 'string', 'max:100'],
            'items.*.category_ids' => ['present', 'array', 'max:50'],
            'items.*.category_ids.*' => ['required', 'string'],
        ])->validate();
        $ids = array_column($data['categories'], 'id');
        $membership = [];
        foreach ($data['items'] as $key => $item) {
            $membership["items.$key.category_ids.*"] = ['distinct', Rule::in($ids)];
        }
        $membership['default_category'] = ['nullable', Rule::in($ids)];
        Validator::make($data, $membership)->validate();

        $clean = [];
        foreach (['title', 'empty_label', 'default_category'] as $field) $clean[$field] = trim($data[$field] ?? '');
        $clean['description'] = (new RichTextSanitizer)->sanitize($data['description'] ?? '') ?? '';
        $clean['columns'] = (int) $data['columns'];
        $clean['mobile_columns'] = (int) $data['mobile_columns'];
        $clean['categories'] = array_values(array_map(fn (array $category) => ['id' => $category['id'], 'name' => trim($category['name'])], $data['categories']));
        $clean['items'] = array_values(array_map(static function (array $item): array {
            $row = ['id' => $item['id'], 'product_id' => empty($item['product_id']) ? null : (int) $item['product_id']];
            foreach (['title', 'alt', 'image_url', 'url', 'price_prefix', 'price', 'price_suffix', 'delivery', 'badge'] as $field) $row[$field] = trim($item[$field] ?? '');
            $row['details_html'] = self::cardDetails($item);
            $row['category_ids'] = array_values($item['category_ids']);
            return $row;
        }, $data['items']));
        return $clean;
    }

    public static function cardDetails(array $item): string
    {
        if (array_key_exists('details_html', $item)) {
            return (new RichTextSanitizer)->sanitize($item['details_html'] ?? '') ?? '';
        }
        // Convert old cards when read, so existing published pages keep their content.
        $lines = [];
        if (trim(($item['price_prefix'] ?? '').($item['price'] ?? '').($item['price_suffix'] ?? '')) !== '') {
            $lines[] = e($item['price_prefix'] ?? '').'<span style="color:#ff0000">'.e($item['price'] ?? '').'</span>'.e($item['price_suffix'] ?? '');
        }
        if (!empty($item['delivery'])) $lines[] = e($item['delivery']);
        return count($lines) ? '<p>'.implode('<br>', $lines).'</p>' : '';
    }
}
