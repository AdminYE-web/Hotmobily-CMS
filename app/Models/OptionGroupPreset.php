<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionGroupPreset extends Model
{
    protected $fillable = ['option_group_id', 'name', 'content_json'];

    protected $casts = ['option_group_id' => 'integer', 'content_json' => 'array'];
}
