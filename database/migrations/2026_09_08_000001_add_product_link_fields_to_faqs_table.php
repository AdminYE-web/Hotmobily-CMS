<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('faqs')) {
            return;
        }

        Schema::table('faqs', function (Blueprint $table): void {
            if (!Schema::hasColumn('faqs', 'product_link')) {
                $table
                    ->string('product_link', 2000)
                    ->nullable()
                    ->after('question_name');
            }

            if (!Schema::hasColumn('faqs', 'product_link_text')) {
                $table
                    ->string('product_link_text', 500)
                    ->nullable()
                    ->after('product_link');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('faqs')) {
            return;
        }

        Schema::table('faqs', function (Blueprint $table): void {
            if (Schema::hasColumn('faqs', 'product_link_text')) {
                $table->dropColumn('product_link_text');
            }

            if (Schema::hasColumn('faqs', 'product_link')) {
                $table->dropColumn('product_link');
            }
        });
    }
};
