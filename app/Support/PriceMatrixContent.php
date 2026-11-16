<?php

namespace App\Support;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PriceMatrixContent
{
    public static function defaults(): array
    {
        return [
            'title' => '製作料金', 'description' => '', 'description_format' => 'text', 'delivery_label' => '納期',
            'print_label' => '印刷面', 'table_title' => '数量・サイズ別価格表',
            'quantity_label' => '数量', 'actions_label' => 'Actions',
            'note' => '', 'empty_message' => 'この条件の価格情報はありません。',
            'deliveries' => [['id' => 'days10', 'label' => '10営業日'], ['id' => 'days6', 'label' => '6営業日']],
            'prints' => [['id' => 'single', 'label' => '片面印刷'], ['id' => 'double', 'label' => '両面印刷']],
            'sizes' => [['id' => 'size50', 'label' => '50×50mm以内'], ['id' => 'size75', 'label' => '75×75mm以内'], ['id' => 'size100', 'label' => '100×100mm以内']],
            'default_delivery' => 'days10', 'default_print' => 'single', 'variants' => [],
        ];
    }

    public static function normalize(array $input): array
    {
        if (array_key_exists('option_groups', $input)) {
            return self::normalizeDynamic($input);
        }
        $data = array_replace(self::defaults(), $input);
        $rules = [];
        foreach (['title', 'description', 'delivery_label', 'print_label', 'table_title', 'quantity_label', 'actions_label', 'note', 'empty_message'] as $field) {
            $rules[$field] = ['nullable', 'string', 'max:2000'];
        }
        $rules['description'] = ['nullable', 'string', 'max:50000'];
        $rules['description_format'] = ['required', 'in:text,html'];
        foreach (['deliveries' => 10, 'prints' => 10, 'sizes' => 20] as $field => $limit) {
            $rules[$field] = ['required', 'array', 'min:1', 'max:'.$limit];
            $rules[$field.'.*.id'] = ['required', 'string', 'max:80', 'regex:/^[A-Za-z0-9_-]+$/', 'distinct'];
            $rules[$field.'.*.label'] = ['required', 'string', 'max:255'];
        }
        $rules += [
            'default_delivery' => ['nullable', 'string', 'max:80'],
            'default_print' => ['nullable', 'string', 'max:80'],
            'variants' => ['present', 'array', 'max:100'],
            'variants.*.delivery_id' => ['required', 'string', 'max:80'],
            'variants.*.print_id' => ['required', 'string', 'max:80'],
            'variants.*.rows' => ['present', 'array', 'max:100'],
            'variants.*.rows.*.quantity' => ['required', 'integer', 'min:1', 'max:1000000'],
            'variants.*.rows.*.prices' => ['present', 'array', 'max:20'],
            'variants.*.rows.*.prices.*' => ['nullable', 'regex:/^\d{1,9}(\.\d{1,2})?$/'],
        ];
        Validator::make($data, $rules)->validate();

        $clean = [];
        foreach (['title', 'description', 'delivery_label', 'print_label', 'table_title', 'quantity_label', 'actions_label', 'note', 'empty_message'] as $field) {
            $clean[$field] = trim($data[$field] ?? '');
        }
        $clean['description_format'] = $data['description_format'];
        if ($clean['description_format'] === 'html') {
            $clean['description'] = (new RichTextSanitizer)->sanitize($clean['description']);
        }
        foreach (['deliveries', 'prints', 'sizes'] as $field) {
            $clean[$field] = array_values(array_map(fn ($item) => ['id' => $item['id'], 'label' => trim($item['label'])], $data[$field]));
        }
        $deliveries = array_column($clean['deliveries'], 'id');
        $prints = array_column($clean['prints'], 'id');
        $sizes = array_column($clean['sizes'], 'id');
        $clean['default_delivery'] = in_array($data['default_delivery'], $deliveries, true) ? $data['default_delivery'] : $deliveries[0];
        $clean['default_print'] = in_array($data['default_print'], $prints, true) ? $data['default_print'] : $prints[0];
        $clean['variants'] = [];
        $pairs = [];
        foreach ($data['variants'] as $index => $variant) {
            $pair = $variant['delivery_id'].'|'.$variant['print_id'];
            if (!in_array($variant['delivery_id'], $deliveries, true) || !in_array($variant['print_id'], $prints, true) || isset($pairs[$pair])) {
                throw ValidationException::withMessages(['price_matrix.variants' => 'Price Matrix contains an unknown or duplicate combination.']);
            }
            $pairs[$pair] = true;
            $quantities = [];
            $rows = [];
            foreach ($variant['rows'] as $row) {
                $quantity = (int) $row['quantity'];
                if (isset($quantities[$quantity])) {
                    throw ValidationException::withMessages(['price_matrix.variants.'.$index => 'Price Matrix quantities must be unique within each combination.']);
                }
                $quantities[$quantity] = true;
                $prices = [];
                foreach ($sizes as $id) {
                    $value = $row['prices'][$id] ?? null;
                    $prices[$id] = $value === null || $value === '' ? null : (string) $value;
                }
                $rows[] = ['quantity' => $quantity, 'prices' => $prices];
            }
            $clean['variants'][] = ['delivery_id' => $variant['delivery_id'], 'print_id' => $variant['print_id'], 'rows' => $rows];
        }

        return $clean;
    }

    /** Adapt existing two-group content without changing its option IDs or prices. */
    public static function withGroups(array $input): array
    {
        $data = array_replace(self::defaults(), $input);
        if (!array_key_exists('option_groups', $input)) {
            $data['option_groups'] = [
                ['id' => 'delivery', 'label' => $data['delivery_label'], 'options' => $data['deliveries'], 'default_option' => $data['default_delivery']],
                ['id' => 'print', 'label' => $data['print_label'], 'options' => $data['prints'], 'default_option' => $data['default_print']],
            ];
            $data['variants'] = array_map(fn ($v) => [
                'selections' => ['delivery' => $v['delivery_id'], 'print' => $v['print_id']], 'rows' => $v['rows'],
            ], $data['variants']);
        }
        foreach ($data['option_groups'] as &$group) {
            if (!in_array($group['default_option'] ?? '', array_column($group['options'], 'id'), true)) {
                $group['default_option'] = $group['options'][0]['id'];
            }
        }
        unset($group);
        return $data;
    }

    private static function normalizeDynamic(array $input): array
    {
        $data = array_replace(self::defaults(), $input);
        $rules = [];
        foreach (['title', 'table_title', 'quantity_label', 'actions_label', 'note', 'empty_message'] as $field) {
            $rules[$field] = ['nullable', 'string', 'max:2000'];
        }
        $id = ['required', 'string', 'max:80', 'regex:/^[A-Za-z0-9_-]+$/', 'not_in:__proto__,constructor,prototype'];
        $rules += [
            'description' => ['nullable', 'string', 'max:50000'],
            'description_format' => ['required', 'in:text,html'],
            'option_groups' => ['present', 'array', 'max:12'],
            'option_groups.*' => ['required', 'array'],
            'option_groups.*.id' => [...$id, 'distinct'],
            'option_groups.*.label' => ['required', 'string', 'max:255'],
            'option_groups.*.default_option' => ['nullable', 'string', 'max:80'],
            'option_groups.*.options' => ['required', 'array', 'min:1', 'max:20'],
            'option_groups.*.options.*.id' => $id,
            'option_groups.*.options.*.label' => ['required', 'string', 'max:255'],
            'sizes' => ['required', 'array', 'min:1', 'max:20'],
            'sizes.*.id' => [...$id, 'distinct'],
            'sizes.*.label' => ['required', 'string', 'max:255'],
            'variants' => ['present', 'array', 'max:500'],
            'variants.*.selections' => ['present', 'array', 'max:12'],
            'variants.*.selections.*' => ['required', 'string', 'max:80'],
            'variants.*.rows' => ['present', 'array', 'max:100'],
            'variants.*.rows.*.quantity' => ['required', 'integer', 'min:1', 'max:1000000'],
            'variants.*.rows.*.prices' => ['present', 'array', 'max:20'],
            'variants.*.rows.*.prices.*' => ['nullable', 'regex:/^\d{1,9}(\.\d{1,2})?$/'],
        ];
        Validator::make($data, $rules)->validate();
        $clean = [];
        foreach (['title', 'description', 'table_title', 'quantity_label', 'actions_label', 'note', 'empty_message'] as $field) {
            $clean[$field] = trim($data[$field] ?? '');
        }
        $clean['description_format'] = $data['description_format'];
        if ($clean['description_format'] === 'html') {
            $clean['description'] = (new RichTextSanitizer)->sanitize($clean['description']);
        }
        $clean['option_groups'] = [];
        foreach ($data['option_groups'] as $group) {
            $options = array_values(array_map(fn ($o) => ['id' => $o['id'], 'label' => trim($o['label'])], $group['options']));
            $ids = array_column($options, 'id');
            if (count(array_unique($ids)) !== count($ids)) {
                throw ValidationException::withMessages(['price_matrix.option_groups' => 'Option IDs must be unique within each group.']);
            }
            $clean['option_groups'][] = [
                'id' => $group['id'], 'label' => trim($group['label']), 'options' => $options,
                'default_option' => in_array($group['default_option'] ?? '', $ids, true) ? $group['default_option'] : $ids[0],
            ];
        }
        $clean['sizes'] = array_values(array_map(fn ($s) => ['id' => $s['id'], 'label' => trim($s['label'])], $data['sizes']));
        $clean['variants'] = [];
        $seen = [];
        foreach ($data['variants'] as $variant) {
            $selections = [];
            foreach ($clean['option_groups'] as $group) {
                $selected = $variant['selections'][$group['id']] ?? null;
                if (!in_array($selected, array_column($group['options'], 'id'), true)) {
                    throw ValidationException::withMessages(['price_matrix.variants' => 'A price combination contains an unknown or missing option.']);
                }
                $selections[$group['id']] = $selected;
            }
            $key = json_encode($selections);
            if (count($variant['selections']) !== count($selections) || isset($seen[$key])) {
                throw ValidationException::withMessages(['price_matrix.variants' => 'Price Matrix contains an unknown or duplicate combination.']);
            }
            $seen[$key] = true;
            $rows = [];
            $quantities = [];
            foreach ($variant['rows'] as $row) {
                $quantity = (int) $row['quantity'];
                if (isset($quantities[$quantity])) {
                    throw ValidationException::withMessages(['price_matrix.variants' => 'Quantities must be unique within each combination.']);
                }
                $quantities[$quantity] = true;
                $prices = [];
                foreach ($clean['sizes'] as $size) {
                    $value = $row['prices'][$size['id']] ?? null;
                    $prices[$size['id']] = $value === null || $value === '' ? null : (string) $value;
                }
                $rows[] = ['quantity' => $quantity, 'prices' => $prices];
            }
            $clean['variants'][] = ['selections' => $selections, 'rows' => $rows];
        }
        return $clean;
    }
}
