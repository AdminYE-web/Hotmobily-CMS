<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpVerify extends Model
{
    protected $table = 'otp_verify';

    protected $fillable = [
        'hash_id',
        'type',
        'ref',
        'code',
        'email',
        'status',
        'created_at',
        'updated_at',
    ];
}