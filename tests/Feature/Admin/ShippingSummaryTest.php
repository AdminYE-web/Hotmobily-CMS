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

class ShippingSummaryTest extends TestCase
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
            ['id' => 'schedule1', 'type' => 'shipping_schedule'],
        ]]]]]];
    }

    private function data(): array
    {
        return ['display_type' => 'summary', 'title' => '', 'intro_text' => 'Estimated shipping dates',
            'start_label' => 'Production start', 'shipping_label' => 'Shipping date', 'start_background' => '#bee0fa', 'footer_note' => 'Estimate only',
            'schedules' => [
                ['id' => 'fast', 'label' => '6 business days', 'days' => 6, 'theme' => 'pink', 'background_color' => '#f8cecc'],
                ['id' => 'normal', 'label' => '10 business days', 'days' => 10, 'theme' => 'blue', 'background_color' => '#bee0fa'],
            ]];
    }

    private function product(): Product
    {
        $layout = ProductLayout::create(['draft_layout_json' => $this->layout(), 'published_layout_json' => $this->layout()]);
        return Product::create(['product_layout_id' => $layout->id]);
    }

    private function renderSchedule(array $data): string
    {
        return view('products.show', ['product' => new Product(['name' => 'Schedule QA', 'slug' => 'schedule-qa']),
            'layout' => $this->layout(), 'contents' => ['schedule1' => $data], 'publishedAt' => null])->render();
    }

    public function test_summary_save_reload_publish_keep_colors_order_and_days(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin'); $product = $this->product();
        $data = $this->data(); $data['schedules'] = array_reverse($data['schedules']);
        $url = '/api/v1/admin/products/'.$product->id.'/page';
        $this->putJson($url, ['blocks' => ['schedule1' => $data]])->assertOk();
        $this->getJson($url)->assertOk()->assertJsonPath('data.content.blocks.schedule1.display_type', 'summary')
            ->assertJsonPath('data.content.blocks.schedule1.start_background', '#bee0fa')
            ->assertJsonPath('data.content.blocks.schedule1.schedules.0.days', 10)
            ->assertJsonPath('data.content.blocks.schedule1.schedules.1.background_color', '#f8cecc');
        $this->postJson($url.'/publish')->assertOk();
        $page = $product->page()->first();
        $this->assertSame($page->draft_content_json, $page->published_content_json);
        $saved = $page->published_content_json['blocks']['schedule1'];
        $data['title'] = null;
        $this->assertEquals($data, $saved);
    }

    public function test_summary_uses_shared_start_cell_dynamic_rowspan_and_safe_colors(): void
    {
        foreach ([1, 2, 3] as $count) {
            $data = $this->data();
            $data['schedules'] = array_fill(0, $count, $data['schedules'][0]);
            $html = $this->renderSchedule($data);
            $this->assertStringContainsString('rowspan="'.($count * 2 - 1).'"', $html);
            $this->assertSame(1, substr_count($html, '<strong data-shipping-start-time>'));
            $this->assertSame($count, substr_count($html, '<strong data-shipping-date-days="6">'));
            $this->assertStringContainsString('Estimated shipping dates', $html);
            $this->assertStringContainsString('Estimate only', $html);
            $this->assertStringContainsString('background-color: #f8cecc', $html);
        }
        $data['start_label'] = '<script>bad()</script>';
        $data['start_background'] = 'red; background-image:url(bad)';
        $data['schedules'][0]['background_color'] = '" onmouseover="bad()';
        $html = $this->renderSchedule($data);
        $this->assertStringContainsString('&lt;script&gt;bad()&lt;/script&gt;', $html);
        $this->assertStringNotContainsString('background-image:url(bad)', $html);
        $this->assertStringNotContainsString('onmouseover="bad()', $html);
        $data['schedules'] = [];
        $this->assertStringNotContainsString('rowspan="-1"', $this->renderSchedule($data));
    }

    public function test_legacy_display_styles_and_default_colors_remain_supported(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin'); $product = $this->product();
        foreach (['stacked', 'grouped'] as $style) {
            $data = $this->data(); $data['display_type'] = $style;
            unset($data['start_background'], $data['schedules'][0]['background_color']);
            $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => ['schedule1' => $data]])->assertOk();
            $saved = $product->page()->first()->draft_content_json['blocks']['schedule1'];
            $this->assertSame($style, $saved['display_type']);
            $this->assertSame('#f8cecc', $saved['schedules'][0]['background_color']);
            $this->assertStringNotContainsString('<table class="shipping-summary-table">', $this->renderSchedule($saved));
        }
    }

    public function test_preview_uses_unsaved_summary_without_persisting(): void
    {
        $product = $this->product(); $view = Mockery::mock(View::class);
        $view->shouldReceive('render')->once()->andReturn('<html>Summary preview</html>');
        $renderer = Mockery::mock(ProductController::class);
        $renderer->shouldReceive('renderProduct')->once()->withArgs(fn ($actual, $draft, $snapshot) =>
            $actual->id === $product->id && $draft && $snapshot['schedule1']['display_type'] === 'summary'
            && $snapshot['schedule1']['schedules'][0]['background_color'] === '#f8cecc'
        )->andReturn($view);
        $this->app->instance(ProductController::class, $renderer);
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin')
            ->postJson(route('admin.products.content.preview', $product), ['blocks' => ['schedule1' => $this->data()]])
            ->assertOk()->assertSee('Summary preview');
        $this->assertSame(0, $product->page()->count());
    }
}
