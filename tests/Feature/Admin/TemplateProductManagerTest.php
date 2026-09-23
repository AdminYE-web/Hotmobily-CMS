<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\TemplateProduct;
use App\Support\LegacyTemplateImporter;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TemplateProductManagerTest extends TestCase
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

        $migration = require database_path('migrations/2026_09_21_060000_create_template_manager_tables.php');
        $migration->up();
    }

    public function test_admin_can_create_nested_template_product_with_multiple_download_buttons(): void
    {
        $admin = $this->admin();
        $createdPaths = [];

        try {
            $this->actingAs($admin, 'admin')
                ->post(route('admin.template-products.store'), [
                    'name' => 'めじるしチャーム',
                    'sort_order' => 10,
                    'is_active' => 1,
                    'blocks' => [
                        'block_1' => [
                            'heading' => 'めじるしチャーム【Illustrator／Photoshop】',
                            'rows' => [
                                'row_1' => [
                                    'size_template' => '50mm×50mm',
                                    'downloads' => [
                                        'download_1' => [
                                            'button_label' => 'テンプレートダウンロードai',
                                            'file' => UploadedFile::fake()->create('template.ai', 5, 'application/pdf'),
                                        ],
                                        'download_2' => [
                                            'button_label' => 'テンプレートダウンロードpsd',
                                            'file' => UploadedFile::fake()->create('template.psd', 5, 'application/octet-stream'),
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ])
                ->assertRedirect(route('admin.template-products.index'));

            $product = TemplateProduct::query()->with('blocks.rows.downloads')->firstOrFail();
            $downloads = $product->blocks->first()->rows->first()->downloads;
            $createdPaths = $downloads->pluck('file_path')->all();

            $this->assertSame('めじるしチャーム', $product->name);
            $this->assertCount(2, $downloads);
            $this->assertSame('50mm×50mm', $product->blocks->first()->rows->first()->size_template);

            foreach ($createdPaths as $path) {
                $this->assertFileExists(public_path(ltrim($path, '/')));
            }

            $this->actingAs($admin, 'admin')
                ->get(route('admin.template-products.index'))
                ->assertOk()
                ->assertSee('めじるしチャーム')
                ->assertSee('<th>No.</th>', false)
                ->assertSee('<span class="template-product-order">1</span>', false)
                ->assertSee('Template Management');

            $this->actingAs($admin, 'admin')
                ->get(route('admin.template-products.edit', $product))
                ->assertOk()
                ->assertSee('+ Add block')
                ->assertSee('+ Add size row')
                ->assertSee('+ Add upload button');
        } finally {
            foreach ($createdPaths as $path) {
                File::delete(public_path(ltrim($path, '/')));
            }
        }
    }

    public function test_public_template_page_renders_managed_blocks_rows_and_downloads(): void
    {
        $product = TemplateProduct::query()->create([
            'name' => 'Managed Product',
            'sort_order' => 10,
            'is_active' => true,
        ]);
        $block = $product->blocks()->create([
            'heading' => 'Managed Product【Illustrator／Photoshop】',
            'sort_order' => 10,
        ]);
        $row = $block->rows()->create([
            'size_template' => '75mm×75mm',
            'sort_order' => 10,
        ]);
        $row->downloads()->create([
            'button_label' => 'Download AI',
            'file_path' => '/template/uploads/example.ai',
            'sort_order' => 10,
        ]);

        $this->get('/template/')
            ->assertOk()
            ->assertSee('Managed Product')
            ->assertSee('Managed Product【Illustrator／Photoshop】')
            ->assertSee('75mm×75mm')
            ->assertSee('Download AI')
            ->assertSee('/template/uploads/example.ai', false);
    }

    public function test_original_template_catalog_can_be_imported_once(): void
    {
        $firstImport = app(LegacyTemplateImporter::class)->import();
        $secondImport = app(LegacyTemplateImporter::class)->import();

        $this->assertGreaterThan(50, $firstImport['products']);
        $this->assertGreaterThan(100, $firstImport['downloads']);
        $this->assertSame(0, $secondImport['products']);
        $this->assertSame($firstImport['products'], TemplateProduct::query()->count());
    }

    public function test_admin_can_save_product_order_after_dragging_rows(): void
    {
        $admin = $this->admin();
        $first = TemplateProduct::query()->create([
            'name' => 'First',
            'sort_order' => 10,
            'is_active' => true,
        ]);
        $second = TemplateProduct::query()->create([
            'name' => 'Second',
            'sort_order' => 20,
            'is_active' => true,
        ]);

        $this->actingAs($admin, 'admin')
            ->postJson(route('admin.template-products.reorder'), [
                'order' => [$second->id, $first->id],
            ])
            ->assertOk()
            ->assertJson(['ok' => true]);

        $this->assertSame(10, $second->fresh()->sort_order);
        $this->assertSame(20, $first->fresh()->sort_order);
    }

    private function admin(): Admin
    {
        return Admin::query()->create([
            'user' => 'template-admin',
            'email' => 'template-admin@example.test',
            'pass' => 'password',
            'dept' => 'admin',
            'super_admin' => 1,
        ]);
    }
}
