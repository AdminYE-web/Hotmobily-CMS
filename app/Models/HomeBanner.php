<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

class HomeBanner extends Model
{
    protected $fillable = [
        'image_path',
        'mobile_image_path',
        'alt_text',
        'link_url',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getDesktopImageUrlAttribute(): string
    {
        return $this->publicUrl($this->image_path);
    }

    public function getMobileImageUrlAttribute(): string
    {
        return $this->publicUrl($this->mobile_image_path ?: $this->image_path);
    }

    /** @return Collection<int, self> */
    public static function legacyDefaults(): Collection
    {
        $items = [];

        foreach ([
            [
                'image_path' => '/img/banner_tapestry_up to 3_button_pc.webp',
                'mobile_image_path' => '/img/banner_tapestry_up to 3_button_mobile.webp',
                'link_url' => 'https://hotmobily.jp/products/tapestry/',
                'alt_text' => 'Tapestry product banner',
                'sort_order' => 10,
                'is_active' => true,
            ],
            [
                'image_path' => '/products/images/high-impact_webp.webp',
                'mobile_image_path' => '/products/images/high-impact_mobile.webp',
                'link_url' => '/products/rubberstrap/',
                'alt_text' => 'Rubber strap product banner',
                'sort_order' => 20,
                'is_active' => true,
            ],
            [
                'image_path' => '/img/stain-resistant-coating-banner.webp',
                'mobile_image_path' => '/img/stain-resistant-coating-banner.webp',
                'link_url' => '/faq/details/rubberstrap/q4',
                'alt_text' => 'Stain resistant coating information banner',
                'sort_order' => 30,
                'is_active' => true,
            ],
        ] as $attributes) {
            $items[] = new self($attributes);
        }

        return collect($items);
    }

    private function publicUrl(?string $path): string
    {
        if (! $path) {
            return '';
        }

        return str_starts_with($path, '/')
            ? $path
            : Storage::disk('public')->url($path);
    }
}
