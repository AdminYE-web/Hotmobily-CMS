<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (
            !Schema::hasTable('faqs')
            || !Schema::hasColumn('faqs', 'entry_type')
        ) {
            return;
        }

        $legacyRows = DB::table('faqs')
            ->where('category', 'product')
            ->where('entry_type', 'faq')
            ->where(function ($query): void {
                $query
                    ->where(function ($query): void {
                        $query
                            ->whereNotNull('question_name')
                            ->where('question_name', '<>', '');
                    })
                    ->orWhere(function ($query): void {
                        $query
                            ->whereNotNull('product_link')
                            ->where('product_link', '<>', '');
                    })
                    ->orWhere(function ($query): void {
                        $query
                            ->whereNotNull('product_link_text')
                            ->where('product_link_text', '<>', '');
                    });
            })
            ->orderBy('id')
            ->get();

        foreach ($legacyRows as $legacyRow) {
            $productExists = DB::table('faqs')
                ->where('category', 'product')
                ->where('entry_type', 'product')
                ->where('material', $legacyRow->material)
                ->where('question_name', $legacyRow->question_name)
                ->exists();

            if (!$productExists) {
                DB::table('faqs')->insert([
                    'category' => 'product',
                    'entry_type' => 'product',
                    'material' => $legacyRow->material,
                    'question_name' => $legacyRow->question_name,
                    'product_link' => $legacyRow->product_link,
                    'product_link_text' => $legacyRow->product_link_text,
                    'question' => '',
                    'answer' => '',
                    'sort_order' => $legacyRow->sort_order,
                    'is_active' => $legacyRow->is_active,
                    'created_at' => $legacyRow->created_at,
                    'updated_at' => $legacyRow->updated_at,
                ]);
            }

            DB::table('faqs')
                ->where('id', $legacyRow->id)
                ->update([
                    'question_name' => null,
                    'product_link' => null,
                    'product_link_text' => null,
                ]);
        }
    }

    public function down(): void
    {
        // The split keeps the original FAQ content and is intentionally not reversed.
    }
};
