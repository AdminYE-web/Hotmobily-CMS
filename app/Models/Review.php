<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;
use Throwable;

class Review extends Model
{
    protected $table = 'reviews_hm';

    public $timestamps = false;

    protected $fillable = [
        'comment',
        'service',
        'product',
        'product_type',
        'images',
        'sale_name',
        'date_reviews',
        'row_stamp',
    ];

    protected $casts = [
        'service' => 'integer',
        'product' => 'integer',
        'date_reviews' => 'datetime',
        'row_stamp' => 'integer',
    ];

    public function answers(): HasMany
    {
        return $this->hasMany(ReviewAnswer::class, 'review_id')
            ->orderBy('date_create')
            ->orderBy('id');
    }

    /**
     * Check the review table on Laravel's current application database.
     */
    public static function tableExists(): bool
    {
        try {
            $model = new static;

            return Schema::hasTable($model->getTable());
        } catch (Throwable) {
            return false;
        }
    }

    /**
     * Convert a stored review to the array shape used by the legacy views.
     */
    public function toDisplayArray(): array
    {
        return [
            'id' => $this->id,
            'comment' => (string) ($this->comment ?? ''),
            'service' => (int) ($this->service ?? 0),
            'product' => (int) ($this->product ?? 0),
            'product_type' => (string) ($this->product_type ?? ''),
            'images' => (string) ($this->images ?? ''),
            'sale_name' => (string) ($this->sale_name ?? ''),
            'date_reviews' => $this->date_reviews?->toDateTimeString(),
            'date' => $this->date_reviews?->format('Y年m月d日 H:i:s'),
        ];
    }
}
