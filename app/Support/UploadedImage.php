<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;

final class UploadedImage
{
    public static function detectExtension(UploadedFile $file): ?string
    {
        $mime = strtolower((string) $file->getMimeType());
        $originalExtension = strtolower((string) $file->getClientOriginalExtension());

        if ($originalExtension === 'svg' || $mime === 'image/svg+xml') {
            return self::isSafeSvg($file) ? 'svg' : null;
        }

        if (@getimagesize($file->getRealPath()) === false) {
            return null;
        }

        return match ($mime) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
            default => null,
        };
    }

    private static function isSafeSvg(UploadedFile $file): bool
    {
        $contents = @file_get_contents($file->getRealPath());

        if (! is_string($contents) || $contents === '') {
            return false;
        }

        if (preg_match('/<svg\b/i', $contents) !== 1) {
            return false;
        }

        return preg_match(
            '/<!DOCTYPE\b|<!ENTITY\b|<script\b|<foreignObject\b|\bon[a-z]+\s*=|(?:href|xlink:href)\s*=\s*["\']\s*(?:javascript:|data:text\/html)/i',
            $contents
        ) !== 1;
    }
}
