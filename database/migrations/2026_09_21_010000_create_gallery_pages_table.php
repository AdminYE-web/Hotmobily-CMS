<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('gallery_pages')) {
            return;
        }

        Schema::create('gallery_pages', function (Blueprint $table): void {
            // Match the original hm_acrylic_gallery table so joins and counts
            // can compare gallery_type with its legacy type column.
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';

            $table->id();
            $table->string('name', 150);
            $table->string('slug', 100)->unique();
            $table->string('public_slug', 100)->unique();
            $table->string('gallery_type', 50)->unique();
            $table->string('media_directory', 255)->default('gallery/uploads');
            $table->string('legacy_extension', 10)->nullable()->default('webp');
            $table->boolean('show_website')->default(true);
            $table->boolean('is_active')->default(true)->index();
            $table->integer('sort_order')->default(0)->index();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        $now = now();

        DB::table('gallery_pages')->insert([
            $this->page('Acrylic Keyholder Gallery', 'acrylic-keyholder', 'acrylic_key', 'keyholder', 'gallery/img-acrylic', 10, $now),
            $this->page('Acrylic Coaster Gallery', 'acrylic-coaster', 'acrylic_coaster', 'coaster', 'gallery/img-acrylic-coaster', 20, $now),
            $this->page('Acrylic Standee Gallery', 'acrylic-standee', 'acrylic_standee', 'standee', 'gallery/img-acrylic', 30, $now),
            $this->page('Acrylic Hair Gallery', 'acrylic-hair', 'acrylic_hair', 'acrylic_hair', 'gallery/img-acrylic', 40, $now),
            $this->page('Acrylic Strap Gallery', 'acrylic-strap', 'acrylic_strap', 'acrylic_strap', 'gallery/img-acrylic', 50, $now, false),
            $this->page('Rubber Strap Gallery', 'rubber-strap', 'rubberstrap', 'rubber_strap', 'gallery/img-rubber', 60, $now),
            $this->page('Rubber Keyholder Gallery', 'rubber-keyholder', 'rubberkeyholder', 'rubber_keyholder', 'gallery/img-rubber', 70, $now),
            $this->page('Rubber Coaster Gallery', 'rubber-coaster', 'rubbercoaster', 'rubber_coaster', 'gallery/img-rubber', 80, $now),
            $this->page('Wappen Gallery', 'wappen', 'wappen', 'wappen', 'gallery/img-wappen', 90, $now),
        ]);
    }

    public function down(): void
    {
        // Gallery page definitions are user-managed content. Preserve them on
        // rollback just as the legacy gallery item tables are preserved.
    }

    /** @return array<string, mixed> */
    private function page(
        string $name,
        string $slug,
        string $publicSlug,
        string $galleryType,
        string $mediaDirectory,
        int $sortOrder,
        mixed $now,
        bool $showWebsite = true
    ): array {
        return [
            'name' => $name,
            'slug' => $slug,
            'public_slug' => $publicSlug,
            'gallery_type' => $galleryType,
            'media_directory' => $mediaDirectory,
            'legacy_extension' => 'webp',
            'show_website' => $showWebsite,
            'is_active' => true,
            'sort_order' => $sortOrder,
            'description' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }
};
