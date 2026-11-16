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
use App\Support\TextLinkDownload;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TextLinkDownloadTest extends TestCase
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
            ['id' => 'link1', 'type' => 'text_link', 'settings' => []],
        ]]]]]];
    }

    private function product(): Product
    {
        $layout = ProductLayout::create(['draft_layout_json' => $this->layout(), 'published_layout_json' => $this->layout()]);
        return Product::create(['product_layout_id' => $layout->id]);
    }

    private function fileContent(): array
    {
        return ['text' => 'Download guide', 'url' => '/old-link', 'target' => '_blank', 'text_color' => '#123456',
            'link_mode' => 'download', 'file_path' => 'products/1/content-files/12345678-1234-4234-8234-123456789abc.pdf', 'file_name' => 'Product Guide.pdf',
            'spacing_top' => 12, 'spacing_bottom' => 18, 'underline' => false];
    }

    private function renderLink(array $content): string
    {
        return view('products.show', ['product' => new Product(['name' => 'Download QA', 'slug' => 'download-qa']),
            'layout' => $this->layout(), 'contents' => ['link1' => $content], 'publishedAt' => null])->render();
    }

    public function test_upload_save_publish_and_download_returns_original_file(): void
    {
        Storage::fake('public');
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin'); $product = $this->product();
        $upload = $this->post('/api/v1/admin/products/'.$product->id.'/files', [
            'file' => UploadedFile::fake()->createWithContent('Guide.txt', 'Product guide contents'),
        ], ['Accept' => 'application/json'])->assertCreated();
        $data = $this->fileContent(); $data['file_path'] = $upload->json('data.path'); $data['file_name'] = $upload->json('data.original_name');
        Storage::disk('public')->assertExists($data['file_path']);
        $url = '/api/v1/admin/products/'.$product->id.'/page';
        $this->putJson($url, ['blocks' => ['link1' => $data]])->assertOk();
        $this->getJson($url)->assertOk()->assertJsonPath('data.content.blocks.link1.file_path', $data['file_path']);
        $this->postJson($url.'/publish')->assertOk();
        $saved = $product->page()->first()->published_content_json['blocks']['link1'];
        $this->assertSame('download', $saved['link_mode']);
        $this->assertSame('Guide.txt', $saved['file_name']);
        $this->assertSame(12, $saved['spacing_top']);
        $this->assertSame(18, $saved['spacing_bottom']);
        $this->assertFalse($saved['underline']);
        $html = $this->renderLink($saved);
        $this->assertStringContainsString('store-text-download', $html);
        $this->assertStringContainsString('download="Guide.txt"', $html);
        $this->assertStringContainsString('margin-top: 12px; margin-bottom: 18px; text-decoration: none !important;', $html);
        $response = $this->get(TextLinkDownload::url($saved))->assertOk()->assertDownload('Guide.txt')
            ->assertHeader('X-Content-Type-Options', 'nosniff');
        $this->assertSame('Product guide contents', $response->streamedContent());
        $data['link_mode'] = 'link';
        $this->putJson($url, ['blocks' => ['link1' => $data]])->assertOk();
        $this->getJson($url)->assertJsonPath('data.content.blocks.link1.url', '/old-link')
            ->assertJsonPath('data.content.blocks.link1.file_path', $data['file_path']);
    }

    public function test_plain_links_and_download_buttons_render_their_own_destinations(): void
    {
        $data = $this->fileContent(); $data['text'] = '<script>bad()</script>';
        $html = $this->renderLink($data);
        $this->assertStringContainsString('/downloads/content/products/1/', $html);
        $this->assertStringContainsString('download="Product Guide.pdf"', $html);
        $this->assertStringContainsString('&lt;script&gt;bad()&lt;/script&gt;', $html);
        $this->assertStringNotContainsString('href="/old-link"', $html);
        $plain = ['text' => 'Regular link', 'url' => '/faq', 'target' => '_blank'];
        $html = $this->renderLink($plain);
        $this->assertStringContainsString('href="/faq"', $html);
        $this->assertStringContainsString('target="_blank"', $html);
        $this->assertStringNotContainsString('download="', $html);
        $this->assertSame('link', TextLinkDownload::normalize($plain)['link_mode']);
        $this->assertTrue(TextLinkDownload::normalize($plain)['underline']);
        $this->assertStringContainsString('margin-top: 0px; margin-bottom: 0px; text-decoration: underline !important;', $html);
        $data['file_path'] = '../../.env';
        $this->assertNull(TextLinkDownload::url($data));
    }

    public function test_content_file_upload_allows_100_mb_and_rejects_larger_files(): void
    {
        Storage::fake('public');
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $product = $this->product();
        $url = '/api/v1/admin/products/'.$product->id.'/files';
        $this->post($url, ['file' => UploadedFile::fake()->create('Guide.pdf', 102400, 'application/pdf')],
            ['Accept' => 'application/json'])->assertCreated();
        $this->post($url, ['file' => UploadedFile::fake()->create('Too-large.pdf', 102401, 'application/pdf')],
            ['Accept' => 'application/json'])->assertUnprocessable()->assertJsonValidationErrors('file');
    }

    public function test_invalid_file_paths_and_missing_download_files_are_rejected(): void
    {
        Schema::create('custom_pages', function (Blueprint $table): void {
            $table->id();
            $table->string('slug');
            $table->string('status');
        });
        Storage::fake('public'); $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin'); $product = $this->product();
        foreach (['', '../../.env', 'https://evil.test/file.pdf', 'products/1/content-files/../../secret.pdf',
            'products/1/templates/12345678-1234-4234-8234-123456789abc.pdf', 'products/1/content-files/12345678-1234-4234-8234-123456789abc.php'] as $path) {
            $data = $this->fileContent(); $data['file_path'] = $path;
            $this->putJson('/api/v1/admin/products/'.$product->id.'/page', ['blocks' => ['link1' => $data]])->assertUnprocessable();
        }
        $this->assertSame(0, $product->page()->count());
        $this->get(TextLinkDownload::url($this->fileContent()))->assertNotFound();
        $this->get('/downloads/content/private/1/12345678-1234-4234-8234-123456789abc.pdf')->assertNotFound();
        $this->get('/downloads/content/products/1/12345678-1234-4234-8234-123456789abc.php')->assertNotFound();
    }

    public function test_preview_keeps_download_metadata_without_persisting(): void
    {
        $product = $this->product(); $view = Mockery::mock(View::class);
        $view->shouldReceive('render')->once()->andReturn('<html>Download preview</html>');
        $renderer = Mockery::mock(ProductController::class);
        $renderer->shouldReceive('renderProduct')->once()->withArgs(fn ($actual, $draft, $snapshot) =>
            $actual->id === $product->id && $draft && $snapshot['link1']['link_mode'] === 'download'
            && $snapshot['link1']['file_name'] === 'Product Guide.pdf'
        )->andReturn($view);
        $this->app->instance(ProductController::class, $renderer);
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin')
            ->postJson(route('admin.products.content.preview', $product), ['blocks' => ['link1' => $this->fileContent()]])
            ->assertOk()->assertSee('Download preview');
        $this->assertSame(0, $product->page()->count());
    }
}
