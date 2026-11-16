<?php

namespace App\Support;

use Illuminate\Support\Facades\Validator;

class XPostsContent
{
    public static function defaults(): array
    {
        return ['title' => '', 'description' => '', 'items' => []];
    }

    public static function settings(array $input): array
    {
        return [
            'x_columns' => in_array((int) ($input['x_columns'] ?? 2), [1, 2, 3], true) ? (int) ($input['x_columns'] ?? 2) : 2,
            'x_theme' => ($input['x_theme'] ?? '') === 'dark' ? 'dark' : 'light',
            'x_conversation' => ($input['x_conversation'] ?? '') === 'all' ? 'all' : 'none',
        ];
    }

    public static function post(string $url): ?array
    {
        $parts = parse_url(trim($url));
        if (!$parts || strtolower($parts['scheme'] ?? '') !== 'https'
            || !in_array(strtolower($parts['host'] ?? ''), ['x.com', 'www.x.com', 'twitter.com', 'www.twitter.com', 'mobile.twitter.com'], true)
            || isset($parts['user']) || isset($parts['pass']) || isset($parts['port'])) return null;
        if (!preg_match('~^/([A-Za-z0-9_]{1,15}|i/web)/status/([1-9][0-9]{0,24})(?:/(?:photo|video)/[1-4])?/?$~', $parts['path'] ?? '', $match)) return null;
        return ['post_id' => $match[2], 'url' => 'https://x.com/'.$match[1].'/status/'.$match[2]];
    }

    public static function normalize(array $input): array
    {
        $data = array_replace(self::defaults(), $input);
        Validator::make($data, [
            'title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:50000'],
            'items' => ['present', 'array', 'max:50'],
            'items.*' => ['required', 'array'],
            'items.*.id' => ['required', 'string', 'max:80', 'regex:/^[A-Za-z0-9_-]+$/', 'distinct'],
            'items.*.url' => ['required', 'string', 'max:2048', static function (string $attribute, mixed $value, \Closure $fail): void {
                if (!is_string($value) || !self::post($value)) $fail('Enter an HTTPS link to a post on x.com or twitter.com.');
            }],
            'items.*.note' => ['nullable', 'string', 'max:500'],
        ])->validate();
        return [
            'title' => trim($data['title'] ?? ''),
            'description' => (new RichTextSanitizer)->sanitize($data['description'] ?? '') ?? '',
            'items' => array_values(array_map(static fn (array $item) => array_merge(
                ['id' => $item['id'], 'note' => trim($item['note'] ?? '')], self::post($item['url'])
            ), $data['items'])),
        ];
    }
}
