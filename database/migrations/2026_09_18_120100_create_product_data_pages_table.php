<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_data_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_data_layout_id')
                ->nullable()
                ->constrained('product_data_layouts')
                ->restrictOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description', 500)->nullable();
            $table->string('status', 20)->default('draft');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_data_pages');
    }
};
