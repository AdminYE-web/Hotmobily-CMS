<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'product_code',
        'product_layout_id',
        'status',
        'meta_keywords',
        'meta_description',
        'show_notice',
        'notice_text',
        'complete_head_text',
    ];

    protected $casts = [
        'show_notice' => 'boolean',
    ];


    public function layout(): BelongsTo
    {
        return $this->belongsTo(
            ProductLayout::class,
            'product_layout_id'
        );
    }


    public function page(): HasOne
    {
        return $this->hasOne(
            ProductPage::class
        );
    }

    public function optionGroupAssignments(): HasMany
    {
        return $this->hasMany(ProductOptionGroup::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function optionSteps(): HasMany
    {
        return $this->hasMany(ProductOptionStep::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function pdfSummaryCustomRows(): HasMany
    {
        return $this->hasMany(ProductPdfSummaryCustomRow::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function confirmSummaryCustomRows(): HasMany
    {
        return $this->hasMany(ProductConfirmSummaryCustomRow::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function completeSummaryCustomRows(): HasMany
    {
        return $this->hasMany(ProductCompleteSummaryCustomRow::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
