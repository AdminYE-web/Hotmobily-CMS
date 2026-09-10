<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('reviews_ans_hm')) {
            return;
        }

        Schema::create('reviews_ans_hm', function (Blueprint $table): void {
            $table->increments('id');
            $table->integer('review_id');
            $table->text('ans_txt')->nullable();
            $table->text('ans_name')->nullable();
            $table->dateTime('date_create')->nullable();
            $table->index('review_id');
        });
    }

    public function down(): void
    {
        // Preserve imported customer-response data when rolling back.
    }
};
