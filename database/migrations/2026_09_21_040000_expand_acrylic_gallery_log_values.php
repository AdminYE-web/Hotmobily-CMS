<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            DB::connection()->getDriverName() !== 'mysql'
            || ! Schema::hasTable('hm_acrylic_gallery_log')
        ) {
            return;
        }

        // Legacy installations may have created these columns as VARCHAR.
        // Gallery image lists and rich text values must be stored without truncation.
        DB::statement(<<<'SQL'
            ALTER TABLE `hm_acrylic_gallery_log`
                MODIFY `old` TEXT NULL,
                MODIFY `new` TEXT NULL
        SQL);
    }

    public function down(): void
    {
        // Keep the wider columns on rollback so existing history is never truncated.
    }
};
