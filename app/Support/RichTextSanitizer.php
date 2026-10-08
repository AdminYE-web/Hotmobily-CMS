<?php

namespace App\Support;

class RichTextSanitizer
{
    public function sanitize(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $html = trim((string) $value);

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
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
            'a',
            'figure',
            'img',
            'font',
            'span',
            'blockquote',
            'hr',
            'pre',
            'code',
            's',
            'del',
            'ins',
            'sub',
            'sup',
            'table',
            'caption',
            'colgroup',
            'col',
            'thead',
            'tbody',
            'tfoot',
            'tr',
            'th',
            'td',
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

            if ($tag === 'figure' && $this->hasClass($child->getAttribute('class'), 'media')) {
                $embedUrl = $this->youtubeEmbedUrlFromFigure($child);

                if ($embedUrl !== null && $child->ownerDocument instanceof \DOMDocument) {
                    $wrapper = $this->createYouTubeEmbedWrapper($child->ownerDocument, $embedUrl);
                    $parent->replaceChild($wrapper, $child);
                } else {
                    $parent->removeChild($child);
                }

                continue;
            }

            if ($tag === 'iframe') {
                $embedUrl = $this->normalizeYouTubeEmbedUrl($child->getAttribute('src'));

                if ($embedUrl === null) {
                    $parent->removeChild($child);
                } else {
                    while ($child->attributes->length > 0) {
                        $child->removeAttributeNode($child->attributes->item(0));
                    }

                    $child->setAttribute('src', $embedUrl);
                    $child->setAttribute('title', 'YouTube video');
                    $child->setAttribute('loading', 'lazy');
                    $child->setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share');
                    $child->setAttribute('referrerpolicy', 'strict-origin-when-cross-origin');
                    $child->setAttribute('allowfullscreen', 'allowfullscreen');
                }

                continue;
            }

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
            $inlineStyle = $this->normalizeInlineStyle($child->getAttribute('style'));
            $imageClass = $tag === 'figure'
                ? $this->normalizeImageClass($child->getAttribute('class'))
                : null;
            $mediaEmbedClass = $tag === 'div'
                && $this->hasClass($child->getAttribute('class'), 'rich-text-media-embed')
                    ? 'rich-text-media-embed'
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

            if ($inlineStyle !== null) {
                $child->setAttribute('style', $inlineStyle);
            }

            if ($imageClass !== null) {
                $child->setAttribute('class', $imageClass);
            }

            if ($mediaEmbedClass !== null) {
                $child->setAttribute('class', $mediaEmbedClass);
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

    private function createYouTubeEmbedWrapper(\DOMDocument $document, string $url): \DOMElement
    {
        $wrapper = $document->createElement('div');
        $wrapper->setAttribute('class', 'rich-text-media-embed');

        $iframe = $document->createElement('iframe');
        $iframe->setAttribute('src', $url);
        $iframe->setAttribute('title', 'YouTube video');
        $iframe->setAttribute('loading', 'lazy');
        $iframe->setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share');
        $iframe->setAttribute('referrerpolicy', 'strict-origin-when-cross-origin');
        $iframe->setAttribute('allowfullscreen', 'allowfullscreen');

        $wrapper->appendChild($iframe);

        return $wrapper;
    }

    private function youtubeEmbedUrlFromFigure(\DOMElement $figure): ?string
    {
        $oembeds = $figure->getElementsByTagName('oembed');

        if ($oembeds->length > 0 && $oembeds->item(0) instanceof \DOMElement) {
            $url = $oembeds->item(0)->getAttribute('url');

            if ($embedUrl = $this->normalizeYouTubeEmbedUrl($url)) {
                return $embedUrl;
            }
        }

        foreach ($figure->getElementsByTagName('div') as $container) {
            if ($container instanceof \DOMElement && $container->hasAttribute('data-oembed-url')) {
                $embedUrl = $this->normalizeYouTubeEmbedUrl($container->getAttribute('data-oembed-url'));

                if ($embedUrl !== null) {
                    return $embedUrl;
                }
            }
        }

        $iframes = $figure->getElementsByTagName('iframe');

        if ($iframes->length > 0 && $iframes->item(0) instanceof \DOMElement) {
            return $this->normalizeYouTubeEmbedUrl($iframes->item(0)->getAttribute('src'));
        }

        return null;
    }

    private function normalizeYouTubeEmbedUrl(string $url): ?string
    {
        $parts = parse_url(trim($url));

        if (! is_array($parts)
            || ! in_array(strtolower((string) ($parts['scheme'] ?? '')), ['http', 'https'], true)) {
            return null;
        }

        $host = strtolower((string) ($parts['host'] ?? ''));
        $allowedHosts = [
            'youtube.com',
            'www.youtube.com',
            'm.youtube.com',
            'youtu.be',
            'youtube-nocookie.com',
            'www.youtube-nocookie.com',
        ];

        if (! in_array($host, $allowedHosts, true)) {
            return null;
        }

        $path = (string) ($parts['path'] ?? '');
        $videoId = null;

        if ($host === 'youtu.be') {
            $videoId = trim($path, '/');
        } elseif ($path === '/watch') {
            parse_str((string) ($parts['query'] ?? ''), $query);
            $videoId = $query['v'] ?? null;
        } elseif (preg_match('~^/(?:embed|shorts|live)/([A-Za-z0-9_-]{11})(?:/.*)?$~', $path, $matches) === 1) {
            $videoId = $matches[1];
        }

        if (! is_string($videoId) || preg_match('/^[A-Za-z0-9_-]{11}$/', $videoId) !== 1) {
            return null;
        }

        return 'https://www.youtube-nocookie.com/embed/'.$videoId;
    }

    private function hasClass(string $classList, string $expected): bool
    {
        $classes = preg_split('/\s+/', trim($classList)) ?: [];

        return in_array($expected, $classes, true);
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

        $sourcePath = parse_url($source, PHP_URL_PATH);
        $localUploadSource = $this->localNewsUploadSource(
            is_string($sourcePath) ? $sourcePath : $source
        );

        if ($localUploadSource !== null) {
            return $localUploadSource;
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

    private function localNewsUploadSource(string $path): ?string
    {
        $path = str_replace('\\', '/', rawurldecode($path));
        $path = '/'.ltrim($path, '/');
        $marker = '/uploads-news/';
        $position = strripos($path, $marker);

        if ($position === false) {
            return null;
        }

        $filename = substr($path, $position + strlen($marker));

        if (preg_match('/^[A-Za-z0-9._-]+$/', $filename) !== 1 || in_array($filename, ['.', '..'], true)) {
            return null;
        }

        return '/uploads-news/'.rawurlencode($filename);
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

    private function normalizeInlineStyle(string $style): ?string
    {
        $normalized = [];

        foreach (explode(';', $style) as $declaration) {
            [$property, $value] = array_pad(explode(':', $declaration, 2), 2, null);
            $property = strtolower(trim((string) $property));
            $value = trim((string) $value);
            $value = preg_replace('/\s*!important\s*$/i', '', $value) ?? $value;

            if ($property === 'color') {
                $color = $this->normalizeColor($value);

                if ($color !== null) {
                    $normalized[] = 'color:'.$color;
                }

                continue;
            }

            if ($property === 'font-weight' && $this->isSafeFontWeight($value)) {
                $normalized[] = 'font-weight:'.strtolower($value);

                continue;
            }

            if ($property === 'font-style' && in_array(strtolower($value), ['normal', 'italic', 'oblique'], true)) {
                $normalized[] = 'font-style:'.strtolower($value);

                continue;
            }

            if ($property === 'text-decoration') {
                $decoration = $this->normalizeTextDecoration($value);

                if ($decoration !== null) {
                    $normalized[] = 'text-decoration:'.$decoration;
                }
            }
        }

        return $normalized === [] ? null : implode(';', array_unique($normalized));
    }

    private function isSafeFontWeight(string $value): bool
    {
        $value = strtolower(trim($value));

        return in_array($value, ['normal', 'bold', 'bolder', 'lighter'], true)
            || preg_match('/^[1-9]00$/', $value) === 1;
    }

    private function normalizeTextDecoration(string $value): ?string
    {
        $allowed = ['none', 'underline', 'overline', 'line-through'];
        $tokens = preg_split('/\s+/', strtolower(trim($value))) ?: [];
        $tokens = array_values(array_unique(array_intersect($tokens, $allowed)));

        return $tokens === [] ? null : implode(' ', $tokens);
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
