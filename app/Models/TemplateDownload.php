<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TemplateDownload extends Model
{
    protected $fillable = [
        'button_label',
        'file_path',
        'original_name',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function row(): BelongsTo
    {
        return $this->belongsTo(TemplateRow::class, 'template_row_id');
    }
}
