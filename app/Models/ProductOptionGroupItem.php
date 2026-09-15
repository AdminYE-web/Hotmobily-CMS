<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOptionGroupItem extends Model
{
    protected $fillable = [
        'product_option_group_id',
        'product_option_id',
        'sort_order',
        'is_default',
        'is_active',
        'quantity_rule',
        'min_qty',
        'max_qty',
        'exact_qty',
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
            'is_default' => 'boolean',
            'is_active' => 'boolean',
            'min_qty' => 'integer',
            'max_qty' => 'integer',
            'exact_qty' => 'integer',
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

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(ProductOptionGroup::class, 'product_option_group_id');
    }

    public function productOption(): BelongsTo
    {
        return $this->belongsTo(ProductOption::class);
    }
}
