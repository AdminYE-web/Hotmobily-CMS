<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_banners', function (Blueprint $table): void {
            $table->id();
            $table->string('image_path');
            $table->string('mobile_image_path')->nullable();
            $table->string('alt_text')->nullable();
            $table->text('link_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        $now = now();
        DB::table('home_banners')->insert([
            [
                'image_path' => '/img/banner_tapestry_up to 3_button_pc.webp',
                'mobile_image_path' => '/img/banner_tapestry_up to 3_button_mobile.webp',
                'link_url' => 'https://hotmobily.jp/products/tapestry/',
                'alt_text' => 'Tapestry product banner',
                'sort_order' => 10,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'image_path' => '/products/images/high-impact_webp.webp',
                'mobile_image_path' => '/products/images/high-impact_mobile.webp',
                'link_url' => '/products/rubberstrap/',
                'alt_text' => 'Rubber strap product banner',
                'sort_order' => 20,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'image_path' => '/img/stain-resistant-coating-banner.webp',
                'mobile_image_path' => '/img/stain-resistant-coating-banner.webp',
                'link_url' => '/faq/details/rubberstrap/q4',
                'alt_text' => 'Stain resistant coating information banner',
                'sort_order' => 30,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('home_banners');
    }
};
