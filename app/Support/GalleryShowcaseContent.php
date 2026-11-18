<?php

namespace App\Support;

use Illuminate\Support\Facades\Validator;

class GalleryShowcaseContent
{
    public static function defaults(): array
    {
        return ['title' => '', 'description' => '', 'gallery_page_id' => null, 'columns' => 3,
            'mobile_columns' => 1, 'show_tags' => true, 'show_more' => true,
            'more_label' => 'もっと製作事例を見る', 'zoom_label' => '📷クリックすると拡大します', 'items' => []];
    }

    public static function normalize(array $input): array
    {
        $data = array_replace(self::defaults(), $input);
        $hasGalleryItems = collect(is_array($data['items']) ? $data['items'] : [])
            ->contains(fn ($item) => is_array($item) && ($item['source'] ?? 'gallery') !== 'upload');
        $imageUrl = static function ($attribute, $value, $fail): void {
            if (!is_string($value) || preg_match('/[\x00-\x20\\\\]/', $value)) { $fail('Use a local image path or HTTP/HTTPS URL.'); return; }
            if (str_starts_with($value,'/') && !str_starts_with($value,'//')) return;
            if (filter_var($value,FILTER_VALIDATE_URL) && in_array(strtolower(parse_url($value,PHP_URL_SCHEME) ?? ''),['http','https'],true)) return;
            $fail('Use a local image path or HTTP/HTTPS URL.');
        };
        Validator::make($data, [
            'title' => 'nullable|string|max:255', 'description' => 'nullable|string|max:50000',
            'gallery_page_id' => ['nullable',\Illuminate\Validation\Rule::requiredIf($hasGalleryItems),'integer','exists:gallery_pages,id'],
            'columns' => 'required|integer|between:1,4', 'mobile_columns' => 'required|integer|between:1,2',
            'show_tags' => 'required|boolean', 'show_more' => 'required|boolean',
            'more_label' => 'nullable|string|max:255', 'zoom_label' => 'nullable|string|max:255',
            'items' => 'present|array|max:200', 'items.*' => 'required|array',
            'items.*.key' => 'required|string|max:100|distinct', 'items.*.title' => 'nullable|string|max:255',
            'items.*.source' => 'sometimes|in:gallery,upload',
            'items.*.image_url' => ['nullable','string','max:2000',function ($attribute,$value,$fail) use ($imageUrl,$data): void {
                $index=explode('.',$attribute)[1] ?? null;
                if (($data['items'][$index]['source'] ?? 'gallery') === 'upload') $imageUrl($attribute,$value,$fail);
            }],
        ])->validate();
        $clean = array_intersect_key($data, self::defaults());
        $clean['title'] = (string) ($data['title'] ?? '');
        $clean['gallery_page_id'] = !empty($data['gallery_page_id']) ? (int) $data['gallery_page_id'] : null;
        $clean['description'] = (new RichTextSanitizer)->sanitize($data['description'] ?? '') ?? '';
        $clean['columns'] = (int) $data['columns'];
        $clean['mobile_columns'] = (int) $data['mobile_columns'];
        $clean['show_tags'] = (bool) $data['show_tags'];
        $clean['show_more'] = (bool) $data['show_more'];
        $clean['items'] = array_map(function ($item,$index) {
            $cleanItem=['key'=>$item['key'],'title'=>(string) ($item['title'] ?? '')];
            if (($item['source'] ?? 'gallery') === 'upload') {
                if (trim((string) ($item['image_url'] ?? '')) === '') {
                    throw \Illuminate\Validation\ValidationException::withMessages(["items.$index.image_url"=>'Upload an image before saving.']);
                }
                $cleanItem['source']='upload';
                $cleanItem['image_url']=trim($item['image_url']);
            }
            return $cleanItem;
        },array_values($data['items']),array_keys(array_values($data['items'])));
        // Gallery selections retain references; direct uploads store their own URL.
        return $clean;
    }
}
