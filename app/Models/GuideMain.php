<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GuideMain extends Model
{
    protected $table = 'guide_mains';

    protected $fillable = [
        'heading',
        'description',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(GuideMainItem::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
