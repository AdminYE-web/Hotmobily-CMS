<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\CustomPage;
use App\Models\CustomPageLayout;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CustomPageTest extends TestCase
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

        $migration = require database_path('migrations/2026_09_21_070000_create_custom_page_tables.php');
        $migration->up();
    }

    public function test_admin_can_create_and_publish_a_custom_page_at_a_custom_slug(): void
    {
        $admin = Admin::query()->create([
            'user' => 'custom-page-admin',
            'email' => 'custom-page-admin@example.test',
            'pass' => 'password',
            'dept' => 'admin',
            'super_admin' => 1,
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.custom-page-layouts.index'))
            ->assertOk()
            ->assertSee('Custom Page Layouts');

        $layoutResponse = $this->actingAs($admin, 'admin')
            ->postJson('/api/v1/admin/custom-page-layouts', [
                'name' => 'How To Design Layout',
                'slug' => 'how-to-design',
                'description' => 'Standalone guide layout',
            ])
            ->assertCreated();

        $layout = CustomPageLayout::query()->firstOrFail();
        $this->actingAs($admin, 'admin')
            ->get(route('admin.custom-page-layouts.builder', $layout))
            ->assertOk()
            ->assertSee('Custom Page Layout Builder')
            ->assertSee('Multi Photo');
        $layoutJson = [
            'rows' => [
                [
                    'id' => 'row_1',
                    'region' => 'before_order',
                    'columns' => [
                        [
                            'id' => 'column_1',
                            'width' => 12,
                            'blocks' => [
                                [
                                    'id' => 'block_1',
                                    'type' => 'heading',
                                    'settings' => [],
                                ],
                                [
                                    'id' => 'block_2',
                                    'type' => 'multi_photo',
                                    'settings' => [],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $this->actingAs($admin, 'admin')
            ->putJson("/api/v1/admin/custom-page-layouts/{$layout->id}/layout", $layoutJson)
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->postJson("/api/v1/admin/custom-page-layouts/{$layout->id}/publish")
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->postJson('/api/v1/admin/custom-pages', [
                'name' => 'How To Design',
                'slug' => '/howtodesign',
                'description' => 'Design guide',
                'meta_keywords' => 'design, guide',
                'meta_description' => 'How to design products.',
                'custom_page_layout_id' => $layout->id,
                'status' => 'draft',
            ])
            ->assertCreated();

        $page = CustomPage::query()->firstOrFail();
        $this->assertSame('howtodesign', $page->slug);

        Storage::fake('public');

        $this->actingAs($admin, 'admin')
            ->postJson("/api/v1/admin/custom-pages/{$page->id}/images", [
                'image' => UploadedFile::fake()->createWithContent(
                    'design.svg',
                    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 10"><path d="M0 0h10v10H0z"/></svg>'
                ),
            ])
            ->assertCreated()
            ->assertJsonPath('data.filename', fn (string $filename): bool => str_ends_with($filename, '.svg'));

        $this->actingAs($admin, 'admin')
            ->get(route('admin.custom-pages.index'))
            ->assertOk()
            ->assertSee('Custom Pages');

        $this->actingAs($admin, 'admin')
            ->get(route('admin.custom-pages.content', $page))
            ->assertOk()
            ->assertSee('Custom Page Content Editor')
            ->assertSee('Add Photo')
            ->assertSee('Zoom Image');

        $this->actingAs($admin, 'admin')
            ->getJson("/api/v1/admin/custom-pages/{$page->id}/content")
            ->assertOk()
            ->assertJsonPath('data.product_layout.name', 'How To Design Layout');

        $this->actingAs($admin, 'admin')
            ->putJson("/api/v1/admin/custom-pages/{$page->id}/content", [
                'blocks' => [
                    'block_1' => [
                        'text' => 'Public custom page heading',
                    ],
                    'block_2' => [
                        'photos' => [
                            [
                                'image_url' => '/howtodesign/img/1.jpg',
                                'zoom_url' => '/howtodesign/img/1_1.jpg',
                                'alt' => 'Design example 1',
                            ],
                            [
                                'image_url' => '/howtodesign/img/2.jpg',
                                'zoom_url' => '/howtodesign/img/2_1.jpg',
                                'alt' => 'Design example 2',
                            ],
                        ],
                        'caption' => 'Click a photo to view it larger',
                    ],
                ],
            ])
            ->assertOk();

        $this->actingAs($admin, 'admin')
            ->postJson("/api/v1/admin/custom-pages/{$page->id}/content/publish")
            ->assertOk();

        $this->get('/howtodesign')
            ->assertOk()
            ->assertSee('How To Design')
            ->assertSee('Public custom page heading')
            ->assertSee('/howtodesign/img/1.jpg', false)
            ->assertSee('/howtodesign/img/1_1.jpg', false)
            ->assertSee('Click a photo to view it larger')
            ->assertSee('/howtodesign', false);
    }
}
