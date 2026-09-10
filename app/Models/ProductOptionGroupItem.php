<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOptionGroupItem extends Model
{
    protected $fillable = [
        'product_option_group_id',
        'product_option_id',
        'sort_order',
        'is_default',
        'is_active',
        'quantity_rule',
        'min_qty',
        'max_qty',
        'exact_qty',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_default' => 'boolean',
            'is_active' => 'boolean',
            'min_qty' => 'integer',
            'max_qty' => 'integer',
            'exact_qty' => 'integer',
        ];
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(ProductOptionGroup::class, 'product_option_group_id');
    }

    public function productOption(): BelongsTo
    {
        return $this->belongsTo(ProductOption::class);
    }
}
