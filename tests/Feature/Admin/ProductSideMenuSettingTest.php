<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\ProductSideMenuItem;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductSideMenuSettingTest extends TestCase
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

        Schema::create('products', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('status')->default('draft');
            $table->unsignedBigInteger('product_layout_id')->nullable();
            $table->timestamps();
        });

        Schema::create('product_layouts', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('status')->default('active');
            $table->json('published_layout_json')->nullable();
            $table->timestamps();
        });

        Schema::create('product_pages', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('product_id')->unique();
            $table->json('published_content_json')->nullable();
            $table->timestamps();
        });

        DB::table('products')->insert([
            ['name' => 'Rubber Strap', 'slug' => 'rubberstrap', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Acrylic Stand', 'slug' => 'acrylic/figure', 'status' => 'draft', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('product_layouts')->insert([
            'name' => 'Published Product Layout',
            'slug' => 'published-product-layout',
            'status' => 'active',
            'published_layout_json' => '{"rows":[]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('products')->where('id', 1)->update(['product_layout_id' => 1]);
        DB::table('product_pages')->insert([
            'product_id' => 1,
            'published_content_json' => '{"blocks":[]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $migration = require database_path('migrations/2026_10_01_000400_create_product_side_menu_items_table.php');
        $migration->up();
        Storage::fake('public');
    }

    public function test_admin_can_create_and_reorder_product_side_menu_items(): void
    {
        $admin = Admin::query()->create([
            'user' => 'product-side-menu-admin',
            'email' => 'product-side-menu-admin@example.test',
            'pass' => 'password',
            'dept' => 'admin',
            'super_admin' => 1,
        ]);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.side-menu.products.store'), [
                'name' => 'Strap Menu',
                'product_id' => 1,
                'image' => UploadedFile::fake()->image('strap.png'),
            ])
            ->assertRedirect(route('admin.side-menu.products.index'));

        $this->actingAs($admin, 'admin')
            ->post(route('admin.side-menu.products.store'), [
                'name' => 'Acrylic Menu',
                'product_id' => 2,
                'image' => UploadedFile::fake()->image('acrylic.png'),
            ])
            ->assertRedirect(route('admin.side-menu.products.index'));

        $items = ProductSideMenuItem::query()->orderBy('id')->get();
        $this->assertCount(2, $items);
        Storage::disk('public')->assertExists($items[0]->image_path);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.side-menu.products.index'))
            ->assertOk()
            ->assertSee('Strap Menu')
            ->assertSee('draggable="true"', false);

        $this->actingAs($admin, 'admin')
            ->postJson(route('admin.side-menu.products.reorder'), [
                'order' => [$items[1]->id, $items[0]->id],
            ])
            ->assertOk()
            ->assertJson(['message' => 'Product side menu order saved.']);

        $this->assertSame($items[1]->id, ProductSideMenuItem::query()->orderBy('sort_order')->value('id'));

        $sidebar = view('partials.legacy-sidebar')->render();
        $this->assertStringContainsString('Strap Menu', $sidebar);
        $this->assertStringContainsString('/products/rubberstrap', $sidebar);
        $this->assertStringNotContainsString('/products/acrylic/figure', $sidebar);
        $this->assertStringNotContainsString('/all-marker-products.php', $sidebar);
    }
}
