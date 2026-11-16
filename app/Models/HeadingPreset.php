<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeadingPreset extends Model
{
    protected $fillable = ['name','content_json'];

    protected $casts = ['content_json'=>'array'];
}
