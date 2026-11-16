<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductContentRevision extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'snapshot_json' => 'array',
        'version' => 'integer',
        'restored_from_version' => 'integer',
    ];
}
