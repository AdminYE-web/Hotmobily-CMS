<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductPriceRuleCondition extends Model
{
    protected $fillable = [
        'product_price_rule_id',
        'product_option_id',
    ];

    public function rule(): BelongsTo
    {
        return $this->belongsTo(ProductPriceRule::class, 'product_price_rule_id');
    }

    public function productOption(): BelongsTo
    {
        return $this->belongsTo(ProductOption::class);
    }
}
