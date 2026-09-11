<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OptionGroup extends Model
{
    protected $fillable = [
        'group_code',
        'group_name',
        'display_type',
        'help_text',
        'is_main_price_group',
        'is_required',
        'show_in_order_summary',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_main_price_group' => 'boolean',
            'is_required' => 'boolean',
            'show_in_order_summary' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function productOptions(): HasMany
    {
        return $this->hasMany(ProductOption::class)
            ->orderBy('option_name');
    }
}
