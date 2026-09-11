<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OptionPriceRuleCondition extends Model
{
    protected $fillable = [
        'option_price_rule_id',
        'product_option_id',
    ];

    public function rule(): BelongsTo
    {
        return $this->belongsTo(OptionPriceRule::class, 'option_price_rule_id');
    }

    public function productOption(): BelongsTo
    {
        return $this->belongsTo(ProductOption::class);
    }
}
