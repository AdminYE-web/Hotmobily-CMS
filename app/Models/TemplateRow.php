<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TemplateRow extends Model
{
    protected $fillable = [
        'size_template',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function block(): BelongsTo
    {
        return $this->belongsTo(TemplateBlock::class, 'template_block_id');
    }

    public function downloads(): HasMany
    {
        return $this->hasMany(TemplateDownload::class)->orderBy('sort_order')->orderBy('id');
    }
}
