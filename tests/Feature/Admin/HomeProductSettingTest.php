<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\HomeProductCard;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomeProductSettingTest extends TestCase
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

        Schema::create('product_layouts', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('status')->default('active');
            $table->json('published_layout_json')->nullable();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('status')->default('draft');
            $table->unsignedBigInteger('product_layout_id')->nullable();
            $table->timestamps();
        });

        Schema::create('product_pages', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('product_id')->unique();
            $table->json('published_content_json')->nullable();
            $table->timestamps();
        });

        DB::table('product_layouts')->insert([
            'name' => 'Published Layout',
            'slug' => 'published-layout',
            'status' => 'active',
            'published_layout_json' => '{"rows":[]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('products')->insert([
            'name' => 'Rubber Strap',
            'slug' => 'rubberstrap',
            'status' => 'active',
            'product_layout_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('product_pages')->insert([
            'product_id' => 1,
            'published_content_json' => '{"blocks":[]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $migration = require database_path('migrations/2026_10_01_000600_create_home_product_cards_table.php');
        $migration->up();
        Storage::fake('public');
    }

    public function test_admin_can_manage_a_rich_product_card_and_render_it_on_the_homepage(): void
    {
        $admin = Admin::query()->create([
            'user' => 'home-product-admin',
            'email' => 'home-product-admin@example.test',
            'pass' => 'password',
            'dept' => 'admin',
            'super_admin' => 1,
        ]);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.home-settings.products.store'), [
                'product_id' => 1,
                'name' => 'Home Strap Title',
                'description_html' => '<p>Soft rubber detail</p><script>alert(1)</script>',
                'features_html' => '<p><span style="color:#ffe300">126円～</span></p><p>2週間納品</p>',
                'image' => UploadedFile::fake()->image('home-strap.png'),
            ])
            ->assertRedirect(route('admin.home-settings.products.index'));

        $card = HomeProductCard::query()->firstOrFail();
        $this->assertSame(1, (int) $card->product_id);
        $this->assertStringContainsString('Soft rubber detail', $card->description_html);
        $this->assertStringNotContainsString('<script', $card->description_html);
        Storage::disk('public')->assertExists($card->image_path);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.home-settings.products.index'))
            ->assertOk()
            ->assertSee('Home Strap Title')
            ->assertSee('/products/rubberstrap');

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Home Strap Title')
            ->assertSee('Soft rubber detail')
            ->assertSee('126円～');
    }
}
