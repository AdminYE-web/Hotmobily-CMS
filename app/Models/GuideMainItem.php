<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuideMainItem extends Model
{
    protected $table = 'guide_main_items';

    protected $fillable = [
        'guide_main_id',
        'guide_page_id',
        'title',
        'title_color',
        'image_path',
        'image_alt',
        'description',
        'sort_order',
    ];

    public function main(): BelongsTo
    {
        return $this->belongsTo(GuideMain::class, 'guide_main_id');
    }

    public function guidePage(): BelongsTo
    {
        return $this->belongsTo(GuidePage::class, 'guide_page_id');
    }
}
