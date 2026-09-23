<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('template_products', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 255)->unique();
            $table->boolean('is_active')->default(true)->index();
            $table->integer('sort_order')->default(0)->index();
            $table->timestamps();
        });

        Schema::create('template_blocks', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('template_product_id')->constrained()->cascadeOnDelete();
            $table->string('heading', 500);
            $table->integer('sort_order')->default(0)->index();
            $table->timestamps();
        });

        Schema::create('template_rows', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('template_block_id')->constrained()->cascadeOnDelete();
            $table->string('size_template', 500);
            $table->integer('sort_order')->default(0)->index();
            $table->timestamps();
        });

        Schema::create('template_downloads', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('template_row_id')->constrained()->cascadeOnDelete();
            $table->string('button_label', 255);
            $table->string('file_path', 1000);
            $table->string('original_name', 500)->nullable();
            $table->integer('sort_order')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('template_downloads');
        Schema::dropIfExists('template_rows');
        Schema::dropIfExists('template_blocks');
        Schema::dropIfExists('template_products');
    }
};
