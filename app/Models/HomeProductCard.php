<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeProductCard extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'image_path',
        'description_html',
        'features_html',
        'sort_order',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
