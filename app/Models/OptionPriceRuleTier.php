<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OptionPriceRuleTier extends Model
{
    protected $fillable = [
        'option_price_rule_id',
        'quantity',
        'additional_price',
        'additional_price_with_tax',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'additional_price' => 'decimal:2',
            'additional_price_with_tax' => 'decimal:2',
        ];
    }

    public function rule(): BelongsTo
    {
        return $this->belongsTo(OptionPriceRule::class, 'option_price_rule_id');
    }
}
