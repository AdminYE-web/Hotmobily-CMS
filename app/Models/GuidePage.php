<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuidePage extends Model
{
    protected $table = 'guide_pages';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_keywords',
        'meta_description',
        'guide_layout_id',
        'status',
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

    public function layout(): BelongsTo
    {
        return $this->belongsTo(GuideLayout::class, 'guide_layout_id');
    }
}
