<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('gallery_menu_items')) {
            Schema::create('gallery_menu_items', function (Blueprint $table): void {
                $table->id();
                $table->string('name', 255);
                $table->foreignId('gallery_page_id')
                    ->unique()
                    ->constrained('gallery_pages')
                    ->cascadeOnDelete();
                $table->unsignedInteger('sort_order')->default(0)->index();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('gallery_pages') || DB::table('gallery_menu_items')->exists()) {
            return;
        }

        $legacyItems = [
            ['rubberstrap', 'ラバーストラップ'],
            ['rubberkeyholder', 'ラバーキーホルダー'],
            ['rubbercoaster', 'ラバーコースター'],
            ['acrylic_key', 'アクリルキーホルダー'],
            ['acrylic_standee', 'アクリルフィギュアスタンド'],
            ['acrylic_hair', 'アクリルヘアバンド'],
            ['cableholder', 'ラバーイヤホンホルダー'],
            ['wappen', 'オリジナルワッペン'],
        ];

        $now = now();

        foreach ($legacyItems as $index => [$publicSlug, $name]) {
            $pageId = DB::table('gallery_pages')
                ->where('public_slug', $publicSlug)
                ->value('id');

            if ($pageId === null) {
                continue;
            }

            DB::table('gallery_menu_items')->insert([
                'name' => $name,
                'gallery_page_id' => $pageId,
                'sort_order' => ($index + 1) * 10,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        // Preserve administrator-managed navigation settings on rollback.
    }
};
