<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('products') || Schema::hasColumn('products', 'price_display_type')) {
            return;
        }

        Schema::table('products', function (Blueprint $table): void {
            $table->string('price_display_type', 20)->default('with_tax');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('products') || ! Schema::hasColumn('products', 'price_display_type')) {
            return;
        }

        Schema::table('products', function (Blueprint $table): void {
            $table->dropColumn('price_display_type');
        });
    }
};
