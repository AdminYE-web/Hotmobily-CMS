<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductLayout extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
        'draft_layout_json',
        'published_layout_json',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'draft_layout_json' => 'array',
            'published_layout_json' => 'array',
            'published_at' => 'datetime',
        ];
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}