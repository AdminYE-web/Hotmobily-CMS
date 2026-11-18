<?php

namespace App\Support;

use Illuminate\Support\Facades\Validator;

class CustomTableBusinessDays
{
    public static function defaults(): array
    {
        return [
            'description' => '',
            'enable_business_days_switch' => false,
            'business_days_label' => '営業日数を表示',
            'business_days_group' => '',
            'show_business_days' => true,
        ];
    }

    public static function settings(array $input): array
    {
        $data = array_replace(self::defaults(), array_intersect_key($input, self::defaults()));
        Validator::make($data, [
            'description' => 'nullable|string|max:50000',
            'enable_business_days_switch' => 'required|boolean',
            'business_days_label' => 'nullable|string|max:255',
            'business_days_group' => 'nullable|string|max:80',
            'show_business_days' => 'required|boolean',
        ])->validate();

        return [
            'description' => (new RichTextSanitizer)->sanitize($data['description'] ?? '') ?? '',
            'enable_business_days_switch' => (bool) $data['enable_business_days_switch'],
            'business_days_label' => trim((string) $data['business_days_label']) ?: self::defaults()['business_days_label'],
            'business_days_group' => trim((string) ($data['business_days_group'] ?? '')),
            'show_business_days' => (bool) $data['show_business_days'],
        ];
    }

    public static function days(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }
        Validator::make(['business_days' => $value], ['business_days' => 'required|integer|between:0,3650'])->validate();
        return (int) $value;
    }
}
