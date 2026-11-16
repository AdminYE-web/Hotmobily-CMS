<?php

namespace Tests\Feature\Admin;

use App\Http\Controllers\Storefront\ProductController;
use App\Models\Admin;
use App\Models\Product;
use App\Models\ProductContentRevision;
use App\Models\ProductLayout;
use App\Models\ProductPage;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Laravel\Sanctum\Sanctum;
use Mockery;
use Tests\TestCase;

class ProductContentRevisionTest extends TestCase
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
        (require database_path('migrations/2026_10_22_000000_create_product_content_revisions_table.php'))->up();
    }

    private function product(): Product
    {
        $layoutJson = ['version' => 2, 'rows' => [['id' => 'row1', 'columns' => [['width' => 12, 'blocks' => [
            ['id' => 'title', 'type' => 'product_header', 'settings' => []],
        ]]]]]];
        $layout = ProductLayout::create(['draft_layout_json' => $layoutJson, 'published_layout_json' => $layoutJson]);
        $product = Product::create(['product_layout_id' => $layout->id]);
        $product->page()->create([
            'draft_content_json' => ['version' => 1, 'blocks' => ['title' => ['title' => 'Original']]],
            'published_content_json' => ['version' => 1, 'blocks' => ['title' => ['title' => 'Live']]],
            'published_at' => now()->subDay(),
        ]);

        return $product;
    }

    private function authenticate(): void
    {
        Sanctum::actingAs(new Admin(['email' => 'editor@example.test', 'staff_name' => 'Editor']));
    }

    private function save(Product $product, string $title): void
    {
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => [
            'title' => ['title' => $title, 'unrecognized_field' => '<script>bad()</script>'],
        ]])->assertOk();
    }

    public function test_saving_and_publishing_record_sanitized_versions_and_preserve_existing_content(): void
    {
        $this->authenticate();
        $product = $this->product();
        $this->save($product, 'Edited');
        $this->assertSame(3, ProductContentRevision::count());
        $this->assertSame('Live', ProductContentRevision::where('version', 1)->first()->snapshot_json['content']['blocks']['title']['title']);
        $this->assertSame('Original', ProductContentRevision::where('version', 2)->first()->snapshot_json['content']['blocks']['title']['title']);
        $revision = ProductContentRevision::where('version', 3)->firstOrFail();
        $this->assertSame('Edited', $revision->snapshot_json['content']['blocks']['title']['title']);
        $this->assertSame('Editor', $revision->created_by);
        $this->assertArrayNotHasKey('unrecognized_field', $revision->snapshot_json['content']['blocks']['title']);
        $this->getJson('/api/v1/admin/products/'.$product->id.'/revisions')->assertOk()
            ->assertJsonPath('current_versions.draft.version', 3)
            ->assertJsonPath('current_versions.published.version', 1);
        $this->save($product, 'Edited');
        $this->assertSame(3, ProductContentRevision::count());
        $this->postJson('/api/v1/admin/products/'.$product->id.'/page/publish')->assertOk();
        $this->assertSame('published', ProductContentRevision::orderByDesc('version')->first()->action);
        $this->getJson('/api/v1/admin/products/'.$product->id.'/revisions')->assertOk()
            ->assertJsonPath('latest_version', 4)->assertJsonPath('data.data.0.version', 4)
            ->assertJsonPath('current_versions.draft.version', 4)
            ->assertJsonPath('current_versions.published.version', 4)
            ->assertJsonMissingPath('data.data.0.snapshot_json');
    }

    public function test_publish_with_editor_content_creates_only_a_published_revision(): void
    {
        $this->authenticate();
        $product = $this->product();
        $this->save($product, 'Saved draft');
        $count = ProductContentRevision::count();
        $this->postJson('/api/v1/admin/products/'.$product->id.'/page/publish', ['blocks' => [
            'title' => ['title' => 'Unsaved edit', 'unrecognized_field' => 'Ignored'],
        ]])->assertOk();
        $this->assertSame($count + 1, ProductContentRevision::count());
        $revision = ProductContentRevision::orderByDesc('version')->firstOrFail();
        $this->assertSame('published', $revision->action);
        $this->assertSame('Unsaved edit', $revision->snapshot_json['content']['blocks']['title']['title']);
        $this->assertArrayNotHasKey('unrecognized_field', $revision->snapshot_json['content']['blocks']['title']);
        $page = $product->page()->firstOrFail();
        $this->assertSame($page->draft_content_json, $page->published_content_json);
        $this->assertSame('Unsaved edit', $page->published_content_json['blocks']['title']['title']);
    }

    public function test_invalid_publish_content_does_not_change_the_draft_or_history(): void
    {
        $this->authenticate();
        $product = $this->product();
        $before = $product->page()->first()->getAttributes();
        $this->postJson('/api/v1/admin/products/'.$product->id.'/page/publish', ['blocks' => 'invalid'])
            ->assertUnprocessable();
        $this->assertSame($before, $product->page()->first()->getAttributes());
        $this->assertSame(0, ProductContentRevision::count());
    }

    public function test_restoring_is_a_new_draft_and_keeps_published_content_and_history(): void
    {
        $this->authenticate();
        $product = $this->product();
        $before = $product->page;
        $published = $before->published_content_json;
        $publishedAt = $before->getRawOriginal('published_at');
        $this->save($product, 'Edited');
        $revision = ProductContentRevision::where('version', 2)->firstOrFail();
        $snapshot = $revision->snapshot_json;
        $this->postJson('/api/v1/admin/products/'.$product->id.'/revisions/'.$revision->id.'/restore', ['expected_version' => 3])->assertOk();
        $page = $product->page()->firstOrFail();
        $this->assertSame('Original', $page->draft_content_json['blocks']['title']['title']);
        $this->assertSame($published, $page->published_content_json);
        $this->assertSame($publishedAt, $page->getRawOriginal('published_at'));
        $this->assertSame($snapshot, $revision->fresh()->snapshot_json);
        $this->assertSame('restored', ProductContentRevision::where('version', 4)->firstOrFail()->action);
        $this->getJson('/api/v1/admin/products/'.$product->id.'/revisions')->assertOk()
            ->assertJsonPath('current_versions.draft.version', 4)
            ->assertJsonPath('current_versions.draft.restored_from_version', 2)
            ->assertJsonPath('data.data.0.restored_from_version', 2)
            ->assertJsonMissingPath('data.data.0.snapshot_json')
            ->assertJsonPath('current_versions.published.version', 1);
    }

    public function test_current_version_does_not_claim_unrecorded_or_changed_content_is_a_saved_version(): void
    {
        $this->authenticate();
        $product = $this->product();
        $this->getJson('/api/v1/admin/products/'.$product->id.'/revisions')->assertOk()
            ->assertJsonPath('current_versions.draft.version', null)
            ->assertJsonPath('current_versions.draft.has_content', true);
        $this->save($product, 'Edited');
        $product->page()->update(['draft_content_json' => json_encode(['blocks' => ['title' => ['title' => 'External edit']]])]);
        $this->getJson('/api/v1/admin/products/'.$product->id.'/revisions')->assertOk()
            ->assertJsonPath('current_versions.draft.version', null)
            ->assertJsonPath('current_versions.published.version', 1);
    }

    public function test_stale_and_cross_product_restore_are_rejected(): void
    {
        $this->authenticate();
        $product = $this->product();
        $this->save($product, 'First');
        $revision = ProductContentRevision::firstOrFail();
        $this->save($product, 'Second');
        $this->postJson('/api/v1/admin/products/'.$product->id.'/revisions/'.$revision->id.'/restore', ['expected_version' => 3])->assertConflict();
        $this->assertSame('Second', $product->page()->first()->draft_content_json['blocks']['title']['title']);
        $other = $this->product();
        $this->postJson('/api/v1/admin/products/'.$other->id.'/revisions/'.$revision->id.'/restore', ['expected_version' => 4])->assertNotFound();
        $this->actingAs(new Admin(['email' => 'editor@example.test']), 'admin')
            ->get(route('admin.products.revisions.preview', [$other, $revision]))->assertNotFound();
    }

    public function test_preview_uses_historical_content_and_layout_without_writing(): void
    {
        $this->authenticate();
        $product = $this->product();
        $this->save($product, 'Edited');
        $revision = ProductContentRevision::where('version', 2)->firstOrFail();
        $product->layout->update(['draft_layout_json' => ['rows' => []]]);
        $before = $product->page()->first()->getAttributes();
        $view = Mockery::mock(View::class);
        $view->shouldReceive('render')->once()->andReturn('<html>Historical preview</html>');
        $renderer = Mockery::mock(ProductController::class);
        $renderer->shouldReceive('renderProduct')->once()->withArgs(function ($actual, $draft, $blocks, $layout, $visualEditorPreview) use ($product, $revision): bool {
            return $actual->id === $product->id && $draft && $blocks['title']['title'] === 'Original'
                && $layout === $revision->snapshot_json['layout'] && $visualEditorPreview === false;
        })->andReturn($view);
        $this->app->instance(ProductController::class, $renderer);
        $this->actingAs(new Admin(['email' => 'editor@example.test']), 'admin')
            ->get(route('admin.products.revisions.preview', [$product, $revision]))
            ->assertOk()->assertSee('Historical preview')->assertHeader('Cache-Control', 'no-store, private');
        $this->assertSame($before, $product->page()->first()->getAttributes());
        $this->assertSame(3, ProductContentRevision::count());
    }

    public function test_revision_endpoints_require_authentication(): void
    {
        $product = $this->product();
        $this->getJson('/api/v1/admin/products/'.$product->id.'/revisions')->assertUnauthorized();
        $this->postJson('/api/v1/admin/products/'.$product->id.'/revisions/1/restore', ['expected_version' => 1])->assertUnauthorized();
        $this->getJson(route('admin.products.revisions.preview', [$product, 1]))->assertUnauthorized();
    }

    public function test_revision_failure_rolls_back_the_draft_write(): void
    {
        $this->authenticate();
        $product = $this->product();
        $before = $product->page()->first()->getAttributes();
        DB::statement("CREATE TRIGGER reject_revision BEFORE INSERT ON product_content_revisions WHEN NEW.action = 'draft_saved' BEGIN SELECT RAISE(ABORT, 'Test failure'); END");
        $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => ['title' => ['title' => 'Lost']]])->assertServerError();
        $this->assertSame($before, $product->page()->first()->getAttributes());
        $this->assertSame(0, ProductContentRevision::count());
    }
}
