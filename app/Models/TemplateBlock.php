<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TemplateBlock extends Model
{
    protected $fillable = [
        'heading',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(TemplateProduct::class, 'template_product_id');
    }

    public function rows(): HasMany
    {
        return $this->hasMany(TemplateRow::class)->orderBy('sort_order')->orderBy('id');
    }
}
