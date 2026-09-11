<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OptionDependency extends Model
{
    protected $fillable = [
        'trigger_product_option_id',
        'target_type',
        'target_product_option_id',
        'target_option_group_id',
        'action_type',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function triggerOption(): BelongsTo
    {
        return $this->belongsTo(ProductOption::class, 'trigger_product_option_id');
    }

    public function targetOption(): BelongsTo
    {
        return $this->belongsTo(ProductOption::class, 'target_product_option_id');
    }

    public function targetGroup(): BelongsTo
    {
        return $this->belongsTo(OptionGroup::class, 'target_option_group_id');
    }
}
