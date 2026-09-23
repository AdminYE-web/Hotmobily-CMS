<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            ! Schema::hasTable('gallery_pages')
            || Schema::hasColumn('gallery_pages', 'show_tags')
        ) {
            return;
        }

        Schema::table('gallery_pages', function (Blueprint $table): void {
            $table->boolean('show_tags')->default(true)->after('show_website');
        });
    }

    public function down(): void
    {
        // Preserve page settings if migrations are rolled back.
    }
};
