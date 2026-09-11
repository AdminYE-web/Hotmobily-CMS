<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductPriceRule extends Model
{
    protected $fillable = [
        'product_id',
        'rule_name',
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

    public function conditions(): HasMany
    {
        return $this->hasMany(ProductPriceRuleCondition::class);
    }

    public function tiers(): HasMany
    {
        return $this->hasMany(ProductPriceRuleTier::class)->orderBy('quantity')->orderBy('id');
    }
}
