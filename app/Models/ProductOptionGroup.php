<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductOptionGroup extends Model
{
    protected $fillable = [
        'product_id',
        'option_group_id',
        'product_option_step_id',
        'sort_order',
        'has_option_configuration',
        'show_in_order_summary',
        'summary_label',
        'summary_sort_order',
        'show_in_preview_summary',
        'preview_summary_label',
        'preview_summary_sort_order',
        'show_in_price_summary',
        'price_summary_label',
        'price_summary_sort_order',
        'price_summary_option_id',
        'show_in_pdf_summary',
        'pdf_summary_label',
        'pdf_summary_sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'has_option_configuration' => 'boolean',
            'show_in_order_summary' => 'boolean',
            'summary_sort_order' => 'integer',
            'show_in_preview_summary' => 'boolean',
            'preview_summary_sort_order' => 'integer',
            'show_in_price_summary' => 'boolean',
            'price_summary_sort_order' => 'integer',
            'price_summary_option_id' => 'integer',
            'show_in_pdf_summary' => 'boolean',
            'pdf_summary_sort_order' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function optionGroup(): BelongsTo
    {
        return $this->belongsTo(OptionGroup::class);
    }

    public function step(): BelongsTo
    {
        return $this->belongsTo(ProductOptionStep::class, 'product_option_step_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProductOptionGroupItem::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
