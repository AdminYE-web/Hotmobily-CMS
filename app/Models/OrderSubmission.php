<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderSubmission extends Model
{
    protected $fillable = [
        'order_number',
        'product_id',
        'product_name',
        'product_slug',
        'customer_email',
        'legacy_customer_id',
        'legacy_product_detail_id',
        'quantity',
        'total_amount',
        'subtotal_amount',
        'discount_amount',
        'shipping_amount',
        'payment_method',
        'status',
        'order_values',
        'customer_data',
        'customer_files',
        'summary_rows',
        'price_rows',
        'payload',
        'email_html',
        'email_sent_at',
        'completed_at',
        'email_error',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'total_amount' => 'integer',
            'subtotal_amount' => 'integer',
            'discount_amount' => 'integer',
            'shipping_amount' => 'integer',
            'order_values' => 'array',
            'customer_data' => 'array',
            'customer_files' => 'array',
            'summary_rows' => 'array',
            'price_rows' => 'array',
            'payload' => 'array',
            'email_sent_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }
}
