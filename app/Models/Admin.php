<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;


class Admin extends Authenticatable
{
      use HasApiTokens;
    protected $table = 'admin';

    protected $primaryKey = 'email';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'user',
        'email',
        'pass',
        'staff_name',
        'super_admin',
        'lang',
        'dept',
        'token',
        'token_expire',
        'last_login',
    ];

    protected $hidden = [
        'pass',
        'token',
    ];

    protected function casts(): array
    {
        return [
            'super_admin' => 'boolean',
            'token_expire' => 'datetime',
            'last_login' => 'datetime',
        ];
    }
}