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
        'show_in_confirm_summary',
        'confirm_summary_label',
        'confirm_summary_sort_order',
        'show_in_confirm_price_summary',
        'confirm_price_summary_label',
        'confirm_price_summary_sort_order',
        'confirm_price_summary_option_id',
        'show_in_complete_summary',
        'complete_summary_label',
        'complete_summary_sort_order',
        'show_in_complete_price_summary',
        'complete_price_summary_label',
        'complete_price_summary_sort_order',
        'complete_price_summary_option_id',
        'show_in_admin_order_detail_summary',
        'admin_order_detail_summary_label',
        'admin_order_detail_summary_sort_order',
        'show_in_admin_order_detail_price_summary',
        'admin_order_detail_price_summary_label',
        'admin_order_detail_price_summary_sort_order',
        'admin_order_detail_price_summary_option_id',
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
            'show_in_confirm_summary' => 'boolean',
            'confirm_summary_sort_order' => 'integer',
            'show_in_confirm_price_summary' => 'boolean',
            'confirm_price_summary_sort_order' => 'integer',
            'confirm_price_summary_option_id' => 'integer',
            'show_in_complete_summary' => 'boolean',
            'complete_summary_sort_order' => 'integer',
            'show_in_complete_price_summary' => 'boolean',
            'complete_price_summary_sort_order' => 'integer',
            'complete_price_summary_option_id' => 'integer',
            'show_in_admin_order_detail_summary' => 'boolean',
            'admin_order_detail_summary_sort_order' => 'integer',
            'show_in_admin_order_detail_price_summary' => 'boolean',
            'admin_order_detail_price_summary_sort_order' => 'integer',
            'admin_order_detail_price_summary_option_id' => 'integer',
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
