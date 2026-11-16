<?php

namespace Tests\Feature\Admin;

use App\Http\Controllers\Storefront\ProductController;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductLayout;
use App\Support\ProductCatalogContent;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class ProductCatalogTest extends TestCase
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

    private function catalog(): array
    {
        return array_replace(ProductCatalogContent::defaults(), [
            'description' => '<p><strong>Choose a category</strong></p><script>alert(1)</script>',
            'show_all' => false, 'default_category' => 'recommended',
            'categories' => [['id' => 'recommended', 'name' => 'Recommended'], ['id' => 'new', 'name' => 'New'], ['id' => 'empty', 'name' => 'Empty']],
            'items' => [
                ['id' => 'keychain', 'product_id' => null, 'title' => 'Keychain', 'alt' => 'Keychain photo', 'image_url' => '/qa/keychain.svg', 'url' => '/products/acrylic', 'price_prefix' => '1個', 'price' => '168', 'price_suffix' => '円（税込）〜', 'delivery' => '最短（6営業日）', 'badge' => '新商品！', 'category_ids' => ['recommended', 'new']],
                ['id' => 'stand', 'product_id' => null, 'title' => 'Stand', 'alt' => '', 'image_url' => '/qa/stand.svg', 'url' => 'https://hotmobily.jp/products/acrylic/figure', 'price_prefix' => '', 'price' => '', 'price_suffix' => '', 'delivery' => '', 'badge' => '', 'category_ids' => ['new']],
            ],
        ]);
    }

    private function layout(): array
    {
        return ['version' => 2, 'rows' => [['id' => 'row1', 'columns' => [['id' => 'col1', 'width' => 12, 'blocks' => [
            ['id' => 'catalog1', 'type' => 'product_catalog', 'settings' => []],
            ['id' => 'accordion1', 'type' => 'accordion', 'settings' => ['title' => 'Catalog'], 'children' => [
                ['id' => 'catalog2', 'type' => 'product_catalog', 'settings' => []],
            ]],
        ]]]]]];
    }

    private function product(): Product
    {
        $layout = ProductLayout::create(['draft_layout_json' => $this->layout(), 'published_layout_json' => $this->layout()]);
        return Product::create(['product_layout_id' => $layout->id]);
    }

    public function test_builder_accepts_catalog_at_top_level_and_in_accordion(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $layout = ProductLayout::create([]);
        $this->putJson('/api/v1/admin/product-layouts/'.$layout->id.'/layout', $this->layout())->assertOk();
        $saved = $layout->fresh()->draft_layout_json;
        $this->assertSame('product_catalog', $saved['rows'][0]['columns'][0]['blocks'][0]['type']);
        $this->assertSame('product_catalog', $saved['rows'][0]['columns'][0]['blocks'][1]['children'][0]['type']);
    }

    public function test_save_reload_publish_preserve_categories_order_and_card_fields(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $product = $this->product();
        $catalog = $this->catalog();
        $catalog['items'][1]['product_id'] = $product->id;
        $catalog['items'] = array_reverse($catalog['items']);
        $catalog['categories'] = array_reverse($catalog['categories']);
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => ['catalog1' => $catalog, 'catalog2' => $catalog]])->assertOk();
        $this->getJson('/api/v1/admin/products/'.$product->id.'/page')->assertOk()->assertJsonPath('data.content.blocks.catalog1.items.0.id', 'stand');
        $page = $product->page()->first();
        $this->assertNull($page->published_content_json);
        $this->postJson('/api/v1/admin/products/'.$product->id.'/page/publish')->assertOk();
        $page->refresh();
        $this->assertSame($page->draft_content_json, $page->published_content_json);
        $saved = $page->published_content_json['blocks']['catalog1'];
        $this->assertEquals(ProductCatalogContent::normalize($catalog)['items'], $saved['items']);
        $this->assertSame($catalog['categories'], $saved['categories']);
        $this->assertSame('recommended', $saved['default_category']);
        $this->assertStringContainsString('<strong>Choose a category</strong>', $saved['description']);
        $this->assertStringNotContainsString('<script', $saved['description']);
    }

    public function test_preview_uses_unsaved_catalog_without_writing_content(): void
    {
        $product = $this->product();
        $view = Mockery::mock(View::class);
        $view->shouldReceive('render')->once()->andReturn('<html>Catalog preview</html>');
        $renderer = Mockery::mock(ProductController::class);
        $renderer->shouldReceive('renderProduct')->once()->withArgs(fn ($actual, $draft, $snapshot) =>
            $actual->id === $product->id && $draft && $snapshot['catalog1']['items'][0]['category_ids'] === ['recommended', 'new']
        )->andReturn($view);
        $this->app->instance(ProductController::class, $renderer);
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin')
            ->postJson(route('admin.products.content.preview', $product), ['blocks' => ['catalog1' => $this->catalog()]])
            ->assertOk()->assertSee('Catalog preview');
        $this->assertSame(0, $product->page()->count());
    }

    public function test_invalid_urls_category_references_and_product_ids_cannot_be_saved(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $product = $this->product();
        foreach (['url', 'image_url'] as $field) {
            foreach (['javascript:alert(1)', '//external.test/a', '/\\external.test/a', 'data:image/svg+xml,bad'] as $url) {
                $data = $this->catalog();
                $data['items'][0][$field] = $url;
                $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => ['catalog1' => $data]])->assertUnprocessable();
            }
        }
        $invalid = [
            fn ($data) => array_replace($data, ['default_category' => 'missing']),
            fn ($data) => array_replace_recursive($data, ['items' => [0 => ['category_ids' => ['missing']]]]),
            fn ($data) => array_replace_recursive($data, ['items' => [0 => ['category_ids' => ['new', 'new']]]]),
            fn ($data) => array_replace_recursive($data, ['items' => [0 => ['product_id' => 999999]]]),
            fn ($data) => array_replace_recursive($data, ['items' => [1 => ['id' => 'keychain']]]),
            fn ($data) => array_replace_recursive($data, ['categories' => [1 => ['id' => 'recommended']]]),
            fn ($data) => array_replace($data, ['columns' => 5]),
        ];
        foreach ($invalid as $mutate) $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => ['catalog1' => $mutate($this->catalog())]])->assertUnprocessable();
        $this->assertSame(0, $product->page()->count());
    }

    public function test_frontend_renders_scoped_filters_default_visibility_and_escaped_labels(): void
    {
        $catalog = ProductCatalogContent::normalize($this->catalog());
        $catalog['items'][0]['badge'] = '<script>bad</script>';
        $html = view('products.show', [
            'product' => new Product(['name' => 'Catalog product', 'slug' => 'catalog-product']),
            'layout' => $this->layout(), 'contents' => ['catalog1' => $catalog, 'catalog2' => $catalog], 'publishedAt' => null,
        ])->render();
        $this->assertSame(2, substr_count($html, 'class="product-catalog"'));
        $this->assertSame(2, substr_count($html, 'data-pc-default="recommended"'));
        $this->assertSame(2, substr_count($html, 'data-pc-filter="recommended" aria-pressed="true"'));
        $this->assertStringContainsString('href="/products/acrylic"', $html);
        $this->assertStringContainsString('alt="Keychain photo"', $html);
        $this->assertStringContainsString('<span style="color:#ff0000">168</span>', $html);
        $this->assertStringContainsString('&lt;script&gt;bad&lt;/script&gt;', $html);
        $this->assertStringNotContainsString('<script>bad</script>', $html);
        preg_match_all('/class="pc-grid" id="([^"]+)"/', $html, $groups);
        $this->assertCount(2, array_unique($groups[1]));
        $this->assertStringContainsString('/js/product-catalog.js', $html);
        $this->assertStringContainsString('/css/product-catalog.css', $html);
    }

    public function test_catalog_without_categories_shows_all_cards_and_empty_catalog_shows_message(): void
    {
        $catalog = ProductCatalogContent::defaults();
        $html = view('products.partials.product-catalog', ['content' => $catalog, 'safeUrl' => fn ($url) => $url])->render();
        $this->assertStringNotContainsString('data-pc-filter=', $html);
        $this->assertStringContainsString('data-pc-empty role="status" >', $html);
        $catalog['items'] = $this->catalog()['items'];
        foreach ($catalog['items'] as &$item) $item['category_ids'] = [];
        $html = view('products.partials.product-catalog', ['content' => $catalog, 'safeUrl' => fn ($url) => $url])->render();
        $this->assertSame(2, substr_count($html, 'class="pc-card"'));
        $this->assertStringContainsString('data-pc-empty role="status"  hidden', $html);
    }

    public function test_blank_default_shows_all_without_an_extra_category_button_even_for_legacy_content(): void
    {
        $catalog = ProductCatalogContent::normalize($this->catalog());
        $catalog['default_category'] = '';
        $html = view('products.partials.product-catalog', ['content' => $catalog, 'safeUrl' => fn ($url) => $url])->render();
        $this->assertStringContainsString('data-pc-default=""', $html);
        $this->assertStringNotContainsString('data-pc-filter=""', $html);
        $catalog['show_all'] = true;
        $html = view('products.partials.product-catalog', ['content' => $catalog, 'safeUrl' => fn ($url) => $url])->render();
        $this->assertStringContainsString('data-pc-default=""', $html);
        $this->assertStringNotContainsString('data-pc-filter=""', $html);
        $this->assertStringContainsString('data-pc-reset aria-controls=', $html);
    }

    public function test_card_rich_description_keeps_color_and_line_breaks_and_removes_scripts(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $product = $this->product();
        $catalog = $this->catalog();
        $catalog['items'][0]['details_html'] = '<p>1個<span style="color:#ff0000" onclick="bad()">250</span>円<br>最短（6営業日）</p><script>bad()</script>';
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => ['catalog1' => $catalog]])->assertOk();
        $saved = $product->page()->first()->draft_content_json['blocks']['catalog1']['items'][0]['details_html'];
        $this->assertStringContainsString('<span style="color:#ff0000">250</span>', $saved);
        $this->assertStringContainsString('<br>', $saved);
        $this->assertStringNotContainsString('<script', $saved);
        $this->assertStringNotContainsString('onclick', $saved);
        $html = view('products.partials.product-catalog', ['content' => ProductCatalogContent::normalize($catalog), 'safeUrl' => fn ($url) => $url])->render();
        $this->assertStringContainsString($saved, $html);
        $this->assertStringNotContainsString('>168</span>', $html);
    }

    public function test_empty_rich_description_does_not_restore_legacy_price(): void
    {
        $item = $this->catalog()['items'][0];
        $this->assertStringContainsString('168', ProductCatalogContent::cardDetails($item));
        $item['details_html'] = '';
        $this->assertSame('', ProductCatalogContent::cardDetails($item));
    }
}
