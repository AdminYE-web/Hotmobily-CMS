<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Schema;
use Throwable;

class ReviewAnswer extends Model
{
    protected $table = 'reviews_ans_hm';

    public $timestamps = false;

    protected $fillable = [
        'review_id',
        'ans_txt',
        'ans_name',
        'date_create',
    ];

    protected $casts = [
        'review_id' => 'integer',
        'date_create' => 'datetime',
    ];

    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class, 'review_id');
    }

    public static function tableExists(): bool
    {
        try {
            $model = new static;

            return Schema::hasTable($model->getTable());
        } catch (Throwable) {
            return false;
        }
    }
}
