<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Reuse the legacy table when the original News data has already been imported.
        if (Schema::hasTable('news')) {
            return;
        }

        Schema::create('news', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->date('published_at')->nullable();
            $table->string('created_by')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->unsignedTinyInteger('status')->default(2);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->string('category', 50)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->index(['status', 'category', 'published_at'], 'news_public_listing_index');
        });
    }

    public function down(): void
    {
        // Keep migrated News content safe when rolling back application code.
    }
};
