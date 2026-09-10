<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'category',
        'entry_type',
        'product_id',
        'material',
        'question_name',
        'product_link',
        'product_link_text',
        'question',
        'answer',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];
}
