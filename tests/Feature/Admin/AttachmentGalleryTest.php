<?php

namespace Tests\Feature\Admin;

use App\Http\Controllers\Storefront\ProductController;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductLayout;
use App\Support\AttachmentGalleryContent;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class AttachmentGalleryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        (require database_path('migrations/2026_10_22_000000_create_product_content_revisions_table.php'))->up();
        Schema::create('product_layouts', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->default('Gallery');
            $table->string('slug')->default('gallery');
            $table->string('status')->default('draft');
            $table->text('draft_layout_json')->nullable();
            $table->text('published_layout_json')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
        Schema::create('products', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('product_layout_id')->nullable();
            $table->string('status')->default('draft');
            $table->timestamps();
        });
        Schema::create('product_pages', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->text('draft_content_json')->nullable();
            $table->text('published_content_json')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
        Schema::create('faqs', function (Blueprint $table): void {
            $table->id();
            $table->string('material')->nullable();
            $table->string('question_name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('category')->nullable();
            $table->string('entry_type')->nullable();
            $table->integer('sort_order')->default(0);
        });
    }

    private function gallery(): array
    {
        return array_replace(AttachmentGalleryContent::defaults(), [
            'description' => '<p><strong>Gallery introduction</strong></p><script>alert(1)</script>',
            'items' => [
                ['id' => 'chain', 'title' => 'Chain', 'image_url' => '/qa/chain.svg', 'zoom_url' => '/qa/chain-large.svg', 'price' => '+11円', 'alt' => 'Silver chain', 'description' => "Chain details\nSecond line"],
                ['id' => 'strap', 'title' => 'Strap', 'image_url' => '/qa/strap.svg', 'zoom_url' => '', 'price' => '+0円', 'alt' => 'Black strap', 'description' => 'Strap details'],
            ],
        ]);
    }

    private function layout(): array
    {
        return ['version' => 2, 'rows' => [['id' => 'row1', 'columns' => [['id' => 'col1', 'width' => 12, 'blocks' => [
            ['id' => 'gallery1', 'type' => 'attachment_gallery', 'settings' => []],
            ['id' => 'accordion1', 'type' => 'accordion', 'settings' => ['title' => 'Attachments'], 'children' => [
                ['id' => 'gallery2', 'type' => 'attachment_gallery', 'settings' => []],
            ]],
        ]]]]]];
    }

    private function product(): Product
    {
        $layout = ProductLayout::create(['draft_layout_json' => $this->layout(), 'published_layout_json' => $this->layout()]);
        return Product::create(['product_layout_id' => $layout->id]);
    }

    public function test_builder_accepts_gallery_at_top_level_and_in_accordion(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $layout = ProductLayout::create([]);
        $this->putJson('/api/v1/admin/product-layouts/'.$layout->id.'/layout', $this->layout())->assertOk();
        $saved = $layout->fresh()->draft_layout_json;
        $this->assertSame('attachment_gallery', $saved['rows'][0]['columns'][0]['blocks'][0]['type']);
        $this->assertSame('attachment_gallery', $saved['rows'][0]['columns'][0]['blocks'][1]['children'][0]['type']);
    }

    public function test_save_reload_publish_preserve_order_and_all_item_fields(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $product = $this->product();
        $gallery = $this->gallery();
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => ['gallery1' => $gallery, 'gallery2' => $gallery]])->assertOk();
        $this->getJson('/api/v1/admin/products/'.$product->id.'/page')->assertOk()->assertJsonPath('data.content.blocks.gallery1.items.0.id', 'chain');
        $page = $product->page()->first();
        $this->assertNull($page->published_content_json);
        $this->postJson('/api/v1/admin/products/'.$product->id.'/page/publish')->assertOk();
        $page->refresh();
        $this->assertSame($page->draft_content_json, $page->published_content_json);
        $saved = $page->published_content_json['blocks']['gallery1'];
        $this->assertEquals($gallery['items'], $saved['items']);
        $this->assertStringContainsString('<strong>Gallery introduction</strong>', $saved['description']);
        $this->assertStringNotContainsString('<script', $saved['description']);
    }

    public function test_preview_uses_unsaved_gallery_without_writing_a_product_page(): void
    {
        $product = $this->product();
        $view = Mockery::mock(View::class);
        $view->shouldReceive('render')->once()->andReturn('<html>Attachment preview</html>');
        $renderer = Mockery::mock(ProductController::class);
        $renderer->shouldReceive('renderProduct')->once()->withArgs(fn ($actual, $draft, $snapshot) =>
            $actual->id === $product->id && $draft && $snapshot['gallery1']['items'][0]['description'] === "Chain details\nSecond line"
        )->andReturn($view);
        $this->app->instance(ProductController::class, $renderer);
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin')
            ->postJson(route('admin.products.content.preview', $product), ['blocks' => ['gallery1' => $this->gallery()]])
            ->assertOk()->assertSee('Attachment preview');
        $this->assertSame(0, $product->page()->count());
    }

    public function test_unsafe_urls_duplicate_ids_and_invalid_settings_are_rejected(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $product = $this->product();
        foreach (['javascript:alert(1)', '//external.test/image.jpg', '/\\external.test/a', 'data:image/svg+xml,bad'] as $url) {
            $data = $this->gallery();
            $data['items'][0]['image_url'] = $url;
            $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => ['gallery1' => $data]])->assertUnprocessable();
        }
        foreach (['columns', 'mobile_columns', 'collapsed_height', 'items'] as $invalid) {
            $data = $this->gallery();
            if ($invalid === 'items') $data['items'][1]['id'] = 'chain';
            else $data[$invalid] = 0;
            $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => ['gallery1' => $data]])->assertUnprocessable();
        }
        $this->assertSame(0, $product->page()->count());
    }

    public function test_full_product_view_renders_scoped_groups_and_zoom_fallback(): void
    {
        $gallery = AttachmentGalleryContent::normalize($this->gallery());
        $html = view('products.show', [
            'product' => new Product(['name' => 'Gallery product', 'slug' => 'gallery-product']),
            'layout' => $this->layout(), 'contents' => ['gallery1' => $gallery, 'gallery2' => $gallery], 'publishedAt' => null,
        ])->render();
        $this->assertSame(2, substr_count($html, 'class="attachment-gallery" data-attachment-gallery'));
        $this->assertStringContainsString('data-image-modal-src="/qa/chain-large.svg"', $html);
        $this->assertStringContainsString('data-image-modal-src="/qa/strap.svg"', $html);
        $this->assertStringContainsString('alt="Silver chain"', $html);
        $this->assertStringContainsString('+11円', $html);
        preg_match_all('/data-image-modal-group="(ag-[^"]+)"/', $html, $groups);
        $this->assertCount(2, array_unique($groups[1]));
        $this->assertStringContainsString('/js/attachment-gallery.js', $html);
        $this->assertStringContainsString('/css/attachment-gallery.css', $html);
    }

    public function test_empty_gallery_has_no_grid_or_expand_button(): void
    {
        $html = view('products.show', [
            'product' => new Product(['name' => 'Empty gallery', 'slug' => 'empty-gallery']),
            'layout' => $this->layout(), 'contents' => ['gallery1' => AttachmentGalleryContent::defaults()], 'publishedAt' => null,
        ])->render();
        $this->assertStringNotContainsString('data-ag-grid>', $html);
        $this->assertStringNotContainsString('class="ag-toggle"', $html);
    }
}
