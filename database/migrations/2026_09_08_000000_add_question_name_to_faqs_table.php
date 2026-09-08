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
            && !Schema::hasColumn('faqs', 'question_name')
        ) {
            Schema::table('faqs', function (Blueprint $table) {
                $table
                    ->string('question_name', 500)
                    ->nullable()
                    ->after('material');
            });
        }
    }

    public function down(): void
    {
        if (
            Schema::hasTable('faqs')
            && Schema::hasColumn('faqs', 'question_name')
        ) {
            Schema::table('faqs', function (Blueprint $table) {
                $table->dropColumn('question_name');
            });
        }
    }
};
