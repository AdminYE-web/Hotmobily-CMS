<?php

namespace Tests\Feature\Admin;

use App\Http\Controllers\Storefront\ProductController;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductLayout;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class ProductContentPreviewTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('product_layouts', function (Blueprint $table): void {
            $table->id();
            $table->text('draft_layout_json')->nullable();
            $table->text('published_layout_json')->nullable();
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
            $table->text('draft_content_json');
            $table->text('published_content_json');
        });
    }

    private function product(): Product
    {
        $layout = ProductLayout::create(['draft_layout_json' => ['rows' => [
            ['columns' => [['blocks' => [
                ['id' => 'header-one', 'type' => 'product_header'],
                ['id' => 'accordion-one', 'type' => 'accordion', 'children' => [
                    ['id' => 'header-two', 'type' => 'product_header'],
                ]],
            ]]]],
        ]]]);

        return Product::create(['product_layout_id' => $layout->id, 'status' => 'draft']);
    }

    public function test_preview_uses_sanitized_snapshot_without_saving_or_publishing(): void
    {
        $product = $this->product();
        DB::table('product_pages')->insert(['product_id' => $product->id, 'draft_content_json' => '{"blocks":{}}', 'published_content_json' => '{"blocks":{"live":"unchanged"}}']);
        $before = DB::table('product_pages')->first();
        $view = Mockery::mock(View::class);
        $view->shouldReceive('render')->once()->andReturn('<html>Preview</html>');
        $renderer = Mockery::mock(ProductController::class);
        $renderer->shouldReceive('renderProduct')->once()->withArgs(function (Product $actual, bool $draft, array $snapshot) use ($product): bool {
            return $actual->id === $product->id && $draft
                && $snapshot['header-one']['title'] === 'Edited title'
                && $snapshot['header-two']['title'] === 'Second header'
                && ! isset($snapshot['not-in-layout'])
                && ! isset($snapshot['header-one']['unrecognized_field']);
        })->andReturn($view);
        $this->app->instance(ProductController::class, $renderer);

        $this->actingAs(new Admin(['email' => 'admin@example.test']), 'admin')
            ->postJson(route('admin.products.content.preview', $product), ['blocks' => [
                'header-one' => ['title' => 'Edited title', 'unrecognized_field' => '<script>bad()</script>'],
                'header-two' => ['title' => 'Second header'],
                'not-in-layout' => ['title' => 'Ignored'],
            ]])->assertOk()->assertSee('Preview')->assertHeader('Cache-Control', 'no-store, private');

        $this->assertEquals($before, DB::table('product_pages')->first());
        $this->assertDatabaseHas('products', ['id' => $product->id, 'status' => 'draft']);
    }

    public function test_preview_requires_admin_authentication(): void
    {
        $this->postJson(route('admin.products.content.preview', $this->product()), ['blocks' => []])->assertUnauthorized();
    }

    public function test_preview_validates_payload(): void
    {
        $this->actingAs(new Admin(['email' => 'admin@example.test']), 'admin')
            ->postJson(route('admin.products.content.preview', $this->product()), ['blocks' => 'invalid'])
            ->assertUnprocessable()->assertJsonValidationErrors('blocks');
    }

    public function test_preview_rejects_products_without_a_layout(): void
    {
        $product = Product::create(['status' => 'draft']);
        $this->actingAs(new Admin(['email' => 'admin@example.test']), 'admin')
            ->postJson(route('admin.products.content.preview', $product), ['blocks' => []])->assertUnprocessable();
    }

    public function test_edit_metadata_is_only_rendered_in_visual_preview(): void
    {
        $data = ['block' => ['id' => 'actual-block', 'type' => 'divider'], 'contents' => [], 'product' => new Product(), 'publishedAt' => null];
        $publicHtml = view('products.partials.block', $data)->render();
        $previewHtml = view('products.partials.block', $data + ['visualEditorPreview' => true])->render();

        $this->assertStringNotContainsString('data-editor-block-id', $publicHtml);
        $this->assertStringContainsString('data-editor-block-id="actual-block"', $previewHtml);
        $this->assertStringContainsString('data-editor-block-type="divider"', $previewHtml);
    }
}
