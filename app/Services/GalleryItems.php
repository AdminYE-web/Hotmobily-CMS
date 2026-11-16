<?php

namespace App\Services;

use App\Models\AcrylicGallery;
use App\Models\GalleryPage;
use Illuminate\Support\Collection;

/** Shared source for gallery pages and product showcase selections. */
class GalleryItems
{
    /** Match the public Gallery's tag menu, including its legacy order. */
    public function tagOptions(GalleryPage $page, ?iterable $items = null): array
    {
        if (in_array($page->public_slug, ['acrylic_key', 'acrylic_hair', 'acrylic_standee', 'wappen'], true)
            || in_array($page->gallery_type, ['keyholder', 'acrylic_hair', 'standee', 'wappen'], true)) {
            return ['個人', '会社', '赤色', '青色', '黄色', '紫色', 'ピンク色', '緑色', '黒色', '1人', '複数人', '片面', '両面'];
        }
        if (in_array($page->public_slug, ['rubberkeyholder', 'rubbercoaster'], true)
            || in_array($page->gallery_type, ['rubber_keyholder', 'rubber_coaster'], true)) {
            return ['個人', '会社', '赤色', '青色', '黄色', '紫色', '緑色', '黒色', '白色', '1人', '複数人'];
        }

        return collect($items ?? $this->forPage($page))
            ->flatMap(fn ($item) => preg_split('/\s*[,、，]\s*/u', trim((string) $item->arr_txt1), -1, PREG_SPLIT_NO_EMPTY) ?: [])
            ->unique()->values()->all();
    }

    public function forPage(GalleryPage $page): Collection
    {
        $items = AcrylicGallery::query()->where('type', $page->gallery_type)->orderByDesc('id')->get();
        $archive = match ($page->public_slug) {
            'acrylic_key' => 'acrylic_key_data.php',
            'rubberkeyholder' => 'rubber_keyholder_data.php',
            'rubbercoaster' => 'rubber_coaster_data.php',
            default => null,
        };
        $path = $archive ? base_path('original-web/gallery/'.$archive) : null;
        $rows = $path && is_file($path) ? require $path : [];
        foreach (array_values(array_filter(is_array($rows) ? $rows : [], 'is_array')) as $index => $row) {
            $details = is_array($row['details'] ?? null) ? $row['details'] : [];
            $images = is_array($row['images'] ?? null) ? $row['images'] : [];
            $tags = is_array($row['tags'] ?? null) ? $row['tags'] : [];
            $item = new AcrylicGallery([
                'arr_img' => implode(',', array_filter(array_map('strval', $images))),
                'arr_txt1' => implode(',', array_filter(array_map('strval', $tags))),
                'arr_txt2' => $details['お客様'] ?? null,
                'arr_txt3' => $details['製作年月'] ?? null,
                'arr_txt4' => $details['一言コメント'] ?? null,
                'arr_web' => $details['Web'] ?? null,
                'type' => $page->gallery_type,
            ]);
            $item->id = 900000000 + $index;
            $items->push($item);
        }
        return $items;
    }

    /** Each image can be selected separately, while retaining its item's zoom images. */
    public function choices(GalleryPage $page): array
    {
        return $this->forPage($page)->flatMap(function (AcrylicGallery $item) use ($page): array {
            $names = $item->imageNames();
            $images = array_map(fn ($name) => $item->imageUrl($name, $page->media_directory, (string) $page->legacy_extension), $names);
            $tags = preg_split('/\s*[,、，]\s*/u', trim((string) $item->arr_txt1), -1, PREG_SPLIT_NO_EMPTY) ?: [];
            return array_map(fn ($name, $url) => [
                'key' => $item->id.':'.sha1($name),
                'gallery_id' => $item->id, 'image_name' => $name, 'image_url' => $url,
                'images' => $images, 'tags' => array_values(array_unique($tags)),
                'customer' => (string) $item->arr_txt2, 'date' => (string) $item->arr_txt3,
                'comment' => (string) $item->arr_txt4,
            ], $names, $images);
        })->values()->all();
    }
}
