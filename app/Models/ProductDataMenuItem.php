<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductDataMenuItem extends Model
{
    protected $fillable = [
        'name',
        'product_data_page_id',
        'sort_order',
    ];

    public function productDataPage(): BelongsTo
    {
        return $this->belongsTo(ProductDataPage::class);
    }
}
