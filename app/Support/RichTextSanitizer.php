<?php

namespace App\Support;

class RichTextSanitizer
{
    public function sanitize(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $html = mb_substr(trim((string) $value), 0, 20000);

        if ($html === '') {
            return '';
        }

        if (! class_exists(\DOMDocument::class)) {
            return htmlspecialchars(
                strip_tags($html),
                ENT_QUOTES | ENT_SUBSTITUTE,
                'UTF-8'
            );
        }

        $document = new \DOMDocument('1.0', 'UTF-8');
        $previousErrors = libxml_use_internal_errors(true);

        $document->loadHTML(
            '<?xml encoding="UTF-8"><div id="rich-text-root">'.$html.'</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        libxml_clear_errors();
        libxml_use_internal_errors($previousErrors);

        $root = $document->getElementById('rich-text-root');

        if (! $root) {
            return '';
        }

        $this->sanitizeChildren($root);

        $result = '';

        foreach ($root->childNodes as $child) {
            $result .= $document->saveHTML($child);
        }

        return $result;
    }

    private function sanitizeChildren(\DOMNode $parent): void
    {
        $allowedTags = [
            'b',
            'strong',
            'i',
            'em',
            'u',
            'br',
            'p',
            'div',
            'ul',
            'ol',
            'li',
            'a',
            'figure',
            'img',
            'font',
            'span',
        ];

        $dangerousTags = [
            'script',
            'style',
            'iframe',
            'object',
            'embed',
        ];

        $children = iterator_to_array($parent->childNodes);

        foreach ($children as $child) {
            if (! $child instanceof \DOMElement) {
                continue;
            }

            $tag = strtolower($child->tagName);

            if (in_array($tag, $dangerousTags, true)) {
                $parent->removeChild($child);

                continue;
            }

            if (! in_array($tag, $allowedTags, true)) {
                $this->sanitizeChildren($child);

                while ($child->firstChild) {
                    $parent->insertBefore($child->firstChild, $child);
                }

                $parent->removeChild($child);

                continue;
            }

            $fontColor = $tag === 'font'
                ? $this->normalizeColor($child->getAttribute('color'))
                : null;
            $styleColor = $tag === 'span'
                ? $this->colorFromStyle($child->getAttribute('style'))
                : null;
            $imageClass = $tag === 'figure'
                ? $this->normalizeImageClass($child->getAttribute('class'))
                : null;
            $imageSource = $tag === 'img'
                ? $this->normalizeImageSource($child->getAttribute('src'))
                : null;
            $imageAlt = $tag === 'img'
                ? mb_substr(trim(strip_tags($child->getAttribute('alt'))), 0, 500)
                : '';
            $linkHref = $tag === 'a'
                ? $this->normalizeLinkHref($child->getAttribute('href'))
                : null;
            $isFileLink = $tag === 'a'
                && $this->hasFileLinkClass($child->getAttribute('class'));
            $size = $tag === 'font' ? $child->getAttribute('size') : '';
            $face = $tag === 'font' ? $child->getAttribute('face') : '';

            if ($tag === 'img' && $imageSource === null) {
                $parent->removeChild($child);

                continue;
            }

            while ($child->attributes->length > 0) {
                $child->removeAttributeNode($child->attributes->item(0));
            }

            if ($fontColor !== null) {
                $child->setAttribute('color', $fontColor);
            }

            if ($styleColor !== null) {
                $child->setAttribute('style', 'color:'.$styleColor);
            }

            if ($imageClass !== null) {
                $child->setAttribute('class', $imageClass);
            }

            if ($imageSource !== null) {
                $child->setAttribute('src', $imageSource);

                if ($imageAlt !== '') {
                    $child->setAttribute('alt', $imageAlt);
                }
            }

            if ($linkHref !== null) {
                $child->setAttribute('href', $linkHref);
            }

            if ($isFileLink) {
                $child->setAttribute('class', 'rich-text-file-link');
                $child->setAttribute('download', '');
            }

            if (preg_match('/^[1-7]$/', $size) === 1) {
                $child->setAttribute('size', $size);
            }

            if (in_array($face, ['Arial', 'Noto Sans JP', 'serif', 'sans-serif'], true)) {
                $child->setAttribute('face', $face);
            }

            $this->sanitizeChildren($child);
        }
    }

    private function normalizeImageClass(string $value): ?string
    {
        $classes = preg_split('/\s+/', trim($value)) ?: [];
        $allowed = [];

        foreach ($classes as $class) {
            if (preg_match('/^(?:image|image-style-(?:align-left|align-right|side|wrap-text|break-text))$/', $class) === 1) {
                $allowed[] = $class;
            }
        }

        $allowed = array_values(array_unique($allowed));

        return $allowed === [] ? null : implode(' ', $allowed);
    }

    private function normalizeImageSource(string $value): ?string
    {
        $source = trim($value);

        if ($source === '' || mb_strlen($source) > 2000) {
            return null;
        }

        if (str_starts_with($source, '/') && ! str_starts_with($source, '//')) {
            return $source;
        }

        if (filter_var($source, FILTER_VALIDATE_URL) === false) {
            return null;
        }

        $scheme = strtolower((string) parse_url($source, PHP_URL_SCHEME));

        return in_array($scheme, ['http', 'https'], true) ? $source : null;
    }

    private function normalizeLinkHref(string $value): ?string
    {
        $href = trim($value);

        if ($href === '' || mb_strlen($href) > 2000) {
            return null;
        }

        if (str_starts_with($href, '/') && ! str_starts_with($href, '//')) {
            return $href;
        }

        if (filter_var($href, FILTER_VALIDATE_URL) === false) {
            return null;
        }

        $scheme = strtolower((string) parse_url($href, PHP_URL_SCHEME));

        return in_array($scheme, ['http', 'https', 'mailto'], true) ? $href : null;
    }

    private function hasFileLinkClass(string $value): bool
    {
        $classes = preg_split('/\s+/', trim($value)) ?: [];

        return in_array('rich-text-file-link', $classes, true);
    }

    private function colorFromStyle(string $style): ?string
    {
        foreach (explode(';', $style) as $declaration) {
            [$property, $value] = array_pad(explode(':', $declaration, 2), 2, null);

            if (strtolower(trim((string) $property)) !== 'color') {
                continue;
            }

            return $this->normalizeColor($value);
        }

        return null;
    }

    private function normalizeColor(mixed $value): ?string
    {
        $color = strtolower(trim((string) $value));

        if (preg_match('/^#[0-9a-f]{3}(?:[0-9a-f]{3})?$/', $color) === 1) {
            if (strlen($color) === 4) {
                return '#'.$color[1].$color[1].$color[2].$color[2].$color[3].$color[3];
            }

            return $color;
        }

        if (preg_match(
            '/^rgba?\(\s*(?:\d{1,3}%?|\d*\.\d+%?)\s*,\s*(?:\d{1,3}%?|\d*\.\d+%?)\s*,\s*(?:\d{1,3}%?|\d*\.\d+%?)(?:\s*,\s*(?:0|1|0?\.\d+|\d{1,3}%))?\s*\)$/',
            $color
        ) === 1) {
            return $color;
        }

        if (preg_match(
            '/^hsla?\(\s*-?\d*\.?\d+\s*,\s*\d{1,3}%\s*,\s*\d{1,3}%(?:\s*,\s*(?:0|1|0?\.\d+|\d{1,3}%))?\s*\)$/',
            $color
        ) === 1) {
            return $color;
        }

        return null;
    }
}
