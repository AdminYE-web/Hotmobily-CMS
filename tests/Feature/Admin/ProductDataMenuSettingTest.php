<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\ProductDataMenuItem;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProductDataMenuSettingTest extends TestCase
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

        Schema::create('product_data_pages', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('status')->default('draft');
            $table->timestamps();
        });

        \DB::table('product_data_pages')->insert([
            ['name' => 'Product Data Alpha', 'slug' => 'product-data-alpha', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Product Data Beta', 'slug' => 'product-data-beta', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $migration = require database_path('migrations/2026_10_01_000000_create_product_data_menu_items_table.php');
        $migration->up();
    }

    public function test_admin_can_drag_product_data_menu_rows_and_persist_the_order(): void
    {
        $admin = Admin::query()->create([
            'user' => 'product-data-menu-admin',
            'email' => 'product-data-menu-admin@example.test',
            'pass' => 'password',
            'dept' => 'admin',
            'super_admin' => 1,
        ]);

        $first = ProductDataMenuItem::query()->create([
            'name' => 'Alpha',
            'product_data_page_id' => 1,
            'sort_order' => 10,
        ]);
        $second = ProductDataMenuItem::query()->create([
            'name' => 'Beta',
            'product_data_page_id' => 2,
            'sort_order' => 20,
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.product-data-menu.index'))
            ->assertOk()
            ->assertSee('draggable="true"', false);

        $this->actingAs($admin, 'admin')
            ->postJson(route('admin.product-data-menu.reorder'), [
                'order' => [$second->id, $first->id],
            ])
            ->assertOk()
            ->assertJson(['message' => 'Menu order saved.']);

        $this->assertSame(
            [$second->id, $first->id],
            ProductDataMenuItem::query()->orderBy('sort_order')->pluck('id')->all()
        );
    }
}
