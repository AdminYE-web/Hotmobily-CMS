<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('product_side_menu_items')) {
            return;
        }

        Schema::create('product_side_menu_items', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 255);
            $table->string('image_path');
            $table->foreignId('product_id')
                ->unique()
                ->constrained('products')
                ->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Keep administrator-managed menu settings if this migration is rolled back.
    }
};
