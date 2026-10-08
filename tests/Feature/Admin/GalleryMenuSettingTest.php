<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\GalleryMenuItem;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class GalleryMenuSettingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('admin', function (Blueprint $table): void {
            $table->string('user', 50)->primary();
            $table->string('pass', 255)->nullable();
            $table->string('dept', 50)->nullable();
            $table->text('lang')->nullable();
            $table->string('staff_name', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('token', 100)->nullable();
            $table->dateTime('token_expire')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->smallInteger('super_admin')->nullable();
        });

        Schema::create('gallery_pages', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 150);
            $table->string('heading', 255)->nullable();
            $table->string('slug', 100)->unique();
            $table->string('public_slug', 100)->unique();
            $table->string('gallery_type', 50)->unique();
            $table->string('media_directory', 255)->default('gallery/uploads');
            $table->string('legacy_extension', 10)->nullable();
            $table->boolean('show_website')->default(true);
            $table->boolean('show_tags')->default(true);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        foreach ([
            ['Gallery Alpha', 'gallery-alpha', 'gallery_alpha', 'gallery_alpha'],
            ['Gallery Beta', 'gallery-beta', 'gallery_beta', 'gallery_beta'],
        ] as [$name, $slug, $publicSlug, $type]) {
            \DB::table('gallery_pages')->insert([
                'name' => $name,
                'slug' => $slug,
                'public_slug' => $publicSlug,
                'gallery_type' => $type,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $migration = require database_path('migrations/2026_10_01_000100_create_gallery_menu_items_table.php');
        $migration->up();
    }

    public function test_admin_can_drag_gallery_menu_rows_and_persist_the_order(): void
    {
        $admin = Admin::query()->create([
            'user' => 'gallery-menu-admin',
            'email' => 'gallery-menu-admin@example.test',
            'pass' => 'password',
            'dept' => 'admin',
            'super_admin' => 1,
        ]);

        $first = GalleryMenuItem::query()->create([
            'name' => 'Alpha',
            'gallery_page_id' => 1,
            'sort_order' => 10,
        ]);
        $second = GalleryMenuItem::query()->create([
            'name' => 'Beta',
            'gallery_page_id' => 2,
            'sort_order' => 20,
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.gallery-menu.index'))
            ->assertOk()
            ->assertSee('draggable="true"', false);

        $this->actingAs($admin, 'admin')
            ->postJson(route('admin.gallery-menu.reorder'), [
                'order' => [$second->id, $first->id],
            ])
            ->assertOk()
            ->assertJson(['message' => 'Gallery menu order saved.']);

        $this->assertSame(
            [$second->id, $first->id],
            GalleryMenuItem::query()->orderBy('sort_order')->pluck('id')->all()
        );
    }
}
