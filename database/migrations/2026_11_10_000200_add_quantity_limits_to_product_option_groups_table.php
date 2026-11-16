<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_option_groups', function (Blueprint $table): void {
            $table->unsignedInteger('quantity_min')->nullable();
            $table->unsignedInteger('quantity_max')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('product_option_groups', function (Blueprint $table): void {
            $table->dropColumn(['quantity_min', 'quantity_max']);
        });
    }
};
