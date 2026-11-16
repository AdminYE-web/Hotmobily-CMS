<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('holidays')
            ->where('calendar_type', '!=', 'normal')
            ->update(['calendar_type' => 'normal']);
    }

    public function down(): void
    {
        // Original calendar types cannot be reconstructed after normalization.
    }
};
