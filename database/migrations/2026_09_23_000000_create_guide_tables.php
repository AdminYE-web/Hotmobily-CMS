<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guide_layouts', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description', 500)->nullable();
            $table->string('status', 20)->default('draft');
            $table->json('draft_layout_json')->nullable();
            $table->json('published_layout_json')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('guide_pages', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('guide_layout_id')
                ->nullable()
                ->constrained('guide_layouts')
                ->restrictOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description', 500)->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('status', 20)->default('draft');
            $table->json('draft_content_json')->nullable();
            $table->json('published_content_json')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guide_pages');
        Schema::dropIfExists('guide_layouts');
    }
};
