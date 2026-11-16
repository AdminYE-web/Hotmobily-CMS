<?php

namespace App\Support;

use Illuminate\Support\Facades\Validator;

class TextLinkDownload
{
    public const EXTENSIONS = 'pdf|zip|rar|7z|ai|psd|eps|svg|doc|docx|xls|xlsx|ppt|pptx|txt|csv|jpg|jpeg|png|webp|gif';

    public static function pathPattern(): string
    {
        return '~^(products|product-data|custom-pages|guides)/([1-9][0-9]*)/content-files/([a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}\.('.self::EXTENSIONS.'))$~i';
    }

    public static function normalize(array $content): array
    {
        $data = Validator::make([
            'link_mode' => $content['link_mode'] ?? 'link',
            'file_path' => $content['file_path'] ?? '',
            'file_name' => $content['file_name'] ?? '',
            'spacing_top' => $content['spacing_top'] ?? 0,
            'spacing_bottom' => $content['spacing_bottom'] ?? 0,
            'underline' => $content['underline'] ?? true,
        ], [
            'link_mode' => ['required', 'in:link,download'],
            'file_path' => ['required_if:link_mode,download', 'nullable', 'string', 'max:500', 'regex:'.self::pathPattern()],
            'file_name' => ['nullable', 'string', 'max:255'],
            'spacing_top' => ['nullable', 'integer', 'min:0', 'max:200'],
            'spacing_bottom' => ['nullable', 'integer', 'min:0', 'max:200'],
            'underline' => ['required', 'boolean'],
        ])->validate();

        return [
            'link_mode' => $data['link_mode'], 'file_path' => $data['file_path'] ?? '', 'file_name' => self::filename($data['file_name'] ?? ''),
            'spacing_top' => (int) ($data['spacing_top'] ?? 0), 'spacing_bottom' => (int) ($data['spacing_bottom'] ?? 0),
            'underline' => (bool) $data['underline'],
        ];
    }

    public static function filename(string $name): string
    {
        return trim(preg_replace('~[\\\\/\x00-\x1f\x7f]~u', '_', $name));
    }

    public static function url(array $content): ?string
    {
        if (!preg_match(self::pathPattern(), $content['file_path'] ?? '', $parts)) return null;
        return route('content-files.download', [
            'kind' => $parts[1], 'record' => $parts[2], 'filename' => $parts[3],
            'name' => self::filename($content['file_name'] ?? '') ?: $parts[3],
        ]);
    }
}
