<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SideMenuLinkItem extends Model
{
    protected $fillable = [
        'name',
        'url',
        'image_path',
        'sort_order',
    ];
}
