<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductOptionGroup extends Model
{
    protected $fillable = [
        'product_id',
        'option_group_id',
        'sort_order',
        'has_option_configuration',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'has_option_configuration' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function optionGroup(): BelongsTo
    {
        return $this->belongsTo(OptionGroup::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProductOptionGroupItem::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
