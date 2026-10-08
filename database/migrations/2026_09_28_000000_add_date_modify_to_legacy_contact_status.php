<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('HM_contact_status')
            && ! Schema::hasColumn('HM_contact_status', 'date_modify')) {
            Schema::table('HM_contact_status', function (Blueprint $table): void {
                $table->dateTime('date_modify')->nullable()->index();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('HM_contact_status')
            && Schema::hasColumn('HM_contact_status', 'date_modify')) {
            Schema::table('HM_contact_status', function (Blueprint $table): void {
                $table->dropColumn('date_modify');
            });
        }
    }
};
