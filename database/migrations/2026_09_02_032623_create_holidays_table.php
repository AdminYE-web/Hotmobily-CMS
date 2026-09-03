<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
     Schema::create('holidays', function (Blueprint $table) {

    $table->id();

    $table->date('holiday_date');

    $table->string('holiday_type', 20);

    // normal / cloth / both
    $table->string('calendar_type', 20)
        ->default('normal');

    $table->string('title')
        ->nullable();

    $table->string('created_by')
        ->nullable();

    $table->timestamps();

    $table->index('holiday_date');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holidays');
    }
};
