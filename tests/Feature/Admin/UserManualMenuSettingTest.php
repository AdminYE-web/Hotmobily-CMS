<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\UserManualMenuItem;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UserManualMenuSettingTest extends TestCase
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

        Schema::create('custom_page_layouts', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('status')->default('draft');
            $table->json('published_layout_json')->nullable();
            $table->timestamps();
        });

        Schema::create('custom_pages', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('custom_page_layout_id')->nullable();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('status')->default('draft');
            $table->json('published_content_json')->nullable();
            $table->timestamps();
        });

        DB::table('custom_page_layouts')->insert([
            ['name' => 'Layout Alpha', 'slug' => 'layout-alpha', 'status' => 'active', 'published_layout_json' => '{"rows":[]}', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Layout Beta', 'slug' => 'layout-beta', 'status' => 'active', 'published_layout_json' => '{"rows":[]}', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('custom_pages')->insert([
            ['custom_page_layout_id' => 1, 'name' => 'Custom Page Alpha', 'slug' => 'custom-page-alpha', 'status' => 'active', 'published_content_json' => '{"blocks":[]}', 'created_at' => now(), 'updated_at' => now()],
            ['custom_page_layout_id' => 2, 'name' => 'Custom Page Beta', 'slug' => 'custom-page-beta', 'status' => 'active', 'published_content_json' => '{"blocks":[]}', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $migration = require database_path('migrations/2026_10_01_000300_create_user_manual_menu_items_table.php');
        $migration->up();
    }

    public function test_admin_can_manage_user_manual_custom_page_links_and_keep_the_fixed_guide_link(): void
    {
        $admin = Admin::query()->create([
            'user' => 'user-manual-menu-admin',
            'email' => 'user-manual-menu-admin@example.test',
            'pass' => 'password',
            'dept' => 'admin',
            'super_admin' => 1,
        ]);

        $first = UserManualMenuItem::query()->create([
            'name' => 'Alpha',
            'custom_page_id' => 1,
            'sort_order' => 10,
        ]);
        $second = UserManualMenuItem::query()->create([
            'name' => 'Beta',
            'custom_page_id' => 2,
            'sort_order' => 20,
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.user-manual-menu.index'))
            ->assertOk()
            ->assertSee('draggable="true"', false);

        $this->actingAs($admin, 'admin')
            ->postJson(route('admin.user-manual-menu.reorder'), [
                'order' => [$second->id, $first->id],
            ])
            ->assertOk()
            ->assertJson(['message' => 'User Manual menu order saved.']);

        $navigation = view('partials.legacy-navigation')->render();
        $guidePosition = strpos($navigation, 'href="/guide/">ご利用ガイド</a>');
        $betaLinkPosition = strpos($navigation, '>Beta</a>');
        $alphaLinkPosition = strpos($navigation, '>Alpha</a>');

        $this->assertIsInt($guidePosition);
        $this->assertIsInt($betaLinkPosition);
        $this->assertIsInt($alphaLinkPosition);
        $this->assertLessThan($betaLinkPosition, $guidePosition);
        $this->assertLessThan($alphaLinkPosition, $betaLinkPosition);
        $this->assertStringNotContainsString('/lp/school-01.php', $navigation);
    }
}
