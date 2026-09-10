<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            Schema::hasTable('faqs')
            && !Schema::hasColumn('faqs', 'entry_type')
        ) {
            Schema::table('faqs', function (Blueprint $table): void {
                $table
                    ->string('entry_type', 20)
                    ->default('faq')
                    ->after('category');
            });
        }
    }

    public function down(): void
    {
        if (
            Schema::hasTable('faqs')
            && Schema::hasColumn('faqs', 'entry_type')
        ) {
            Schema::table('faqs', function (Blueprint $table): void {
                $table->dropColumn('entry_type');
            });
        }
    }
};
