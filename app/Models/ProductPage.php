<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPage extends Model
{
    protected $fillable = [
        'product_id',
        'draft_content_json',
        'published_content_json',
        'published_at',
    ];


    protected function casts(): array
    {
        return [
            'draft_content_json' => 'array',
            'published_content_json' => 'array',
            'published_at' => 'datetime',
        ];
    }


    public function product(): BelongsTo
    {
        return $this->belongsTo(
            Product::class
        );
    }
}