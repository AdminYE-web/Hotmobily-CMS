<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryPage extends Model
{
    protected $fillable = [
        'name',
        'heading',
        'slug',
        'public_slug',
        'gallery_type',
        'media_directory',
        'legacy_extension',
        'show_website',
        'show_tags',
        'is_active',
        'sort_order',
        'description',
    ];

    protected $casts = [
        'show_website' => 'boolean',
        'show_tags' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function items(): HasMany
    {
        return $this->hasMany(AcrylicGallery::class, 'type', 'gallery_type');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /** @return array{type: string, label: string, media_directory: string, legacy_extension: string, website: bool} */
    public function legacyDefinition(): array
    {
        return [
            'type' => $this->gallery_type,
            'label' => $this->name,
            'media_directory' => $this->media_directory,
            'legacy_extension' => (string) ($this->legacy_extension ?? ''),
            'website' => $this->show_website,
        ];
    }
}
