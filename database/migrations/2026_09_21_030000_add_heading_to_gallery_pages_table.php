<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('gallery_pages')) {
            return;
        }

        if (! Schema::hasColumn('gallery_pages', 'heading')) {
            Schema::table('gallery_pages', function (Blueprint $table): void {
                $table->string('heading', 255)->nullable()->after('name');
            });
        }

        DB::table('gallery_pages')
            ->whereNull('heading')
            ->update(['heading' => '製作事例紹介']);
    }

    public function down(): void
    {
        if (Schema::hasTable('gallery_pages') && Schema::hasColumn('gallery_pages', 'heading')) {
            Schema::table('gallery_pages', function (Blueprint $table): void {
                $table->dropColumn('heading');
            });
        }
    }
};
