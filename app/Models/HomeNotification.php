<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeNotification extends Model
{
    protected $fillable = [
        'title',
        'message',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public static function defaultNotification(): self
    {
        return new self([
            'title' => 'お知らせ',
            'message' => '現在お知らせはありません。',
            'is_active' => true,
        ]);
    }
}
