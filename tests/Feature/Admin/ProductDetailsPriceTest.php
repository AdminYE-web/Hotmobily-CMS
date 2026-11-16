<?php

namespace Tests\Feature\Admin;

use App\Http\Controllers\Storefront\ProductController;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductLayout;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class ProductDetailsPriceTest extends TestCase
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


    private function layout(): array
    {
        return ['version' => 2, 'rows' => [['id' => 'r', 'columns' => [['id' => 'c', 'width' => 12, 'blocks' => [
            ['id' => 'details', 'type' => 'product_details', 'settings' => []],
        ]]]]]];
    }

    private function product(): Product
    {
        $layout = ProductLayout::create(['draft_layout_json' => $this->layout(), 'published_layout_json' => $this->layout()]);
        return Product::create(['product_layout_id' => $layout->id]);
    }

    private function data(): array
    {
        return ['reference_price' => 'legacy reference', 'total_price' => 'legacy total', 'shipping_days' => 10,
            'shipping_note' => 'Shipping note', 'highlight_title' => 'Highlight', 'price_table_enabled' => true,
            'price_table_title' => '??????????', 'price_table_columns' => [
                ['quantity' => '1?', 'price' => '990', 'suffix' => '??'],
                ['quantity' => '50?', 'price' => '255', 'suffix' => '??'],
                ['quantity' => '300?', 'price' => '188', 'suffix' => '??'],
            ]];
    }

    public function test_save_reload_publish_and_toggle_preserve_columns_and_legacy_prices(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $product = $this->product(); $data = $this->data();
        $data['price_table_columns'] = array_reverse($data['price_table_columns']);
        $url = '/api/v1/admin/products/'.$product->id.'/page';
        $this->putJson($url, ['blocks' => ['details' => $data]])->assertOk();
        $this->getJson($url)->assertOk()->assertJsonPath('data.content.blocks.details.price_table_columns.0.quantity', '300?');
        $this->postJson($url.'/publish')->assertOk();
        $this->assertSame($product->page()->first()->draft_content_json, $product->page()->first()->published_content_json);
        $data['price_table_enabled'] = false;
        $data['price_table_title'] = '';
        $data['price_table_columns'][0]['price'] = '0';
        $this->putJson($url, ['blocks' => ['details' => $data]])->assertOk();
        $this->getJson($url)->assertOk()->assertJsonPath('data.content.blocks.details.price_table_enabled', false)
            ->assertJsonPath('data.content.blocks.details.reference_price', 'legacy reference')
            ->assertJsonPath('data.content.blocks.details.total_price', 'legacy total')
            ->assertJsonPath('data.content.blocks.details.price_table_title', '')
            ->assertJsonPath('data.content.blocks.details.price_table_columns.0.price', '0')
            ->assertJsonCount(3, 'data.content.blocks.details.price_table_columns');
    }

    public function test_old_content_defaults_to_legacy_and_invalid_tables_are_rejected(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin'); $product = $this->product();
        $url = '/api/v1/admin/products/'.$product->id.'/page';
        $this->putJson($url, ['blocks' => ['details' => ['reference_price' => 'old price']]])->assertOk();
        $this->getJson($url)->assertJsonPath('data.content.blocks.details.price_table_enabled', false);
        foreach (['empty', 'too-many', 'blank', 'invalid-flag'] as $case) {
            $data = $this->data();
            if ($case === 'empty') $data['price_table_columns'] = [];
            if ($case === 'too-many') $data['price_table_columns'] = array_fill(0, 13, $data['price_table_columns'][0]);
            if ($case === 'blank') $data['price_table_columns'][0]['price'] = '   ';
            if ($case === 'invalid-flag') $data['price_table_enabled'] = 'yes';
            $this->putJson($url, ['blocks' => ['details' => $data]])->assertUnprocessable();
        }
    }

    public function test_full_view_switches_price_only_and_escapes_table_text(): void
    {
        $data = $this->data();
        $render = fn ($content) => view('products.show', [
            'product' => new Product(['name' => 'Details QA', 'slug' => 'details-qa']),
            'layout' => $this->layout(), 'contents' => ['details' => $content], 'publishedAt' => null,
        ])->render();
        $html = $render($data);
        $this->assertStringContainsString('product-details-price-table', $html);
        $this->assertStringContainsString('<strong>990</strong>', $html);
        $this->assertStringNotContainsString('legacy reference', $html);
        $this->assertStringNotContainsString('legacy total', $html);
        $this->assertStringContainsString('Shipping note', $html);
        $this->assertStringContainsString('Highlight', $html);
        $data['price_table_enabled'] = false;
        $html = $render($data);
        $this->assertStringContainsString('legacy reference', $html);
        $this->assertStringContainsString('legacy total', $html);
        $this->assertStringNotContainsString('<table class="product-details-price-table"', $html);
        $data['price_table_enabled'] = true;
        $data['price_table_columns'][0]['quantity'] = '<script>bad()</script>';
        $html = $render($data);
        $this->assertStringContainsString('&lt;script&gt;bad()&lt;/script&gt;', $html);
    }

    public function test_unsaved_preview_uses_table_without_persisting(): void
    {
        $product = $this->product();
        $view = Mockery::mock(View::class);
        $view->shouldReceive('render')->once()->andReturn('<html>Table preview</html>');
        $renderer = Mockery::mock(ProductController::class);
        $renderer->shouldReceive('renderProduct')->once()->withArgs(fn ($actual, $draft, $snapshot) =>
            $actual->id === $product->id && $draft && $snapshot['details']['price_table_enabled'] === true
            && $snapshot['details']['price_table_columns'][1]['price'] === '255'
        )->andReturn($view);
        $this->app->instance(ProductController::class, $renderer);
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin')
            ->postJson(route('admin.products.content.preview', $product), ['blocks' => ['details' => $this->data()]])
            ->assertOk()->assertSee('Table preview');
        $this->assertSame(0, $product->page()->count());
    }

    public function test_shipping_note_preserves_links_and_formatting_and_supports_legacy_text(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $product = $this->product();
        $url = '/api/v1/admin/products/'.$product->id.'/page';
        $data = $this->data();
        $data['shipping_note_format'] = 'html';
        $data['shipping_note'] = '<p><strong>Shipping info</strong> <a href="https://example.com/delivery" target="_blank">Delivery details</a></p><script>alert(1)</script><a href="javascript:alert(1)" onclick="bad()">unsafe</a>';
        $this->putJson($url, ['blocks' => ['details' => $data]])->assertOk();
        $this->getJson($url)->assertJsonPath('data.content.blocks.details.shipping_note_format', 'html');
        $saved = $product->page()->first()->draft_content_json['blocks']['details'];
        $this->assertStringContainsString('<strong>Shipping info</strong>', $saved['shipping_note']);
        $this->assertStringContainsString('href="https://example.com/delivery"', $saved['shipping_note']);
        $this->assertStringNotContainsString('<script', $saved['shipping_note']);
        $this->assertStringNotContainsString('javascript:', $saved['shipping_note']);
        $this->assertStringNotContainsString('onclick', $saved['shipping_note']);
        $this->postJson($url.'/publish')->assertOk();
        $this->assertSame($saved['shipping_note'], $product->page()->first()->published_content_json['blocks']['details']['shipping_note']);
        $render = fn ($content) => view('products.show', [
            'product' => new Product(['name' => 'Shipping QA', 'slug' => 'shipping-qa']),
            'layout' => $this->layout(), 'contents' => ['details' => $content], 'publishedAt' => null,
        ])->render();
        $this->assertStringContainsString('href="https://example.com/delivery"', $render($saved));
        $this->assertStringContainsString('<strong>Shipping info</strong>', $render($saved));
        $legacy = ['shipping_note' => "Line 1\n<literal>"];
        $this->putJson($url, ['blocks' => ['details' => $legacy]])->assertOk();
        $this->getJson($url)->assertJsonPath('data.content.blocks.details.shipping_note_format', 'plain');
        $this->assertStringContainsString("Line 1<br />\n&lt;literal&gt;", $render($legacy));
        $data['shipping_note'] = '';
        $this->putJson($url, ['blocks' => ['details' => $data]])->assertOk();
        $this->getJson($url)->assertJsonPath('data.content.blocks.details.shipping_note', '');
    }
}
