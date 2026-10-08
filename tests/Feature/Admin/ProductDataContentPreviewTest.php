<?php

namespace Tests\Feature\Admin;

use App\Http\Controllers\Storefront\ProductController;
use App\Models\Admin;
use App\Models\ProductDataLayout;
use App\Models\ProductDataPage;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class ProductDataContentPreviewTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('product_data_layouts', function (Blueprint $table): void {
            $table->id();
            $table->text('draft_layout_json')->nullable();
            $table->text('published_layout_json')->nullable();
            $table->timestamps();
        });
        Schema::create('product_data_pages', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('product_data_layout_id')->nullable();
            $table->string('status')->default('draft');
            $table->text('draft_content_json')->nullable();
            $table->text('published_content_json')->nullable();
            $table->timestamps();
        });
    }

    private function page(): ProductDataPage
    {
        $layout = ProductDataLayout::create(['draft_layout_json' => ['rows' => [
            ['columns' => [['blocks' => [
                ['id' => 'text-one', 'type' => 'rich_text'],
                ['id' => 'accordion-one', 'type' => 'accordion', 'children' => [
                    ['id' => 'text-two', 'type' => 'rich_text'],
                ]],
            ]]]],
        ]]]);

        return ProductDataPage::create(['name' => 'Draft page', 'product_data_layout_id' => $layout->id, 'draft_content_json' => ['blocks' => []], 'published_content_json' => ['blocks' => ['live' => 'unchanged']]]);
    }

    public function test_preview_uses_product_data_sanitizer_and_does_not_save(): void
    {
        $page = $this->page();
        $before = DB::table('product_data_pages')->first();
        $view = Mockery::mock(View::class);
        $view->shouldReceive('render')->once()->andReturn('<html>Product Data Preview</html>');
        $renderer = Mockery::mock(ProductController::class);
        $renderer->shouldReceive('showProductDataPage')->once()->withArgs(function (ProductDataPage $actual, bool $draft, array $snapshot) use ($page): bool {
            return $actual->id === $page->id && $draft
                && str_contains($snapshot['text-one']['content'], 'Edited text')
                && ! str_contains($snapshot['text-one']['content'], '<script>')
                && $snapshot['text-one']['content_format'] === 'html'
                && str_contains($snapshot['text-two']['content'], 'Second text')
                && ! isset($snapshot['not-in-layout']);
        })->andReturn($view);
        $this->app->instance(ProductController::class, $renderer);

        $this->actingAs(new Admin(['email' => 'admin@example.test']), 'admin')
            ->postJson(route('admin.product-data.content.preview', $page), ['blocks' => [
                'text-one' => ['content' => '<p>Edited text</p><script>alert(1)</script>'],
                'text-two' => ['content' => '<p>Second text</p>'],
                'not-in-layout' => ['content' => 'Ignored'],
            ]])->assertOk()->assertSee('Product Data Preview')->assertHeader('Cache-Control', 'no-store, private');

        $this->assertEquals($before, DB::table('product_data_pages')->first());
    }

    public function test_preview_requires_admin(): void
    {
        $this->postJson(route('admin.product-data.content.preview', $this->page()), ['blocks' => []])->assertUnauthorized();
    }

    public function test_preview_validates_blocks(): void
    {
        $this->actingAs(new Admin(['email' => 'admin@example.test']), 'admin')
            ->postJson(route('admin.product-data.content.preview', $this->page()), ['blocks' => 'invalid'])
            ->assertUnprocessable()->assertJsonValidationErrors('blocks');
    }

    public function test_preview_requires_layout(): void
    {
        $page = ProductDataPage::create(['name' => 'No layout']);
        $this->actingAs(new Admin(['email' => 'admin@example.test']), 'admin')
            ->postJson(route('admin.product-data.content.preview', $page), ['blocks' => []])->assertUnprocessable();
    }
}
