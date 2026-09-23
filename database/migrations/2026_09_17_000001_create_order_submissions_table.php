<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Keep a complete, immutable-at-checkout snapshot of the configured
     * product and customer form. The legacy order tables do not have enough
     * columns to retain arbitrary option fields or the three summary layouts.
     */
    public function up(): void
    {
        if (Schema::hasTable('order_submissions')) {
            return;
        }

        Schema::create('order_submissions', function (Blueprint $table): void {
            $table->id();
            $table->string('order_number', 100)->unique();
            $table->unsignedBigInteger('product_id')->nullable()->index();
            $table->string('product_name', 255)->nullable();
            $table->string('product_slug', 255)->nullable()->index();
            $table->string('customer_email', 250)->nullable()->index();
            $table->string('legacy_customer_id', 100)->nullable();
            $table->string('legacy_product_detail_id', 100)->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->bigInteger('total_amount')->default(0);
            $table->bigInteger('subtotal_amount')->default(0);
            $table->bigInteger('discount_amount')->default(0);
            $table->bigInteger('shipping_amount')->default(0);
            $table->string('payment_method', 255)->nullable();
            $table->string('status', 40)->default('pending')->index();
            $table->json('order_values')->nullable();
            $table->json('customer_data')->nullable();
            $table->json('customer_files')->nullable();
            $table->json('summary_rows')->nullable();
            $table->json('price_rows')->nullable();
            $table->json('payload')->nullable();
            $table->longText('email_html')->nullable();
            $table->timestamp('email_sent_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('email_error')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_submissions');
    }
};
