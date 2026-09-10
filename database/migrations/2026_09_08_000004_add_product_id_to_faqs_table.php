<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            !Schema::hasTable('faqs')
            || Schema::hasColumn('faqs', 'product_id')
        ) {
            return;
        }

        Schema::table('faqs', function (Blueprint $table): void {
            $table
                ->foreignId('product_id')
                ->nullable()
                ->after('entry_type')
                ->constrained('faqs')
                ->nullOnDelete();
        });

        $productEntries = DB::table('faqs')
            ->where('entry_type', 'product')
            ->where('category', 'product')
            ->orderBy('id')
            ->get([
                'id',
                'material',
            ]);

        $faqEntries = DB::table('faqs')
            ->where('entry_type', 'faq')
            ->where('category', 'product')
            ->whereNull('product_id')
            ->orderBy('id')
            ->get([
                'id',
                'material',
            ]);

        foreach ($faqEntries as $faqEntry) {
            $productEntry = $productEntries->first(
                fn (object $product): bool => strcasecmp(
                    trim((string) $product->material),
                    trim((string) $faqEntry->material)
                ) === 0
            );

            if ($productEntry) {
                DB::table('faqs')
                    ->where('id', $faqEntry->id)
                    ->update([
                        'product_id' => $productEntry->id,
                    ]);
            }
        }
    }

    public function down(): void
    {
        if (
            Schema::hasTable('faqs')
            && Schema::hasColumn('faqs', 'product_id')
        ) {
            Schema::table('faqs', function (Blueprint $table): void {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            });
        }
    }
};
