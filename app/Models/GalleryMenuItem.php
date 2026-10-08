<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryMenuItem extends Model
{
    protected $fillable = [
        'name',
        'gallery_page_id',
        'sort_order',
    ];

    public function galleryPage(): BelongsTo
    {
        return $this->belongsTo(GalleryPage::class);
    }
}
