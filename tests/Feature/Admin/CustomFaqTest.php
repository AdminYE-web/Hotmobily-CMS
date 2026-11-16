<?php

namespace Tests\Feature\Admin;

use App\Http\Controllers\Storefront\ProductController;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductLayout;
use App\Support\CustomFaqContent;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class CustomFaqTest extends TestCase
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
        return array_replace(CustomFaqContent::defaults(), [
            'title' => 'Custom FAQ', 'description' => '<p><strong>FAQ introduction</strong></p><script>bad()</script>',
            'items' => [
                ['id' => 'order', 'title' => 'Orders', 'icon' => 'cart', 'url' => '/faq/order', 'new_tab' => false],
                ['id' => 'quality', 'title' => 'Quality', 'icon' => 'gem', 'url' => 'https://hotmobily.jp/faq/product-info.php?code=acrylic-quality', 'new_tab' => true],
            ],
        ]);
    }

    private function layout(): array
    {
        return ['version' => 2, 'rows' => [['id' => 'row1', 'columns' => [['id' => 'col1', 'width' => 12, 'blocks' => [
            ['id' => 'faq1', 'type' => 'custom_faq', 'settings' => []],
            ['id' => 'accordion1', 'type' => 'accordion', 'settings' => ['title' => 'FAQ'], 'children' => [
                ['id' => 'faq2', 'type' => 'custom_faq', 'settings' => []],
            ]],
        ]]]]]];
    }

    private function product(): Product
    {
        $layout = ProductLayout::create(['draft_layout_json' => $this->layout(), 'published_layout_json' => $this->layout()]);
        return Product::create(['product_layout_id' => $layout->id]);
    }

    public function test_builder_accepts_custom_faq_at_top_level_and_in_accordion(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $layout = ProductLayout::create([]);
        $this->putJson('/api/v1/admin/product-layouts/'.$layout->id.'/layout', $this->layout())->assertOk();
        $saved = $layout->fresh()->draft_layout_json;
        $this->assertSame('custom_faq', $saved['rows'][0]['columns'][0]['blocks'][0]['type']);
        $this->assertSame('custom_faq', $saved['rows'][0]['columns'][0]['blocks'][1]['children'][0]['type']);
    }

    public function test_save_reload_publish_preserve_order_icons_and_destinations(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $product = $this->product();
        $data = $this->data();
        $data['items'] = array_reverse($data['items']);
        $data['columns'] = 4;
        $data['mobile_columns'] = 2;
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => ['faq1' => $data, 'faq2' => $data]])->assertOk();
        $this->getJson('/api/v1/admin/products/'.$product->id.'/page')->assertOk()->assertJsonPath('data.content.blocks.faq1.items.0.id', 'quality');
        $this->assertNull($product->page()->first()->published_content_json);
        $this->postJson('/api/v1/admin/products/'.$product->id.'/page/publish')->assertOk();
        $page = $product->page()->first();
        $this->assertSame($page->draft_content_json, $page->published_content_json);
        $saved = $page->published_content_json['blocks']['faq1'];
        $this->assertSame($data['items'], $saved['items']);
        $this->assertSame(4, $saved['columns']);
        $this->assertSame(2, $saved['mobile_columns']);
        $this->assertSame('<p><strong>FAQ introduction</strong></p>', $saved['description']);
    }

    public function test_preview_uses_unsaved_data_without_writing_content(): void
    {
        $product = $this->product();
        $view = Mockery::mock(View::class);
        $view->shouldReceive('render')->once()->andReturn('<html>Custom FAQ preview</html>');
        $renderer = Mockery::mock(ProductController::class);
        $renderer->shouldReceive('renderProduct')->once()->withArgs(fn ($actual, $draft, $snapshot) =>
            $actual->id === $product->id && $draft && $snapshot['faq1']['items'][1]['new_tab'] === true
        )->andReturn($view);
        $this->app->instance(ProductController::class, $renderer);
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin')
            ->postJson(route('admin.products.content.preview', $product), ['blocks' => ['faq1' => $this->data()]])
            ->assertOk()->assertSee('Custom FAQ preview');
        $this->assertSame(0, $product->page()->count());
    }

    public function test_unsafe_urls_invalid_icons_and_duplicate_ids_are_rejected(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $product = $this->product();
        foreach (['javascript:alert(1)', '//external.test/a', '/\\external.test/a', 'data:text/html,bad', ''] as $url) {
            $data = $this->data();
            $data['items'][0]['url'] = $url;
            $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => ['faq1' => $data]])->assertUnprocessable();
        }
        foreach ([
            ['items' => [0 => ['icon' => '<svg onload="bad()">']]],
            ['items' => [1 => ['id' => 'order']]],
            ['items' => [1 => ['new_tab' => 'invalid']]],
            ['columns' => 5], ['mobile_columns' => 3],
        ] as $change) {
            $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => ['faq1' => array_replace_recursive($this->data(), $change)]])->assertUnprocessable();
        }
        $this->assertSame(0, $product->page()->count());
    }

    public function test_product_view_renders_tiles_with_svg_icons_and_safe_new_tab_links(): void
    {
        $data = CustomFaqContent::normalize($this->data());
        $data['items'][0]['title'] = '<script>bad()</script>';
        $html = view('products.show', [
            'product' => new Product(['name' => 'FAQ product', 'slug' => 'faq-product']),
            'layout' => $this->layout(), 'contents' => ['faq1' => $data, 'faq2' => $data], 'publishedAt' => null,
        ])->render();
        $this->assertSame(2, substr_count($html, 'class="custom-faq"'));
        $this->assertSame(4, substr_count($html, 'class="cf-link"'));
        $this->assertStringContainsString('href="/faq/order"', $html);
        $this->assertStringContainsString('target="_blank" rel="noopener noreferrer"', $html);
        $this->assertStringContainsString('&lt;script&gt;bad()&lt;/script&gt;', $html);
        $this->assertStringNotContainsString('<script>bad()</script>', $html);
        $this->assertStringContainsString(CustomFaqContent::icons()['cart']['svg'], $html);
        $this->assertStringContainsString('/css/custom-faq.css', $html);
    }

    public function test_empty_component_has_no_tiles_and_presets_use_supported_icons(): void
    {
        $html = view('products.partials.custom-faq', ['content' => CustomFaqContent::defaults(), 'safeUrl' => fn ($url) => $url])->render();
        $this->assertStringNotContainsString('class="cf-grid"', $html);
        $this->assertCount(12, CustomFaqContent::presets());
        foreach (CustomFaqContent::presets() as $item) $this->assertArrayHasKey($item['icon'], CustomFaqContent::icons());
    }

    public function test_saved_image_records_can_return_to_icon_selection(): void
    {
        $data = $this->data();
        unset($data['items'][0]['icon']);
        $data['items'][0]['image_url'] = '/images/custom-faq-icons/cart.svg';
        $this->assertSame('cart', CustomFaqContent::normalize($data)['items'][0]['icon']);
        $data['items'][0]['image_url'] = '/uploads/custom.png';
        $this->assertSame('question', CustomFaqContent::normalize($data)['items'][0]['icon']);
    }
}
