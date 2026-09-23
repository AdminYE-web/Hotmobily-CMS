<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomPage extends ProductDataPage
{
    protected $table = 'custom_pages';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_keywords',
        'meta_description',
        'custom_page_layout_id',
        'status',
        'draft_content_json',
        'published_content_json',
        'published_at',
    ];

    public function layout(): BelongsTo
    {
        return $this->belongsTo(CustomPageLayout::class, 'custom_page_layout_id');
    }
}
