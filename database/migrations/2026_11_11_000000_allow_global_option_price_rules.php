<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('option_price_rules', function (Blueprint $table): void {
            $table->unsignedBigInteger('product_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        if (DB::table('option_price_rules')->whereNull('product_id')->exists()) {
            throw new RuntimeException('Assign global Option Price Rules to products before rolling back this migration.');
        }
        Schema::table('option_price_rules', function (Blueprint $table): void {
            $table->unsignedBigInteger('product_id')->nullable(false)->change();
        });
    }
};
