<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcrylicGalleryLog extends Model
{
    protected $table = 'hm_acrylic_gallery_log';

    public $timestamps = false;

    protected $fillable = [
        'gallery_id',
        'product',
        'field',
        'old',
        'new',
        'created_by',
        'created_at',
        'step',
    ];

    protected $casts = [
        'id' => 'integer',
        'gallery_id' => 'integer',
        'step' => 'integer',
        'created_at' => 'datetime',
    ];

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(AcrylicGallery::class, 'gallery_id');
    }
}
