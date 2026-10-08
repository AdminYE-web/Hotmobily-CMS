<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guide_mains', function (Blueprint $table): void {
            $table->id();
            $table->string('heading', 255)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('guide_main_items', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('guide_main_id')
                ->constrained('guide_mains')
                ->cascadeOnDelete();
            $table->foreignId('guide_page_id')
                ->nullable()
                ->constrained('guide_pages')
                ->nullOnDelete();
            $table->string('title', 255);
            $table->string('image_path', 2000)->nullable();
            $table->string('image_alt', 500)->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        DB::table('guide_mains')->insert([
            'id' => 1,
            'heading' => null,
            'description' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('guide_main_items');
        Schema::dropIfExists('guide_mains');
    }
};
