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

class AttachmentGalleryPresetTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        (require database_path('migrations/2026_10_28_000000_create_attachment_gallery_presets_table.php'))->up();
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

    public function test_presets_require_admin_authentication(): void
    {
        $this->getJson('/api/v1/admin/attachment-gallery-presets')->assertUnauthorized();
        $this->postJson('/api/v1/admin/attachment-gallery-presets', ['name' => 'Test', 'content' => $this->gallery()])->assertUnauthorized();
        $this->putJson('/api/v1/admin/attachment-gallery-presets/1', [])->assertUnauthorized();
        $this->deleteJson('/api/v1/admin/attachment-gallery-presets/1')->assertUnauthorized();
    }

    public function test_save_list_load_update_and_delete_presets(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $url = '/api/v1/admin/attachment-gallery-presets';
        $gallery = $this->gallery();
        $response = $this->postJson($url, ['name' => 'Acrylic attachments', 'content' => $gallery])->assertCreated();
        $id = $response->json('data.id');
        $this->getJson($url)->assertOk()->assertJsonCount(1, 'data')->assertJsonPath('data.0.name', 'Acrylic attachments')
            ->assertJsonMissingPath('data.0.content_json');
        $this->getJson($url.'/'.$id)->assertOk()->assertJsonPath('data.content_json.columns', 3);
        $this->assertSame(AttachmentGalleryContent::normalize($gallery), $response->json('data.content_json'));
        $gallery['columns'] = 2; $gallery['items'] = array_reverse($gallery['items']);
        $this->putJson($url.'/'.$id, ['name' => 'Updated set', 'content' => $gallery])->assertOk()
            ->assertJsonPath('data.name', 'Updated set')->assertJsonPath('data.content_json.columns', 2)
            ->assertJsonPath('data.content_json.items.0.id', $gallery['items'][0]['id']);
        $this->deleteJson($url.'/'.$id)->assertOk();
        $this->getJson($url)->assertJsonCount(0, 'data');
        $this->getJson($url.'/'.$id)->assertNotFound();
    }

    public function test_loaded_galleries_are_independent_of_preset_and_each_other(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $url = '/api/v1/admin/attachment-gallery-presets';
        $response = $this->postJson($url, ['name' => 'Shared set', 'content' => $this->gallery()])->assertCreated();
        $id = $response->json('data.id'); $gallery = $response->json('data.content_json');
        $first = $this->product(); $second = $this->product();
        foreach ([$first, $second] as $product) {
            $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => ['gallery1' => $gallery]])->assertOk();
            $this->postJson('/api/v1/admin/products/'.$product->id.'/page/publish')->assertOk();
        }
        $edited = $gallery; $edited['items'][0]['title'] = 'Product-specific title';
        $this->putJson('/api/v1/admin/products/'.$first->id.'/page', ['blocks' => ['gallery1' => $edited]])->assertOk();
        $this->getJson($url.'/'.$id)->assertJsonPath('data.content_json.items.0.title', $gallery['items'][0]['title']);
        $this->assertSame($gallery, $second->page()->first()->published_content_json['blocks']['gallery1']);
        $this->putJson($url.'/'.$id, ['name' => 'Shared set', 'content' => $edited])->assertOk();
        $this->assertSame($gallery, $second->page()->first()->published_content_json['blocks']['gallery1']);
        $this->deleteJson($url.'/'.$id)->assertOk();
        $this->assertSame($gallery, $second->page()->first()->published_content_json['blocks']['gallery1']);
    }

    public function test_invalid_names_content_and_duplicate_names_do_not_create_presets(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $url = '/api/v1/admin/attachment-gallery-presets';
        foreach (['empty', 'long-name', 'empty-gallery', 'unsafe-image', 'duplicate-item'] as $case) {
            $body = ['name' => 'Test', 'content' => $this->gallery()];
            if ($case === 'empty') $body['name'] = '   ';
            if ($case === 'long-name') $body['name'] = str_repeat('x', 151);
            if ($case === 'empty-gallery') $body['content']['items'] = [];
            if ($case === 'unsafe-image') $body['content']['items'][0]['image_url'] = 'javascript:alert(1)';
            if ($case === 'duplicate-item') $body['content']['items'][1]['id'] = $body['content']['items'][0]['id'];
            $this->postJson($url, $body)->assertUnprocessable();
        }
        $this->assertDatabaseCount('attachment_gallery_presets', 0);
        $this->postJson($url, ['name' => 'Unique name', 'content' => $this->gallery()])->assertCreated();
        $this->postJson($url, ['name' => 'Unique name', 'content' => $this->gallery()])->assertUnprocessable()->assertJsonValidationErrors('name');
        $this->assertDatabaseCount('attachment_gallery_presets', 1);
    }
}
