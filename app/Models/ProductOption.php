<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOption extends Model
{
    protected $fillable = [
        'option_group_id',
        'option_code',
        'option_name',
        'color_code',
        'option_detail',
        'disable_text',
        'option_images',
        'is_disabled',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'option_images' => 'array',
            'is_disabled' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function optionGroup(): BelongsTo
    {
        return $this->belongsTo(OptionGroup::class);
    }
}
