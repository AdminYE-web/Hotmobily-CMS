<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPriceRuleTier extends Model
{
    protected $fillable = [
        'product_price_rule_id',
        'quantity',
        'unit_price',
        'unit_price_with_tax',
        'is_display',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
            'unit_price_with_tax' => 'decimal:2',
            'is_display' => 'boolean',
        ];
    }

    public function rule(): BelongsTo
    {
        return $this->belongsTo(ProductPriceRule::class, 'product_price_rule_id');
    }
}
