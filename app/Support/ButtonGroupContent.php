<?php

namespace App\Support;

use Illuminate\Support\Facades\Validator;

class ButtonGroupContent
{
    public static function defaults(): array
    {
        return ['columns' => 2, 'mobile_columns' => 1, 'gap' => 16, 'items' => []];
    }

    public static function appearance(string $style = 'solid'): array
    {
        $card = $style === 'card';
        return ['style' => $card ? 'card' : 'solid', 'background_color' => $card ? '#ffffff' : '#ff9900',
            'text_color' => $card ? '#111111' : '#ffffff', 'icon_color' => $card ? '#243f4b' : '#ffffff',
            'border_color' => $card ? '#dddddd' : '#ff9900', 'border_radius' => 6,
            'font_size' => $card ? 22 : 28, 'icon_size' => $card ? 48 : 30, 'padding_x' => 24, 'padding_y' => 12,
            'min_height' => $card ? 114 : 54, 'shadow' => $card];
    }

    public static function icons(): array
    {
        $paths = [
            'none' => ['No icon', ''],
            'upload' => ['Uploaded image', ''],
            'cart' => ['Shopping cart', '<path d="M2 3h3l3 12h11l3-9H6"/><circle cx="9" cy="20" r="1"/><circle cx="19" cy="20" r="1"/>'],
            'download' => ['Download file', '<path d="M14 2H5v20h15V8L14 2Zm0 0v6h6M12 11v7m-4-4 4 4 4-4"/>'],
            'book' => ['Guide / book', '<rect x="4" y="2" width="15" height="20" rx="1"/><path d="M4 18h15M8 6h7v8H8V6Zm3 2h1m-1 3h1"/>'],
            'steps' => ['Order steps', '<path d="M5 7h10a5 5 0 0 1 5 5m-3-2 3 3 3-3M19 17H9a5 5 0 0 1-5-5m3 2-3-3-3 3"/><circle cx="4" cy="4" r="2"/><circle cx="20" cy="20" r="2"/>'],
            'gift' => ['Gift / sample', '<path d="M3 10h18v4H3v-4Zm2 4v8h14v-8M12 10v12M12 10C5 10 5 2 9 3c3 0 3 7 3 7Zm0 0c7 0 7-8 3-7-3 0-3 7-3 7Z"/>'],
            'quote' => ['Quotation', '<path d="M5 2h14v20H5V2Zm3 4h8M8 10h8M8 14h3M8 18h3m3-4h2m-2 4h2"/>'],
            'external' => ['External link', '<path d="M14 3h7v7M21 3 10 14M10 5H3v16h16v-7"/>'],
        ];
        return array_map(fn ($icon) => ['label' => $icon[0], 'svg' => $icon[1] === '' ? '' : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">'.$icon[1].'</svg>'], $paths);
    }

    public static function normalize(array $input): array
    {
        // Existing single-button content stays in its original format until edited.
        if (!array_key_exists('items', $input)) {
            Validator::make($input, ['text'=>'nullable|string|max:1000', 'url'=>'nullable|string|max:2000'])->validate();
            return array_intersect_key($input, array_flip(['text', 'url', 'text_color', 'background_color', 'border_radius']));
        }
        $data = array_replace(self::defaults(), $input);
        $url = static function ($attribute, $value, $fail): void {
            if (!is_string($value) || preg_match('/[\x00-\x20\\\\]/', $value)) { $fail('Use a local path, page anchor, or HTTP/HTTPS URL.'); return; }
            if ((str_starts_with($value, '/') && !str_starts_with($value, '//')) || preg_match('/^#[A-Za-z][A-Za-z0-9_-]*$/', $value)) return;
            if (filter_var($value, FILTER_VALIDATE_URL) && in_array(strtolower(parse_url($value, PHP_URL_SCHEME) ?? ''), ['http', 'https'], true)) return;
            $fail('Use a local path, page anchor, or HTTP/HTTPS URL.');
        };
        Validator::make($data, [
            'columns' => 'required|integer|between:1,4', 'mobile_columns' => 'required|integer|between:1,2',
            'gap' => 'required|integer|between:0,80', 'items' => 'present|array|max:50',
            'items.*' => 'required|array', 'items.*.id' => ['required','string','max:80','regex:/^[A-Za-z0-9_-]+$/','distinct'],
            'items.*.text' => 'required|string|max:1000', 'items.*.url' => ['nullable','string','max:2000',$url],
            'items.*.target' => 'required|in:_self,_blank', 'items.*.link_mode' => 'required|in:link,download',
            'items.*.style' => 'required|in:solid,card', 'items.*.icon' => ['required', \Illuminate\Validation\Rule::in(array_keys(self::icons()))],
            'items.*.icon_size' => 'sometimes|integer|between:12,120',
            'items.*.icon_image_url' => ['nullable','string','max:2000',$url],
            'items.*.background_color' => ['required','regex:/^#[0-9a-fA-F]{6}$/'],
            'items.*.text_color' => ['required','regex:/^#[0-9a-fA-F]{6}$/'],
            'items.*.icon_color' => ['required','regex:/^#[0-9a-fA-F]{6}$/'],
            'items.*.border_color' => ['required','regex:/^#[0-9a-fA-F]{6}$/'],
            'items.*.border_radius' => 'required|integer|between:0,999', 'items.*.font_size' => 'required|integer|between:12,48',
            'items.*.padding_x' => 'required|integer|between:0,80', 'items.*.padding_y' => 'required|integer|between:0,80',
            'items.*.min_height' => 'required|integer|between:32,300', 'items.*.shadow' => 'required|boolean',
            'items.*.file_size' => 'nullable|integer|between:0,104857600',
        ])->validate();
        $clean = ['columns' => (int) $data['columns'], 'mobile_columns' => (int) $data['mobile_columns'], 'gap' => (int) $data['gap'], 'items' => []];
        foreach (array_values($data['items']) as $index => $item) {
            if ($item['icon'] === 'upload' && trim((string) ($item['icon_image_url'] ?? '')) === '') {
                throw \Illuminate\Validation\ValidationException::withMessages(["items.$index.icon_image_url" => 'Upload an icon image for button '.($index + 1).'.']);
            }
            try {
                $download = TextLinkDownload::normalize($item);
            } catch (\Illuminate\Validation\ValidationException $exception) {
                throw \Illuminate\Validation\ValidationException::withMessages(
                    collect($exception->errors())->mapWithKeys(fn ($messages, $field) => ["items.$index.$field" => $messages])->all()
                );
            }
            if ($item['link_mode'] === 'link' && trim((string) ($item['url'] ?? '')) === '') {
                throw \Illuminate\Validation\ValidationException::withMessages(["items.$index.url" => 'Enter a destination URL for button '.($index + 1).'.']);
            }
            $button = array_intersect_key($item, array_flip(['id','text','url','target','style','icon','background_color','text_color','icon_color','border_color','border_radius','font_size','padding_x','padding_y','min_height','shadow']));
            if (array_key_exists('icon_size', $item)) $button['icon_size'] = (int) $item['icon_size'];
            $button['url'] = trim((string) ($item['url'] ?? ''));
            if (array_key_exists('icon_image_url', $item)) $button['icon_image_url'] = trim((string) ($item['icon_image_url'] ?? ''));
            foreach (['border_radius','font_size','padding_x','padding_y','min_height'] as $key) $button[$key] = (int) $item[$key];
            $button['shadow'] = (bool) $item['shadow'];
            $clean['items'][] = array_merge($button, array_intersect_key($download, array_flip(['link_mode','file_path','file_name'])), ['file_size' => (int) ($item['file_size'] ?? 0)]);
        }
        return $clean;
    }
}
