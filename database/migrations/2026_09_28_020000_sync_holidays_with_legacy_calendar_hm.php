<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const IMPORT_MARKER = 'legacy-calendarHM.sql';

    public function up(): void
    {
        if (! Schema::hasTable('holidays')) {
            return;
        }

        $rows = [
            ['holiday_date' => '2024-12-31', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-01-01', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-01-02', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-01-03', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-01-13', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-01-25', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-01-27', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-01-28', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-01-29', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-01-30', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-01-31', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-02-01', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-02-03', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-02-04', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-02-05', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-02-06', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-02-11', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-02-23', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-02-24', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-03-20', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-04-03', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-04-04', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-04-05', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-04-29', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-05-01', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-05-02', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-05-03', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-05-04', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-05-05', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-05-06', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-05-07', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-05-31', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-06-02', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-07-21', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-08-11', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-08-14', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-08-15', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-09-15', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-09-23', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-10-01', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-10-02', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-10-03', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-10-04', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-10-06', 'holiday_type' => 'type3'],
            ['holiday_date' => '2025-10-13', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-11-03', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-11-23', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-11-24', 'holiday_type' => 'type2'],
            ['holiday_date' => '2025-12-31', 'holiday_type' => 'type2'],
            ['holiday_date' => '2026-01-01', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-01-02', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-01-03', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-01-12', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-02-11', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-02-13', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-02-14', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-02-16', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-02-17', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-02-18', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-02-19', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-02-20', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-02-21', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-02-23', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-02-24', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-02-25', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-03-20', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-04-04', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-04-29', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-05-01', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-05-02', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-05-04', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-05-05', 'holiday_type' => 'type2'],
            ['holiday_date' => '2026-05-06', 'holiday_type' => 'type2'],
            ['holiday_date' => '2026-05-07', 'holiday_type' => 'type2'],
            ['holiday_date' => '2026-06-19', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-07-20', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-08-11', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-08-13', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-08-14', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-08-15', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-09-21', 'holiday_type' => 'type2'],
            ['holiday_date' => '2026-09-22', 'holiday_type' => 'type2'],
            ['holiday_date' => '2026-09-23', 'holiday_type' => 'type2'],
            ['holiday_date' => '2026-09-25', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-09-26', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-10-01', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-10-02', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-10-03', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-10-05', 'holiday_type' => 'type3'],
            ['holiday_date' => '2026-10-12', 'holiday_type' => 'type2'],
        ];

        $rows = array_map(
            static fn (array $row): array => $row + [
                'calendar_type' => 'both',
                'title' => null,
                'created_by' => self::IMPORT_MARKER,
            ],
            $rows
        );

        DB::transaction(function () use ($rows): void {
            DB::table('holidays')->delete();
            DB::table('holidays')->insert($rows);
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('holidays')) {
            return;
        }

        DB::table('holidays')
            ->where('created_by', self::IMPORT_MARKER)
            ->delete();
    }
};
