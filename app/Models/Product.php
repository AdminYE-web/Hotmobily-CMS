<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'product_code',
        'product_layout_id',
        'status',
    ];


    public function layout(): BelongsTo
    {
        return $this->belongsTo(
            ProductLayout::class,
            'product_layout_id'
        );
    }


    public function page(): HasOne
    {
        return $this->hasOne(
            ProductPage::class
        );
    }
}