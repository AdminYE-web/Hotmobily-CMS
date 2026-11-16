<?php

namespace Tests\Feature\Admin;

use App\Http\Controllers\Storefront\ProductController;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductLayout;
use App\Support\PriceMatrixContent;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class PriceMatrixTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        (require database_path('migrations/2026_10_22_000000_create_product_content_revisions_table.php'))->up();
        Schema::create('product_layouts', function (Blueprint $table): void {
            $table->id();
            $table->string('name')->default('Test');
            $table->string('slug')->default('test');
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

    private function preset(): array
    {
        return json_decode(file_get_contents(public_path('admin/data/acrylic-price-matrix.json')), true, flags: JSON_THROW_ON_ERROR);
    }

    private function layout(): array
    {
        return ['version' => 2, 'rows' => [['id' => 'row1', 'columns' => [['id' => 'col1', 'width' => 12, 'blocks' => [
            ['id' => 'matrix1', 'type' => 'price_matrix', 'settings' => []],
            ['id' => 'accordion1', 'type' => 'accordion', 'settings' => ['title' => 'Prices'], 'children' => [
                ['id' => 'matrix2', 'type' => 'price_matrix', 'settings' => []],
            ]],
        ]]]]]];
    }

    private function product(): Product
    {
        $layout = ProductLayout::create(['draft_layout_json' => $this->layout(), 'published_layout_json' => $this->layout()]);
        return Product::create(['product_layout_id' => $layout->id]);
    }

    public function test_layout_accepts_price_matrix_at_top_level_and_inside_accordion(): void
    {
        $this->actingAs(new Admin(['email' => 'test@example.test']), 'admin');
        $layout = ProductLayout::create([]);
        $this->putJson('/api/v1/admin/product-layouts/'.$layout->id.'/layout', $this->layout())->assertOk();
        $saved = $layout->fresh()->draft_layout_json;
        $this->assertSame('price_matrix', $saved['rows'][0]['columns'][0]['blocks'][0]['type']);
        $this->assertSame('price_matrix', $saved['rows'][0]['columns'][0]['blocks'][1]['children'][0]['type']);
    }

    public function test_draft_save_reload_and_publish_preserve_all_four_price_sets(): void
    {
        $this->actingAs(new Admin(['email' => 'test@example.test']), 'admin');
        $product = $this->product();
        $preset = $this->preset();
        $preset['quantity_label'] = '個数';
        $preset['actions_label'] = '管理';
        $preset['sizes'][0]['label'] = 'Custom size';
        $preset['description_format'] = 'html';
        $preset['description'] = '<p><strong>Formatted description</strong></p><ul><li>Details</li></ul>';
        $blocks = ['matrix1' => $preset, 'matrix2' => $preset];
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => $blocks])
            ->assertOk()->assertJsonCount(4, 'data.draft_content_json.blocks.matrix1.variants');
        $this->assertNull($product->page()->first()->published_content_json);
        $this->getJson('/api/v1/admin/products/'.$product->id.'/page')->assertOk();
        $this->postJson('/api/v1/admin/products/'.$product->id.'/page/publish')->assertOk();
        $page = $product->page()->first();
        $this->assertSame($page->draft_content_json, $page->published_content_json);
        $this->assertCount(12, $page->published_content_json['blocks']['matrix1']['variants'][0]['rows']);
        $this->assertCount(10, $page->published_content_json['blocks']['matrix1']['variants'][2]['rows']);
        $this->assertSame('990', $page->published_content_json['blocks']['matrix1']['variants'][0]['rows'][0]['prices']['size50']);
        $saved = $page->published_content_json['blocks']['matrix1'];
        $this->assertSame('個数', $saved['quantity_label']);
        $this->assertSame('管理', $saved['actions_label']);
        $html = view('products.partials.price-matrix', ['content' => $saved, 'blockId' => 'matrix'])->render();
        $this->assertStringContainsString('<th scope="col">個数</th>', $html);
        $this->assertStringContainsString('<th scope="col">Custom size</th>', $html);
        $this->assertStringContainsString('<strong>Formatted description</strong>', $html);
        $this->assertStringContainsString('<ul><li>Details</li></ul>', $html);
    }

    public function test_preview_uses_price_matrix_snapshot_without_persisting_it(): void
    {
        $product = $this->product();
        $view = Mockery::mock(View::class);
        $view->shouldReceive('render')->once()->andReturn('<html>Matrix preview</html>');
        $renderer = Mockery::mock(ProductController::class);
        $renderer->shouldReceive('renderProduct')->once()->withArgs(fn ($actual, $draft, $snapshot) =>
            $actual->id === $product->id && $draft && count($snapshot['matrix1']['variants']) === 4
        )->andReturn($view);
        $this->app->instance(ProductController::class, $renderer);
        $this->actingAs(new Admin(['email' => 'test@example.test']), 'admin')
            ->postJson(route('admin.products.content.preview', $product), ['blocks' => ['matrix1' => $this->preset()]])
            ->assertOk()->assertSee('Matrix preview');
        $this->assertSame(0, $product->page()->count());
    }

    public function test_invalid_prices_and_duplicate_quantities_are_rejected_without_saving(): void
    {
        $this->actingAs(new Admin(['email' => 'test@example.test']), 'admin');
        $product = $this->product();
        foreach (['negative', 'duplicate', 'unknown', 'duplicate-id', 'too-many-rows'] as $invalid) {
            $data = $this->preset();
            if ($invalid === 'negative') $data['variants'][0]['rows'][0]['prices']['size50'] = '-1';
            if ($invalid === 'duplicate') $data['variants'][0]['rows'][1]['quantity'] = 1;
            if ($invalid === 'unknown') $data['variants'][0]['delivery_id'] = 'unknown';
            if ($invalid === 'duplicate-id') $data['sizes'][1]['id'] = $data['sizes'][0]['id'];
            if ($invalid === 'too-many-rows') $data['variants'][0]['rows'] = array_fill(0, 101, $data['variants'][0]['rows'][0]);
            $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => ['matrix1' => $data]])->assertUnprocessable();
        }
        $this->assertSame(0, $product->page()->count());
    }

    public function test_zero_and_blank_are_distinct_and_labels_can_change_without_losing_prices(): void
    {
        $data = $this->preset();
        $data['deliveries'][0]['label'] = 'Renamed delivery';
        $data['sizes'][0]['label'] = 'Renamed size';
        $data['variants'][0]['rows'][0]['prices']['size50'] = '0';
        $data['variants'][0]['rows'][0]['prices']['size75'] = '';
        $data['default_delivery'] = 'deleted';
        $clean = PriceMatrixContent::normalize($data);
        $this->assertSame('0', $clean['variants'][0]['rows'][0]['prices']['size50']);
        $this->assertNull($clean['variants'][0]['rows'][0]['prices']['size75']);
        $this->assertSame('days10', $clean['default_delivery']);
        $this->assertSame('Renamed size', $clean['sizes'][0]['label']);
    }

    public function test_storefront_escapes_labels_and_embedded_json_and_renders_default_rows(): void
    {
        $data = PriceMatrixContent::normalize($this->preset());
        $data['title'] = '<script>alert(1)</script>';
        $data['sizes'][0]['label'] = '</script><img src=x onerror=alert(1)>';
        $html = view('products.partials.price-matrix', ['content' => $data, 'blockId' => 'matrix'])->render();
        $this->assertStringNotContainsString('<script>alert(1)', $html);
        $this->assertStringNotContainsString('<img src=x', $html);
        $this->assertStringContainsString('&lt;script&gt;', $html);
        $this->assertStringContainsString('<td>990</td>', $html);
        $this->assertStringContainsString('data-pm-choice="delivery"', $html);
        $empty = view('products.partials.price-matrix', ['content' => PriceMatrixContent::defaults(), 'blockId' => 'empty'])->render();
        $this->assertStringContainsString('data-pm-table  hidden', $empty);
    }

    public function test_full_product_view_renders_matrix_inside_and_outside_accordion(): void
    {
        $html = view('products.show', [
            'product' => new Product(['name' => 'Matrix product', 'slug' => 'matrix-product']),
            'layout' => $this->layout(),
            'contents' => ['matrix1' => $this->preset(), 'matrix2' => $this->preset()],
            'publishedAt' => null,
        ])->render();

        $this->assertSame(2, substr_count($html, 'class="price-matrix" data-price-matrix'));
        $this->assertStringContainsString('/js/price-matrix.js', $html);
        $this->assertStringContainsString('/css/price-matrix.css', $html);
    }

    public function test_description_html_is_sanitized_and_legacy_text_stays_literal(): void
    {
        $data = $this->preset();
        $data['description_format'] = 'html';
        $data['description'] = '<p><strong>Safe</strong><a href="https://example.test">Link</a></p><script>alert(1)</script><img src="x" onerror="alert(2)">';
        $clean = PriceMatrixContent::normalize($data);
        $this->assertStringContainsString('<strong>Safe</strong>', $clean['description']);
        $this->assertStringContainsString('href="https://example.test"', $clean['description']);
        $this->assertStringNotContainsString('<script', $clean['description']);
        $this->assertStringNotContainsString('onerror', $clean['description']);
        $clean['description'] .= str_repeat('<p>Long description</p>', 150);
        $this->assertGreaterThan(2000, strlen(PriceMatrixContent::normalize($clean)['description']));

        $legacy = $this->preset();
        $legacy['description'] = 'Literal <strong>text</strong>';
        $html = view('products.partials.price-matrix', ['content' => $legacy, 'blockId' => 'legacy'])->render();
        $this->assertStringContainsString('Literal &lt;strong&gt;text&lt;/strong&gt;', $html);
    }

    private function dynamicMatrix(int $groupCount = 3): array
    {
        $data = PriceMatrixContent::withGroups($this->preset());
        while (count($data['option_groups']) < $groupCount) {
            $id = 'group'.count($data['option_groups']);
            $data['option_groups'][] = ['id' => $id, 'label' => 'Material '.$id, 'options' => [
                ['id' => 'standard', 'label' => 'Standard'], ['id' => 'premium', 'label' => 'Premium'],
            ], 'default_option' => 'standard'];
            foreach ($data['variants'] as &$variant) $variant['selections'][$id] = 'standard';
            unset($variant);
        }
        return $data;
    }

    public function test_dynamic_groups_save_reload_preview_publish_and_render(): void
    {
        $this->actingAs(new Admin(['email' => 'test@example.test']), 'admin');
        $product = $this->product(); $data = $this->dynamicMatrix(5);
        $extra = $data['variants'][0];
        $extra['selections']['group2'] = 'premium';
        $extra['rows'][0]['prices']['size50'] = '1234';
        $data['variants'][] = $extra;
        $data['option_groups'] = array_reverse($data['option_groups']);
        $url = '/api/v1/admin/products/'.$product->id.'/page';
        $this->putJson($url, ['blocks' => ['matrix1' => $data, 'matrix2' => $data]])->assertOk();
        $this->getJson($url)->assertOk()->assertJsonPath('data.content.blocks.matrix1.option_groups.0.id', 'group4')
            ->assertJsonPath('data.content.blocks.matrix1.variants.4.selections.group2', 'premium')
            ->assertJsonPath('data.content.blocks.matrix1.variants.4.rows.0.prices.size50', '1234');
        $this->postJson($url.'/publish')->assertOk();
        $saved = $product->page()->first()->published_content_json['blocks']['matrix1'];
        $this->assertSame(PriceMatrixContent::normalize($data), $saved);
        $this->assertSame($saved, PriceMatrixContent::normalize($saved));
        $snapshot = app(\App\Http\Controllers\Api\V1\Admin\ProductPageController::class)->sanitizePreviewContent($this->layout(), ['matrix1' => $data]);
        $this->assertSame($saved, $snapshot['matrix1']);
        $html = view('products.partials.price-matrix', ['content' => $saved, 'blockId' => 'dynamic'])->render();
        $this->assertSame(5, substr_count($html, '<fieldset>'));
        $this->assertStringContainsString('data-pm-choice="group4"', $html);
        $this->assertStringContainsString('<td>990</td>', $html);
        $this->assertCount(5, $saved['variants']);
    }

    public function test_dynamic_groups_support_zero_or_one_group_and_scope_option_ids(): void
    {
        foreach ([0, 1] as $count) {
            $data = $this->dynamicMatrix();
            $data['option_groups'] = array_slice($data['option_groups'], 0, $count);
            $selected = $count ? ['delivery' => 'days10'] : [];
            $data['variants'] = [['selections' => $selected, 'rows' => [
                ['quantity' => 1, 'prices' => ['size50' => '0', 'size75' => '']],
            ]]];
            $clean = PriceMatrixContent::normalize($data);
            $this->assertCount($count, $clean['option_groups']);
            $this->assertSame('0', $clean['variants'][0]['rows'][0]['prices']['size50']);
            $this->assertNull($clean['variants'][0]['rows'][0]['prices']['size75']);
            $html = view('products.partials.price-matrix', ['content' => $clean, 'blockId' => 'simple'])->render();
            $this->assertSame($count, substr_count($html, '<fieldset>'));
            $this->assertStringContainsString('<td>0</td>', $html);
        }
        $data = $this->dynamicMatrix(4);
        $data['option_groups'][2]['default_option'] = 'deleted';
        $clean = PriceMatrixContent::normalize($data);
        $this->assertSame('standard', $clean['option_groups'][2]['default_option']);
        $this->assertSame($clean, PriceMatrixContent::normalize($clean));
    }

    public function test_dynamic_groups_reject_invalid_or_duplicate_combinations_without_saving(): void
    {
        $this->actingAs(new Admin(['email' => 'test@example.test']), 'admin'); $product = $this->product();
        foreach (['duplicate-group', 'duplicate-option', 'unknown-option', 'missing-group', 'unknown-group', 'duplicate-combination', 'negative', 'duplicate-quantity', 'no-options', 'too-many-groups', 'unsafe-id'] as $case) {
            $data = $this->dynamicMatrix();
            if ($case === 'duplicate-group') $data['option_groups'][1]['id'] = 'delivery';
            if ($case === 'duplicate-option') $data['option_groups'][0]['options'][1]['id'] = 'days10';
            if ($case === 'unknown-option') $data['variants'][0]['selections']['group2'] = 'unknown';
            if ($case === 'missing-group') unset($data['variants'][0]['selections']['group2']);
            if ($case === 'unknown-group') $data['variants'][0]['selections']['unknown'] = 'standard';
            if ($case === 'duplicate-combination') $data['variants'][] = $data['variants'][0];
            if ($case === 'negative') $data['variants'][0]['rows'][0]['prices']['size50'] = '-2';
            if ($case === 'duplicate-quantity') $data['variants'][0]['rows'][1]['quantity'] = 1;
            if ($case === 'no-options') $data['option_groups'][0]['options'] = [];
            if ($case === 'too-many-groups') $data['option_groups'] = array_fill(0, 13, $data['option_groups'][0]);
            if ($case === 'unsafe-id') $data['option_groups'][0]['id'] = '__proto__';
            $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => ['matrix1' => $data]])->assertUnprocessable();
        }
        $this->assertSame(0, $product->page()->count());
    }

    public function test_legacy_matrix_upgrade_preserves_all_prices_and_ids(): void
    {
        $old = $this->preset(); $converted = PriceMatrixContent::withGroups($old);
        $this->assertSame($old['deliveries'], $converted['option_groups'][0]['options']);
        $this->assertSame($old['prints'], $converted['option_groups'][1]['options']);
        foreach ($old['variants'] as $index => $variant) {
            $this->assertSame($variant['rows'], $converted['variants'][$index]['rows']);
            $this->assertSame(['delivery' => $variant['delivery_id'], 'print' => $variant['print_id']], $converted['variants'][$index]['selections']);
        }
        $this->assertSame($converted['variants'], PriceMatrixContent::normalize($converted)['variants']);
    }
}
