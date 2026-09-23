<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('product_data_pages')) {
            return;
        }

        $addDraft = ! Schema::hasColumn('product_data_pages', 'draft_content_json');
        $addPublished = ! Schema::hasColumn('product_data_pages', 'published_content_json');
        $addPublishedAt = ! Schema::hasColumn('product_data_pages', 'published_at');

        if (! $addDraft && ! $addPublished && ! $addPublishedAt) {
            return;
        }

        Schema::table('product_data_pages', function (Blueprint $table) use ($addDraft, $addPublished, $addPublishedAt): void {
            if ($addDraft) {
                $table->json('draft_content_json')->nullable();
            }

            if ($addPublished) {
                $table->json('published_content_json')->nullable();
            }

            if ($addPublishedAt) {
                $table->timestamp('published_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('product_data_pages')) {
            return;
        }

        $columns = array_values(array_filter(
            ['draft_content_json', 'published_content_json', 'published_at'],
            fn (string $column): bool => Schema::hasColumn('product_data_pages', $column)
        ));

        if ($columns !== []) {
            Schema::table('product_data_pages', function (Blueprint $table) use ($columns): void {
                $table->dropColumn($columns);
            });
        }
    }
};
