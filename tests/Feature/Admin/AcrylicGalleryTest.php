<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\AcrylicGallery;
use App\Models\GalleryPage;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AcrylicGalleryTest extends TestCase
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

        Schema::create('hm_acrylic_gallery', function (Blueprint $table): void {
            $table->increments('id');
            $table->text('arr_img')->nullable();
            $table->text('arr_txt1')->nullable();
            $table->text('arr_txt2')->nullable();
            $table->text('arr_txt3')->nullable();
            $table->text('arr_txt4')->nullable();
            $table->string('type', 50)->nullable();
            $table->text('arr_web')->nullable();
            $table->string('created_by', 100)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->boolean('manual_import')->nullable();
        });

        Schema::create('hm_acrylic_gallery_log', function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedInteger('gallery_id');
            $table->string('product', 50)->nullable();
            $table->string('field', 100)->nullable();
            $table->text('old')->nullable();
            $table->text('new')->nullable();
            $table->string('created_by', 100)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->unsignedInteger('step')->default(1);
        });

        Schema::create('gallery_pages', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 150);
            $table->string('heading', 255)->nullable();
            $table->string('slug', 100)->unique();
            $table->string('public_slug', 100)->unique();
            $table->string('gallery_type', 50)->unique();
            $table->string('media_directory', 255);
            $table->string('legacy_extension', 10)->nullable();
            $table->boolean('show_website')->default(true);
            $table->boolean('show_tags')->default(true);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        foreach ($this->galleryPageDefinitions() as $definition) {
            GalleryPage::query()->create($definition);
        }
    }

    public function test_admin_can_create_update_and_delete_a_keyholder_gallery_item(): void
    {
        $admin = Admin::query()->create([
            'user' => 'gallery-admin',
            'email' => 'gallery-admin@example.test',
            'pass' => 'password',
            'dept' => 'admin',
            'super_admin' => 1,
        ]);

        $this->actingAs($admin, 'admin')
            ->get(route('admin.gallery-items.index', 'acrylic-keyholder'))
            ->assertOk()
            ->assertSee('Acrylic Keyholder Gallery');

        $this->post(route('admin.gallery-items.store', 'acrylic-keyholder'), [
            'arr_txt1' => 'tag',
            'arr_txt2' => 'Customer',
            'arr_txt3' => '2026-09',
            'arr_txt4' => 'Comment',
            'arr_web' => 'https://example.test',
        ])->assertRedirect(route('admin.gallery-items.index', 'acrylic-keyholder'));

        $gallery = AcrylicGallery::query()->firstOrFail();

        $this->assertSame(AcrylicGallery::TYPE_KEYHOLDER, $gallery->type);
        $this->assertSame('gallery-admin', $gallery->created_by);

        $this->put(route('admin.gallery-items.update', ['acrylic-keyholder', $gallery]), [
            'arr_txt1' => 'updated-tag',
            'arr_txt2' => 'Customer',
            'arr_txt3' => '2026-09',
            'arr_txt4' => 'Comment',
            'arr_web' => 'https://example.test',
        ])->assertRedirect(route('admin.gallery-items.index', 'acrylic-keyholder'));

        $this->assertDatabaseHas('hm_acrylic_gallery_log', [
            'gallery_id' => $gallery->id,
            'field' => 'arr_txt1',
            'old' => 'tag',
            'new' => 'updated-tag',
        ]);

        $this->delete(route('admin.gallery-items.destroy', ['acrylic-keyholder', $gallery]))
            ->assertRedirect(route('admin.gallery-items.index', 'acrylic-keyholder'));

        $this->assertDatabaseMissing('hm_acrylic_gallery', ['id' => $gallery->id]);
    }

    public function test_admin_can_upload_up_to_three_gallery_images(): void
    {
        $admin = Admin::query()->create([
            'user' => 'gallery-uploader',
            'email' => 'gallery-uploader@example.test',
            'pass' => 'password',
            'dept' => 'admin',
            'super_admin' => 1,
        ]);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.gallery-items.store', 'acrylic-keyholder'), [
                'arr_txt1' => 'tag',
                'files' => [
                    UploadedFile::fake()->image('one.png'),
                    UploadedFile::fake()->image('two.jpg'),
                    UploadedFile::fake()->image('three.webp'),
                ],
            ])
            ->assertRedirect(route('admin.gallery-items.index', 'acrylic-keyholder'));

        $gallery = AcrylicGallery::query()->firstOrFail();
        $this->assertCount(3, $gallery->imageNames());

        foreach ($gallery->imageNames() as $image) {
            $path = public_path('gallery/img-acrylic/'.$image);
            $this->assertFileExists($path);
            File::delete($path);
        }
    }

    public function test_admin_can_replace_gallery_images_when_editing_and_keep_them_when_no_files_are_selected(): void
    {
        $admin = Admin::query()->create([
            'user' => 'gallery-editor',
            'email' => 'gallery-editor@example.test',
            'pass' => 'password',
            'dept' => 'admin',
            'super_admin' => 1,
        ]);

        $gallery = AcrylicGallery::query()->create([
            'type' => AcrylicGallery::TYPE_KEYHOLDER,
            'arr_img' => 'legacy-one.jpg,legacy-two.jpg',
            'arr_txt1' => 'old-tag',
            'arr_txt2' => 'Customer',
            'arr_txt3' => '2026-09',
            'arr_txt4' => 'Comment',
            'created_by' => 'gallery-editor',
        ]);

        $replacementNames = [];

        try {
            $this->actingAs($admin, 'admin')
                ->put(route('admin.gallery-items.update', ['acrylic-keyholder', $gallery]), [
                    'arr_txt1' => 'new-tag',
                    'arr_txt2' => 'Customer',
                    'arr_txt3' => '2026-09',
                    'arr_txt4' => 'Comment',
                    'files' => [
                        UploadedFile::fake()->image('replacement-one.png'),
                        UploadedFile::fake()->image('replacement-two.jpg'),
                    ],
                ])
                ->assertRedirect(route('admin.gallery-items.index', 'acrylic-keyholder'));

            $updated = $gallery->fresh();
            $replacementNames = $updated->imageNames();

            $this->assertCount(2, $replacementNames);
            $this->assertNotSame('legacy-one.jpg,legacy-two.jpg', $updated->arr_img);

            foreach ($replacementNames as $image) {
                $this->assertFileExists(public_path('gallery/img-acrylic/'.$image));
            }

            $this->actingAs($admin, 'admin')
                ->put(route('admin.gallery-items.update', ['acrylic-keyholder', $updated]), [
                    'arr_txt1' => 'kept-tag',
                ])
                ->assertRedirect(route('admin.gallery-items.index', 'acrylic-keyholder'));

            $this->assertSame($replacementNames, $updated->fresh()->imageNames());
        } finally {
            foreach ($replacementNames as $image) {
                File::delete(public_path('gallery/img-acrylic/'.$image));
            }
        }
    }

    public function test_all_legacy_gallery_sections_have_list_and_create_pages(): void
    {
        $admin = Admin::query()->create([
            'user' => 'gallery-sections',
            'email' => 'gallery-sections@example.test',
            'pass' => 'password',
            'dept' => 'admin',
            'super_admin' => 1,
        ]);

        $sections = [
            'acrylic-gallery' => 'Acrylic Keyholder Gallery',
            'acrylic-coaster-gallery' => 'Acrylic Coaster Gallery',
            'acrylic-standee-gallery' => 'Acrylic Standee Gallery',
            'acrylic-hair-gallery' => 'Acrylic Hair Gallery',
            'acrylic-strap-gallery' => 'Acrylic Strap Gallery',
            'rubber-strap-gallery' => 'Rubber Strap Gallery',
            'rubber-keyholder-gallery' => 'Rubber Keyholder Gallery',
            'rubber-coaster-gallery' => 'Rubber Coaster Gallery',
            'wappen-gallery' => 'Wappen Gallery',
        ];

        foreach ($sections as $routeName => $label) {
            $slug = str_replace('-gallery', '', $routeName);
            $slug = $routeName === 'acrylic-gallery' ? 'acrylic-keyholder' : $slug;

            $this->actingAs($admin, 'admin')
                ->get(route('admin.gallery-items.index', $slug))
                ->assertOk()
                ->assertSee($label);

            $this->actingAs($admin, 'admin')
                ->get(route('admin.gallery-items.create', $slug))
                ->assertOk()
                ->assertSee('Images (up to 3)');

            $this->actingAs($admin, 'admin')
                ->get(route('admin.'.$routeName.'.index'))
                ->assertOk();
        }
    }

    public function test_admin_can_create_a_future_gallery_page_that_uses_the_legacy_table(): void
    {
        $admin = Admin::query()->create([
            'user' => 'gallery-builder',
            'email' => 'gallery-builder@example.test',
            'pass' => 'password',
            'dept' => 'admin',
            'super_admin' => 1,
        ]);

            $this->actingAs($admin, 'admin')
            ->post(route('admin.gallery-pages.store'), [
                'name' => 'New Future Gallery',
                'heading' => 'Future Gallery Heading',
                'slug' => 'future-gallery',
                'public_slug' => 'future_gallery',
                'gallery_type' => 'future_gallery',
                'media_directory' => 'gallery/future-gallery',
                'legacy_extension' => 'webp',
                'sort_order' => 100,
                'show_website' => '1',
                'is_active' => '1',
            'description' => '<p>A page created from admin settings. <a href="https://example.test">Read more</a></p>',
            ])
            ->assertRedirect(route('admin.gallery-pages.index'));

        $this->actingAs($admin, 'admin')
            ->post(route('admin.gallery-items.store', 'future-gallery'), [
                'arr_txt1' => 'new',
                'arr_txt2' => 'Future Customer',
            ])
            ->assertRedirect(route('admin.gallery-items.index', 'future-gallery'));

        $this->assertDatabaseHas('hm_acrylic_gallery', [
            'type' => 'future_gallery',
            'arr_txt2' => 'Future Customer',
        ]);

        $this->get(route('gallery.show', 'future_gallery'))
            ->assertOk()
            ->assertSee('Future Gallery Heading')
            ->assertSee('<a href="https://example.test">Read more</a>', false)
            ->assertSee('data-rubber-keyholder-gallery', false)
            ->assertSee('class="table_rubber"', false)
            ->assertDontSee('dynamic-gallery-grid', false)
            ->assertSee('Future Customer');
    }

    public function test_gallery_page_settings_loads_the_rich_description_editor(): void
    {
        $admin = Admin::query()->create([
            'user' => 'gallery-editor',
            'email' => 'gallery-editor@example.test',
            'pass' => 'password',
            'dept' => 'admin',
            'super_admin' => 1,
        ]);
        $page = GalleryPage::query()->where('slug', 'rubber-strap')->firstOrFail();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.gallery-pages.edit', $page))
            ->assertOk()
            ->assertSee('name="heading"', false)
            ->assertSee('id="description"', false)
            ->assertSee('name="show_tags"', false)
            ->assertSee('https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js', false);
    }

    public function test_gallery_page_can_hide_the_public_tag_filter(): void
    {
        $admin = Admin::query()->create([
            'user' => 'gallery-tag-settings',
            'email' => 'gallery-tag-settings@example.test',
            'pass' => 'password',
            'dept' => 'admin',
            'super_admin' => 1,
        ]);
        $page = GalleryPage::query()->where('slug', 'rubber-strap')->firstOrFail();

        AcrylicGallery::query()->create([
            'type' => 'rubber_strap',
            'arr_txt1' => 'character,2D',
        ]);

        $this->actingAs($admin, 'admin')
            ->put(route('admin.gallery-pages.update', $page), [
                'name' => $page->name,
                'slug' => $page->slug,
                'public_slug' => $page->public_slug,
                'gallery_type' => $page->gallery_type,
                'media_directory' => $page->media_directory,
                'legacy_extension' => 'webp',
                'sort_order' => $page->sort_order,
                'show_website' => '1',
                'show_tags' => '0',
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.gallery-pages.index'));

        $this->assertFalse($page->fresh()->show_tags);

        $this->get(route('gallery.show', 'rubberstrap'))
            ->assertOk()
            ->assertDontSee('class="tag-menu"', false)
            ->assertDontSee('data-gallery-tag="character"', false);
    }

    public function test_page_with_legacy_items_keeps_its_database_type_and_cannot_be_deleted(): void
    {
        $admin = Admin::query()->create([
            'user' => 'gallery-protector',
            'email' => 'gallery-protector@example.test',
            'pass' => 'password',
            'dept' => 'admin',
            'super_admin' => 1,
        ]);
        $page = GalleryPage::query()->where('slug', 'rubber-strap')->firstOrFail();
        AcrylicGallery::query()->create(['type' => 'rubber_strap', 'arr_txt2' => 'Old Customer']);

        $this->actingAs($admin, 'admin')
            ->put(route('admin.gallery-pages.update', $page), [
                'name' => $page->name,
                'slug' => $page->slug,
                'public_slug' => $page->public_slug,
                'gallery_type' => 'changed_type',
                'media_directory' => $page->media_directory,
                'legacy_extension' => 'webp',
                'sort_order' => $page->sort_order,
                'show_website' => '1',
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.gallery-pages.index'));

        $this->assertSame('rubber_strap', $page->fresh()->gallery_type);

        $this->actingAs($admin, 'admin')
            ->delete(route('admin.gallery-pages.destroy', $page))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('gallery_pages', ['id' => $page->id]);
        $this->assertDatabaseHas('hm_acrylic_gallery', ['type' => 'rubber_strap']);
    }

    public function test_acrylic_key_public_page_matches_the_legacy_gallery_structure(): void
    {
        AcrylicGallery::query()->create([
            'type' => 'keyholder',
            'arr_img' => '/gallery/img-acrylic/acrylic-from-database.webp,/gallery/img-acrylic/acrylic-from-database-2.webp',
            'arr_txt1' => '個人,赤色',
            'arr_txt2' => 'Database Acrylic Customer',
            'arr_txt3' => '2026年9月',
            'arr_txt4' => 'Database Acrylic comment',
        ]);

        $this->get(route('gallery.show', 'acrylic_key'))
            ->assertOk()
            ->assertSee('オリジナルアクリルキーホルダー、アクキーの製作事例集です。')
            ->assertSee('タグで絞込み')
            ->assertSee('片面')
            ->assertSee('Database Acrylic Customer')
            ->assertSee('acrylic-key-page', false)
            ->assertSee('class="preview-top my-gallery"', false)
            ->assertSee('class="preview-sub flex-container"', false)
            ->assertSee('class="table_rubber"', false)
            ->assertSee('/gallery/img-acrylic/acrylic-from-database.webp', false)
            ->assertSee('data-gallery-thumbnail', false)
            ->assertDontSee('dynamic-gallery-grid', false)
            ->assertSee('/css/gallery-rubber-keyholder.css?v=1.02', false)
            ->assertSee('/js/gallery-rubber-keyholder.js?v=1.02', false);
    }

    public function test_rubber_keyholder_public_page_matches_the_legacy_gallery_structure(): void
    {
        AcrylicGallery::query()->create([
            'type' => 'rubber_keyholder',
            'arr_img' => '/gallery/img-rubber/example-1.webp,/gallery/img-rubber/example-2.webp',
            'arr_txt1' => '個人,赤色',
            'arr_txt2' => 'テスト客様',
            'arr_txt3' => '2026年9月',
            'arr_txt4' => 'テスト用の一言コメントです。',
        ]);

        $this->get(route('gallery.show', 'rubberkeyholder'))
            ->assertOk()
            ->assertSee('製作事例紹介')
            ->assertSee('タグで絞込み')
            ->assertSee('個人')
            ->assertSee('お客様')
            ->assertSee('テスト客様')
            ->assertSee('data-rubber-keyholder-gallery', false)
            ->assertSee('data-gallery-thumbnail', false)
            ->assertSee('/css/gallery-rubber-keyholder.css?v=1.02', false)
            ->assertSee('/js/gallery-rubber-keyholder.js?v=1.02', false);
    }

    public function test_rubber_coaster_public_page_matches_the_legacy_gallery_structure(): void
    {
        AcrylicGallery::query()->create([
            'type' => 'rubber_coaster',
            'arr_img' => '/gallery/img-rubber/coaster-from-database.webp',
            'arr_txt1' => '黄色,黒色',
            'arr_txt2' => 'Database Customer',
            'arr_txt3' => '2026年9月',
            'arr_txt4' => 'Database comment',
        ]);

        $this->get(route('gallery.show', 'rubbercoaster'))
            ->assertOk()
            ->assertSee('製作事例紹介')
            ->assertSee('ラバーコースター')
            ->assertSee('タグで絞込み')
            ->assertSee('/products/rubbercoaster/#est-content', false)
            ->assertSee('/gallery/img-rubber/coaster-from-database.webp', false)
            ->assertSee('/gallery/img-coaster/2024/1.webp?v=0.1', false)
            ->assertSee('Database Customer')
            ->assertSee('rubber-coaster-page', false)
            ->assertSee('class="preview-top my-gallery"', false)
            ->assertSee('class="preview-sub flex-container"', false)
            ->assertSee('class="td-tag tag-a"', false)
            ->assertSee('itemprop="associatedMedia"', false)
            ->assertSee('data-gallery-thumbnail', false)
            ->assertSee('/css/gallery-rubber-keyholder.css?v=1.02', false)
            ->assertSee('/products/acrylic/ptw/photoswipe.min.js?v=1.08', false)
            ->assertSee('/js/gallery-rubber-keyholder.js?v=1.02', false);
    }

    /** @return list<array<string, mixed>> */
    private function galleryPageDefinitions(): array
    {
        return [
            ['name' => 'Acrylic Keyholder Gallery', 'slug' => 'acrylic-keyholder', 'public_slug' => 'acrylic_key', 'gallery_type' => 'keyholder', 'media_directory' => 'gallery/img-acrylic', 'legacy_extension' => 'webp', 'show_website' => true, 'is_active' => true, 'sort_order' => 10],
            ['name' => 'Acrylic Coaster Gallery', 'slug' => 'acrylic-coaster', 'public_slug' => 'acrylic_coaster', 'gallery_type' => 'coaster', 'media_directory' => 'gallery/img-acrylic-coaster', 'legacy_extension' => 'webp', 'show_website' => true, 'is_active' => true, 'sort_order' => 20],
            ['name' => 'Acrylic Standee Gallery', 'slug' => 'acrylic-standee', 'public_slug' => 'acrylic_standee', 'gallery_type' => 'standee', 'media_directory' => 'gallery/img-acrylic', 'legacy_extension' => 'webp', 'show_website' => true, 'is_active' => true, 'sort_order' => 30],
            ['name' => 'Acrylic Hair Gallery', 'slug' => 'acrylic-hair', 'public_slug' => 'acrylic_hair', 'gallery_type' => 'acrylic_hair', 'media_directory' => 'gallery/img-acrylic', 'legacy_extension' => 'webp', 'show_website' => true, 'is_active' => true, 'sort_order' => 40],
            ['name' => 'Acrylic Strap Gallery', 'slug' => 'acrylic-strap', 'public_slug' => 'acrylic_strap', 'gallery_type' => 'acrylic_strap', 'media_directory' => 'gallery/img-acrylic', 'legacy_extension' => 'webp', 'show_website' => false, 'is_active' => true, 'sort_order' => 50],
            ['name' => 'Rubber Strap Gallery', 'slug' => 'rubber-strap', 'public_slug' => 'rubberstrap', 'gallery_type' => 'rubber_strap', 'media_directory' => 'gallery/img-rubber', 'legacy_extension' => 'webp', 'show_website' => true, 'is_active' => true, 'sort_order' => 60],
            ['name' => 'Rubber Keyholder Gallery', 'slug' => 'rubber-keyholder', 'public_slug' => 'rubberkeyholder', 'gallery_type' => 'rubber_keyholder', 'media_directory' => 'gallery/img-rubber', 'legacy_extension' => 'webp', 'show_website' => true, 'is_active' => true, 'sort_order' => 70],
            ['name' => 'Rubber Coaster Gallery', 'slug' => 'rubber-coaster', 'public_slug' => 'rubbercoaster', 'gallery_type' => 'rubber_coaster', 'media_directory' => 'gallery/img-rubber', 'legacy_extension' => 'webp', 'show_website' => true, 'is_active' => true, 'sort_order' => 80],
            ['name' => 'Wappen Gallery', 'slug' => 'wappen', 'public_slug' => 'wappen', 'gallery_type' => 'wappen', 'media_directory' => 'gallery/img-wappen', 'legacy_extension' => 'webp', 'show_website' => true, 'is_active' => true, 'sort_order' => 90],
        ];
    }
}
