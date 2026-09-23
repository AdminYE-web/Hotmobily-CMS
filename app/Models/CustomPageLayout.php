<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomPageLayout extends ProductDataLayout
{
    protected $table = 'custom_page_layouts';

    public function pages(): HasMany
    {
        return $this->hasMany(CustomPage::class, 'custom_page_layout_id');
    }
}
