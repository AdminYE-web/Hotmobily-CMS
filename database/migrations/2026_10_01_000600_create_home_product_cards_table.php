<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('home_product_cards')) {
            return;
        }

        Schema::create('home_product_cards', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('product_id')
                ->unique()
                ->constrained('products')
                ->cascadeOnDelete();
            $table->string('name', 255);
            $table->string('image_path');
            $table->longText('description_html')->nullable();
            $table->longText('features_html')->nullable();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Keep administrator-managed home product cards if this migration is rolled back.
    }
};
