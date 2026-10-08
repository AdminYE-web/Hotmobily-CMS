<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Throwable;

class News extends Model
{
    protected $table = 'news';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'published_at',
        'created_by',
        'created_at',
        'updated_at',
        'status',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'category',
    ];

    protected $casts = [
        'published_at' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status' => 'integer',
    ];

    public function scopeActiveInCategory(Builder $query, string $category): Builder
    {
        return $query
            ->where('status', 1)
            ->where('category', $category);
    }

    public static function tableExists(): bool
    {
        try {
            return Schema::hasTable((new static)->getTable());
        } catch (Throwable) {
            return false;
        }
    }
}
