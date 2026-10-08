<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Store meeting-date requests separately from the legacy contact tables.
     * The original meeting_date form only sent an email, so this table gives
     * the new admin screen a durable record to review.
     */
    public function up(): void
    {
        if (Schema::hasTable('HM_meeting_date')) {
            return;
        }

        Schema::create('HM_meeting_date', function (Blueprint $table): void {
            $table->string('id', 100)->primary();
            $table->dateTime('date_create')->nullable()->index();
            $table->dateTime('date_modify')->nullable()->index();
            $table->string('status', 50)->default('New')->index();

            $table->string('cont_type', 100)->nullable();
            $table->string('company_name', 255)->nullable();
            $table->string('person_name', 255)->nullable();
            $table->string('department', 255)->nullable();
            $table->string('zip', 50)->nullable();
            $table->string('prefc', 255)->nullable();
            $table->text('address')->nullable();
            $table->string('address_street', 500)->nullable();
            $table->string('phone_number', 100)->nullable();
            $table->string('email', 255)->nullable()->index();
            $table->string('email_confirm', 255)->nullable();

            $table->string('expected_product', 255)->nullable();
            $table->string('qty', 100)->nullable();
            $table->string('expected_price', 100)->nullable();
            $table->date('expected_delivery_date')->nullable();
            $table->date('visit_date_1')->nullable();
            $table->string('visit_time_1', 10)->nullable();
            $table->date('visit_date_2')->nullable();
            $table->string('visit_time_2', 10)->nullable();
            $table->longText('contact_detail')->nullable();

            $table->dateTime('mail_sent_at')->nullable();
            $table->text('mail_error')->nullable();
        });
    }

    /**
     * Keep the table on rollback because it can contain customer requests.
     */
    public function down(): void
    {
        // Intentionally left empty to protect meeting-date submissions.
    }
};
