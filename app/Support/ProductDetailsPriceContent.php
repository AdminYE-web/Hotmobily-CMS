<?php

namespace App\Support;

use Illuminate\Support\Facades\Validator;

class ProductDetailsPriceContent
{
    public static function normalize(array $content): array
    {
        $data = Validator::make([
            'price_table_enabled' => $content['price_table_enabled'] ?? false,
            'price_table_title' => array_key_exists('price_table_title', $content)
                ? ($content['price_table_title'] ?? '')
                : '製作単価目安（税込）',
            'price_table_columns' => $content['price_table_columns'] ?? [],
        ], [
            'price_table_enabled' => ['required', 'boolean'],
            'price_table_title' => ['nullable', 'string', 'max:255'],
            'price_table_columns' => ['array', 'max:12'],
            'price_table_columns.*' => ['array'],
            'price_table_columns.*.quantity' => ['required', 'string', 'max:100'],
            'price_table_columns.*.price' => ['required', 'string', 'max:100'],
            'price_table_columns.*.suffix' => ['nullable', 'string', 'max:100'],
        ])->validate();

        if ($data['price_table_enabled']) {
            Validator::make($data, ['price_table_columns' => ['required', 'array', 'min:1']])->validate();
        }

        return [
            'price_table_enabled' => (bool) $data['price_table_enabled'],
            'price_table_title' => trim($data['price_table_title'] ?? ''),
            'price_table_columns' => array_values(array_map(fn (array $column): array => [
                'quantity' => trim($column['quantity']),
                'price' => trim($column['price']),
                'suffix' => trim($column['suffix'] ?? ''),
            ], $data['price_table_columns'])),
        ];
    }
}
