<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\SideMenuLinkItem;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SideMenuLinkSettingTest extends TestCase
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

        $migration = require database_path('migrations/2026_10_01_000500_create_side_menu_link_items_table.php');
        $migration->up();
        Storage::fake('public');
    }

    public function test_admin_can_create_links_upload_images_reorder_and_show_them_in_the_sidebar(): void
    {
        $admin = Admin::query()->create([
            'user' => 'side-menu-link-admin',
            'email' => 'side-menu-link-admin@example.test',
            'pass' => 'password',
            'dept' => 'admin',
            'super_admin' => 1,
        ]);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.side-menu.links.store'), [
                'name' => 'Meeting Appointment',
                'url' => '/meeting_date/',
                'image' => UploadedFile::fake()->image('meeting.png'),
            ])
            ->assertRedirect(route('admin.side-menu.links.index'));

        $this->actingAs($admin, 'admin')
            ->post(route('admin.side-menu.links.store'), [
                'name' => 'Production Details',
                'url' => 'https://example.test/production',
                'image' => UploadedFile::fake()->image('production.png'),
            ])
            ->assertRedirect(route('admin.side-menu.links.index'));

        $items = SideMenuLinkItem::query()->orderBy('id')->get();
        $this->assertCount(2, $items);
        Storage::disk('public')->assertExists($items[0]->image_path);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.side-menu.links.store'), [
                'name' => 'Unsafe link',
                'url' => 'javascript:alert(1)',
                'image' => UploadedFile::fake()->image('unsafe.png'),
            ])
            ->assertSessionHasErrors('url');

        $this->actingAs($admin, 'admin')
            ->postJson(route('admin.side-menu.links.reorder'), [
                'order' => [$items[1]->id, $items[0]->id],
            ])
            ->assertOk()
            ->assertJson(['message' => 'Side menu link order saved.']);

        $this->assertSame($items[1]->id, DB::table('side_menu_link_items')->orderBy('sort_order')->value('id'));

        $this->actingAs($admin, 'admin')
            ->get(route('admin.side-menu.links.index'))
            ->assertOk()
            ->assertSee('draggable="true"', false)
            ->assertSee('Meeting Appointment');

        $sidebar = view('partials.legacy-sidebar')->render();
        $this->assertStringContainsString('Meeting Appointment', $sidebar);
        $this->assertStringContainsString('/meeting_date/', $sidebar);
        $this->assertStringNotContainsString('/blog-content/lists', $sidebar);
        $this->assertStringNotContainsString('/production/', $sidebar);
    }
}
