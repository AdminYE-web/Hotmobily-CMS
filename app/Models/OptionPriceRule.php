<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OptionPriceRule extends Model
{
    protected $fillable = [
        'product_id',
        'rule_name',
        'price_type',
        'target_product_option_id',
        'tax_rate',
    ];

    protected function casts(): array
    {
        return [
            'tax_rate' => 'decimal:2',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function targetOption(): BelongsTo
    {
        return $this->belongsTo(ProductOption::class, 'target_product_option_id');
    }

    public function conditions(): HasMany
    {
        return $this->hasMany(OptionPriceRuleCondition::class);
    }

    public function tiers(): HasMany
    {
        return $this->hasMany(OptionPriceRuleTier::class)->orderBy('quantity')->orderBy('id');
    }
}
