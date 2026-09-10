<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the legacy-compatible reviews_hm table inside the new Laravel
     * application's database. The table name and columns remain compatible
     * with the old importer, but this database is fully owned by Laravel.
     */
    public function up(): void
    {
        if (Schema::hasTable('reviews_hm')) {
            return;
        }

        Schema::create('reviews_hm', function (Blueprint $table): void {
            $table->increments('id');
            $table->text('comment')->nullable();
            $table->integer('service')->nullable();
            $table->integer('product')->nullable();
            $table->string('product_type', 100)->nullable();
            $table->text('images')->nullable();
            $table->text('sale_name')->nullable();
            $table->dateTime('date_reviews')->nullable();
            $table->integer('row_stamp')->nullable();
        });
    }

    /**
     * Drop the new application's review table.
     */
    public function down(): void
    {
        // The review table may already contain imported customer data.
        // Keep it intact when rolling back application migrations.
    }
};
