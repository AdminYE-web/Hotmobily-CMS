<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserManualMenuItem extends Model
{
    protected $fillable = [
        'name',
        'custom_page_id',
        'sort_order',
    ];

    public function customPage(): BelongsTo
    {
        return $this->belongsTo(CustomPage::class);
    }
}
