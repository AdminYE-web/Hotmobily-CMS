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

        $addKeywords = ! Schema::hasColumn('product_data_pages', 'meta_keywords');
        $addDescription = ! Schema::hasColumn('product_data_pages', 'meta_description');

        if (! $addKeywords && ! $addDescription) {
            return;
        }

        Schema::table('product_data_pages', function (Blueprint $table) use ($addKeywords, $addDescription): void {
            if ($addKeywords) {
                $table->text('meta_keywords')->nullable();
            }

            if ($addDescription) {
                $table->text('meta_description')->nullable();
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('product_data_pages')) {
            return;
        }

        $columns = array_values(array_filter(
            ['meta_keywords', 'meta_description'],
            fn (string $column): bool => Schema::hasColumn('product_data_pages', $column)
        ));

        if ($columns !== []) {
            Schema::table('product_data_pages', function (Blueprint $table) use ($columns): void {
                $table->dropColumn($columns);
            });
        }
    }
};
