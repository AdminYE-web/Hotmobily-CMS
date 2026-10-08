<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    protected $fillable = [
        'slot',
        'image_path',
        'alt_text',
        'link_url',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeHeader(Builder $query): Builder
    {
        return $query
            ->where('slot', 'header')
            ->where('is_active', true);
    }

    public function scopeContact(Builder $query): Builder
    {
        return $query
            ->where('slot', 'contact')
            ->where('is_active', true);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        return Storage::disk('public')->url($this->image_path);
    }
}
