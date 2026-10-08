<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('product_data_menu_items')) {
            return;
        }

        Schema::create('product_data_menu_items', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 255);
            $table->foreignId('product_data_page_id')
                ->unique()
                ->constrained('product_data_pages')
                ->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Keep menu configuration if this migration is rolled back.
    }
};
