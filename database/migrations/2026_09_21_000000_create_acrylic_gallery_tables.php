<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('hm_acrylic_gallery')) {
            Schema::create('hm_acrylic_gallery', function (Blueprint $table): void {
                $table->increments('id');
                $table->text('arr_img')->nullable();
                $table->text('arr_txt1')->nullable();
                $table->text('arr_txt2')->nullable();
                $table->text('arr_txt3')->nullable();
                $table->text('arr_txt4')->nullable();
                $table->string('type', 50)->nullable()->index();
                $table->text('arr_web')->nullable();
                $table->string('created_by', 100)->nullable();
                $table->dateTime('created_at')->nullable();
                $table->boolean('manual_import')->nullable();
            });
        }

        if (! Schema::hasTable('hm_acrylic_gallery_log')) {
            Schema::create('hm_acrylic_gallery_log', function (Blueprint $table): void {
                $table->increments('id');
                $table->unsignedInteger('gallery_id')->index();
                $table->string('product', 50)->nullable();
                $table->string('field', 100)->nullable();
                $table->text('old')->nullable();
                $table->text('new')->nullable();
                $table->string('created_by', 100)->nullable();
                $table->dateTime('created_at')->nullable();
                $table->unsignedInteger('step')->default(1);
            });
        }
    }

    public function down(): void
    {
        // These are legacy-compatible tables and may contain imported
        // production data. Keep them intact on rollback.
    }
};
