<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_options', function (Blueprint $table): void {
            $table->uuid('bulk_upload_key')->nullable()->unique();
        });
    }

    public function down(): void
    {
        Schema::table('product_options', function (Blueprint $table): void {
            $table->dropUnique(['bulk_upload_key']);
            $table->dropColumn('bulk_upload_key');
        });
    }
};
