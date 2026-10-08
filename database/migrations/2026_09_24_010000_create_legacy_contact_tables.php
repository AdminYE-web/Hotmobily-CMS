<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The original admin contact pages use these HM_* tables.  The guards
     * deliberately leave an imported legacy schema untouched.
     */
    public function up(): void
    {
        if (! Schema::hasTable('HM_contact_customer')) {
            Schema::create('HM_contact_customer', function (Blueprint $table): void {
                $table->string('id', 100)->primary();
                $table->dateTime('date_create')->nullable()->index();
                $table->string('inquiry', 255)->nullable()->index();
                $table->string('email', 255)->nullable()->index();
                $table->string('file_update', 500)->nullable();
                $table->text('note')->nullable();
                $table->string('name', 255)->nullable();
                $table->string('name_k', 255)->nullable();
                $table->string('corp_name', 255)->nullable();
                $table->string('corp_names', 255)->nullable();
                $table->string('signature', 255)->nullable();
                $table->string('tel', 100)->nullable();
                $table->string('province', 255)->nullable();
                $table->text('address')->nullable();
                $table->string('zip_code', 50)->nullable();
            });
        }

        if (! Schema::hasTable('HM_contact_status_setup')) {
            Schema::create('HM_contact_status_setup', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('details', 255);
            });

            DB::table('HM_contact_status_setup')->insert([
                ['id' => 1, 'details' => 'New'],
                ['id' => 2, 'details' => 'In progress'],
                ['id' => 3, 'details' => 'Closed'],
            ]);
        }

        if (! Schema::hasTable('HM_contact_status')) {
            Schema::create('HM_contact_status', function (Blueprint $table): void {
                $table->string('contact_id', 100)->primary();
                $table->unsignedInteger('status')->index();
                $table->dateTime('date_modify')->nullable()->index();
                $table->index('contact_id');
            });
        }

        if (! Schema::hasTable('HM_contact_replied')) {
            Schema::create('HM_contact_replied', function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('contact_id', 100)->index();
                $table->string('sale_name', 255)->nullable();
                $table->string('subject', 255)->nullable();
                $table->longText('content')->nullable();
                $table->dateTime('date_create')->nullable()->index();
            });
        }

        if (! Schema::hasTable('HM_log')) {
            Schema::create('HM_log', function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('user', 255)->nullable();
                $table->text('detail')->nullable();
                $table->dateTime('date_create')->nullable()->index();
            });
        }
    }

    /**
     * Do not drop a legacy table on rollback: this migration may have skipped
     * creation because the tables were imported from the original system.
     */
    public function down(): void
    {
        // Intentionally left empty to protect imported HM_* contact data.
    }
};
