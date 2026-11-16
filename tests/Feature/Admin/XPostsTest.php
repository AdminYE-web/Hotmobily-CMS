<?php

namespace Tests\Feature\Admin;

use App\Http\Controllers\Storefront\ProductController;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductLayout;
use App\Support\XPostsContent;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class XPostsTest extends TestCase
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

    private function data(): array
    {
        return array_replace(XPostsContent::defaults(), [
            'title' => 'Customer posts', 'description' => '<p><strong>From our customers</strong></p><script>bad()</script>',
            'items' => [
                ['id' => 'post1', 'url' => 'https://twitter.com/etowarlukarzas/status/1738063253954232607?ref_src=twsrc%5Etfw', 'note' => 'Read customer post'],
                ['id' => 'post2', 'url' => 'https://x.com/panda8hiro/status/1743126711661903912/photo/1', 'note' => ''],
            ],
        ]);
    }

    private function layout(): array
    {
        return ['version' => 2, 'rows' => [['id' => 'row1', 'columns' => [['id' => 'col1', 'width' => 12, 'blocks' => [
            ['id' => 'xp1', 'type' => 'x_posts', 'settings' => ['x_columns' => 3, 'x_theme' => 'dark', 'x_conversation' => 'all']],
            ['id' => 'accordion1', 'type' => 'accordion', 'settings' => ['title' => 'X posts'], 'children' => [
                ['id' => 'xp2', 'type' => 'x_posts', 'settings' => ['x_columns' => 1, 'x_theme' => 'light', 'x_conversation' => 'none']],
            ]],
        ]]]]]];
    }

    private function product(): Product
    {
        $layout = ProductLayout::create(['draft_layout_json' => $this->layout(), 'published_layout_json' => $this->layout()]);
        return Product::create(['product_layout_id' => $layout->id]);
    }

    public function test_builder_preserves_settings_at_top_level_and_inside_accordion(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $layout = ProductLayout::create([]);
        $this->putJson('/api/v1/admin/product-layouts/'.$layout->id.'/layout', $this->layout())->assertOk();
        $blocks = $layout->fresh()->draft_layout_json['rows'][0]['columns'][0]['blocks'];
        $this->assertSame('x_posts', $blocks[0]['type']);
        $this->assertSame(['x_columns' => 3, 'x_theme' => 'dark', 'x_conversation' => 'all'], $blocks[0]['settings']);
        $this->assertSame('x_posts', $blocks[1]['children'][0]['type']);
        foreach (['x_columns' => 4, 'x_theme' => 'invalid', 'x_conversation' => 'invalid'] as $key => $value) {
            $data = $this->layout();
            $data['rows'][0]['columns'][0]['blocks'][1]['children'][0]['settings'][$key] = $value;
            $this->putJson('/api/v1/admin/product-layouts/'.$layout->id.'/layout', $data)->assertUnprocessable();
        }
    }

    public function test_save_reload_publish_preserve_order_and_numeric_ids_as_strings(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $product = $this->product();
        $data = $this->data();
        $data['items'] = array_reverse($data['items']);
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => ['xp1' => $data, 'xp2' => $data]])->assertOk();
        $this->getJson('/api/v1/admin/products/'.$product->id.'/page')->assertOk()->assertJsonPath('data.content.blocks.xp1.items.0.post_id', '1743126711661903912');
        $this->assertNull($product->page()->first()->published_content_json);
        $this->postJson('/api/v1/admin/products/'.$product->id.'/page/publish')->assertOk();
        $page = $product->page()->first();
        $this->assertSame($page->draft_content_json, $page->published_content_json);
        $saved = $page->published_content_json['blocks']['xp1'];
        $this->assertSame(XPostsContent::normalize($data), $saved);
        $this->assertSame('https://x.com/panda8hiro/status/1743126711661903912', $saved['items'][0]['url']);
        $this->assertSame('<p><strong>From our customers</strong></p>', $saved['description']);
    }

    public function test_preview_uses_unsaved_posts_without_persisting_content(): void
    {
        $product = $this->product();
        $view = Mockery::mock(View::class);
        $view->shouldReceive('render')->once()->andReturn('<html>X posts preview</html>');
        $renderer = Mockery::mock(ProductController::class);
        $renderer->shouldReceive('renderProduct')->once()->withArgs(fn ($actual, $draft, $snapshot) =>
            $actual->id === $product->id && $draft && $snapshot['xp1']['items'][0]['post_id'] === '1738063253954232607'
        )->andReturn($view);
        $this->app->instance(ProductController::class, $renderer);
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin')
            ->postJson(route('admin.products.content.preview', $product), ['blocks' => ['xp1' => $this->data()]])
            ->assertOk()->assertSee('X posts preview');
        $this->assertSame(0, $product->page()->count());
    }

    public function test_invalid_domains_paths_and_duplicate_ids_are_rejected(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $product = $this->product();
        foreach (['javascript:alert(1)', 'https://evil.test/user/status/123', 'https://x.com.evil.test/user/status/123', 'https://x.com@evil.test/user/status/123', 'https://user@x.com/user/status/123', 'https://x.com/user', 'http://x.com/user/status/123', 'https://x.com/user/status/1e20', 'https://x.com/user/status/0'] as $url) {
            $data = $this->data();$data['items'][0]['url'] = $url;
            $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => ['xp1' => $data]])->assertUnprocessable();
        }
        $data = $this->data();$data['items'][1]['id'] = 'post1';
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => ['xp1' => $data]])->assertUnprocessable();
        $this->assertSame(0, $product->page()->count());
        $this->assertSame('1234567890123456789', XPostsContent::post('https://mobile.twitter.com/i/web/status/1234567890123456789?s=20')['post_id']);
    }

    public function test_full_view_renders_scoped_settings_and_safe_fallback_links(): void
    {
        $data = XPostsContent::normalize($this->data());
        $data['items'][0]['note'] = '<script>bad()</script>';
        $html = view('products.show', [
            'product' => new Product(['name' => 'X posts product', 'slug' => 'x-posts']),
            'layout' => $this->layout(), 'contents' => ['xp1' => $data, 'xp2' => $data], 'publishedAt' => null,
        ])->render();
        $this->assertSame(2, substr_count($html, 'class="x-posts"'));
        $this->assertStringContainsString('data-xp-columns="3" data-xp-theme="dark" data-xp-conversation="all"', $html);
        $this->assertStringContainsString('data-xp-columns="1" data-xp-theme="light" data-xp-conversation="none"', $html);
        $this->assertSame(4, substr_count($html, 'data-xp-fallback href='));
        $this->assertStringContainsString('target="_blank" rel="noopener noreferrer"', $html);
        $this->assertStringContainsString('&lt;script&gt;bad()&lt;/script&gt;', $html);
        $this->assertStringNotContainsString('<script>bad()</script>', $html);
        $this->assertStringContainsString('/js/x-posts.js', $html);
    }

    public function test_empty_component_has_no_embed_or_widget_script(): void
    {
        $html = view('products.partials.x-posts', ['content' => XPostsContent::defaults(), 'settings' => []])->render();
        $this->assertStringNotContainsString('data-xp-id=', $html);
        $this->assertStringNotContainsString('<script', $html);
    }
}
