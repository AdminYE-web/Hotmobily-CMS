<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('side_menu_link_items')) {
            return;
        }

        Schema::create('side_menu_link_items', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 255);
            $table->string('url', 2048);
            $table->string('image_path');
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Keep administrator-managed sidebar links if this migration is rolled back.
    }
};
