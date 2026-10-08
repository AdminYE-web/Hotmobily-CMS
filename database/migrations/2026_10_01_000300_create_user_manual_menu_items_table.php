<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('user_manual_menu_items')) {
            return;
        }

        Schema::create('user_manual_menu_items', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 255);
            $table->foreignId('custom_page_id')
                ->unique()
                ->constrained('custom_pages')
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
