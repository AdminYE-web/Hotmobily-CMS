<?php

namespace App\Support;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomFaqContent
{
    public static function defaults(): array
    {
        return ['title' => '', 'description' => '', 'columns' => 3, 'mobile_columns' => 1, 'items' => []];
    }

    public static function icons(): array
    {
        $paths = [
            'cart' => ['Shopping cart', '<path d="M2 3h3l3 12h11l3-9H6M9 19h.01M19 19h.01"/><circle cx="9" cy="20" r="1"/><circle cx="19" cy="20" r="1"/>'],
            'gem' => ['Quality / diamond', '<path d="m3 8 4-5h10l4 5-9 13L3 8Zm0 0h18M7 3l5 18L17 3"/>'],
            'pen' => ['Design / pencil', '<path d="m16 3 5 5-12 12-6 1 1-6L16 3ZM13 6l5 5M4 15l5 5"/>'],
            'wand' => ['Design assistance', '<path d="m15 5 4 4L6 22l-4-4L15 5ZM12 8l4 4M5 2v4M3 4h4M20 14v4M18 16h4M20 2v4M18 4h4"/>'],
            'monitor' => ['Simulator / monitor', '<rect x="2" y="3" width="20" height="14" rx="1"/><path d="M12 17v4M8 21h8"/>'],
            'check' => ['Submission / confirmation', '<path d="M20 13v7H3V3h12M8 10l4 4L22 4"/>'],
            'calendar' => ['Production / calendar', '<rect x="3" y="5" width="18" height="17" rx="1"/><path d="M7 2v6M17 2v6M3 10h18M8 10v12M15 10v12M3 16h18"/>'],
            'truck' => ['Shipping / truck', '<path d="M2 4h12v13H2V4Zm12 5h4l4 5v3h-8M17 9v5h5"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/>'],
            'card' => ['Payment / card', '<rect x="2" y="4" width="20" height="16" rx="1"/><path d="M2 9h20M5 16h5M13 16h3"/>'],
            'box' => ['Sample / package', '<path d="m12 2 10 5v11l-10 5L2 18V7l10-5ZM2 7l10 5 10-5M12 12v11M7 4.5l10 5"/>'],
            'exchange' => ['Change / return', '<path d="M2 8h19l-4-4M22 16H3l4 4M21 8l-4 4M3 16l4-4"/>'],
            'chat' => ['Repeat order / consultation', '<path d="M20 10c0 4-4 7-9 7H8l-5 3 1-6c-1-1-2-2-2-4 0-4 4-7 9-7s9 3 9 7ZM22 13c1 3-1 5-3 6l2 3-6-2h-2"/>'],
            'question' => ['Question', '<circle cx="12" cy="12" r="10"/><path d="M9 8a3 3 0 0 1 6 0c0 2-3 2-3 5M12 17h.01"/>'],
        ];
        return array_map(static fn (array $icon) => [
            'label' => $icon[0],
            'svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">'.$icon[1].'</svg>',
        ], $paths);
    }

    public static function presets(): array
    {
        return [
            ['title' => 'ご注文・お見積りについて', 'icon' => 'cart', 'url' => '/faq/order'],
            ['title' => '仕様・品質について', 'icon' => 'gem', 'url' => ''],
            ['title' => 'Q. データ作成について', 'icon' => 'pen', 'url' => ''],
            ['title' => 'データ作成補助について', 'icon' => 'wand', 'url' => ''],
            ['title' => '完成図シミュレーターについて', 'icon' => 'monitor', 'url' => ''],
            ['title' => '入稿・デザイン確認について', 'icon' => 'check', 'url' => ''],
            ['title' => '納期について', 'icon' => 'calendar', 'url' => '/faq/delivery'],
            ['title' => '配送・梱包について', 'icon' => 'truck', 'url' => '/faq/delivery'],
            ['title' => 'お支払い・法人のお客様について', 'icon' => 'card', 'url' => '/faq/payment'],
            ['title' => '試作品・サンプルについて', 'icon' => 'box', 'url' => ''],
            ['title' => 'キャンセル・変更・返品・不良品について', 'icon' => 'exchange', 'url' => ''],
            ['title' => 'リピート注文・営業担当への相談について', 'icon' => 'chat', 'url' => ''],
        ];
    }

    public static function iconName(array $item): string
    {
        if (isset(self::icons()[$item['icon'] ?? ''])) return $item['icon'];
        foreach (array_keys(self::icons()) as $icon) {
            if (($item['image_url'] ?? '') === '/images/custom-faq-icons/'.$icon.'.svg') return $icon;
        }
        return 'question';
    }

    public static function normalize(array $input): array
    {
        $data = array_replace(self::defaults(), $input);
        if (is_array($data['items'])) {
            foreach ($data['items'] as &$item) {
                if (is_array($item) && !array_key_exists('icon', $item)) $item['icon'] = self::iconName($item);
            }
            unset($item);
        }
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
            'items' => ['present', 'array', 'max:100'],
            'items.*' => ['required', 'array'],
            'items.*.id' => ['required', 'string', 'max:80', 'regex:/^[A-Za-z0-9_-]+$/', 'distinct'],
            'items.*.title' => ['required', 'string', 'max:255'],
            'items.*.icon' => ['required', Rule::in(array_keys(self::icons()))],
            'items.*.url' => ['required', 'string', 'max:2048', $safeUrl],
            'items.*.new_tab' => ['sometimes', 'boolean'],
        ])->validate();
        return [
            'title' => trim($data['title'] ?? ''),
            'description' => (new RichTextSanitizer)->sanitize($data['description'] ?? '') ?? '',
            'columns' => (int) $data['columns'], 'mobile_columns' => (int) $data['mobile_columns'],
            'items' => array_values(array_map(static fn (array $item) => [
                'id' => $item['id'], 'title' => trim($item['title']), 'icon' => $item['icon'],
                'url' => trim($item['url']), 'new_tab' => (bool) ($item['new_tab'] ?? false),
            ], $data['items'])),
        ];
    }
}
