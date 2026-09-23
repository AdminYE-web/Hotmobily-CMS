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
            || ! Schema::hasTable('gallery_pages')
            || ! Schema::hasTable('hm_acrylic_gallery')
        ) {
            return;
        }

        $legacyColumn = DB::selectOne(<<<'SQL'
            SELECT CHARACTER_SET_NAME AS character_set, COLLATION_NAME AS collation_name
            FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME = 'hm_acrylic_gallery'
              AND COLUMN_NAME = 'type'
            LIMIT 1
        SQL);

        $characterSet = (string) ($legacyColumn?->character_set ?? '');
        $collation = (string) ($legacyColumn?->collation_name ?? '');

        if (
            preg_match('/^[A-Za-z0-9_]+$/', $characterSet) !== 1
            || preg_match('/^[A-Za-z0-9_]+$/', $collation) !== 1
        ) {
            return;
        }

        DB::statement(sprintf(
            'ALTER TABLE `gallery_pages` MODIFY `gallery_type` VARCHAR(50) CHARACTER SET %s COLLATE %s NOT NULL',
            $characterSet,
            $collation
        ));
    }

    public function down(): void
    {
        // Keep the compatible collation; reverting it would restore the
        // illegal-mix error on legacy databases.
    }
};
