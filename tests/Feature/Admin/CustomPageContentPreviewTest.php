<?php

namespace Tests\Feature\Admin;

use App\Http\Controllers\Storefront\CustomPageController;
use App\Models\Admin;
use App\Models\CustomPageLayout;
use App\Models\CustomPage;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Mockery;
use Tests\TestCase;

class CustomPageContentPreviewTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('custom_page_layouts', function (Blueprint $table): void {
            $table->id();
            $table->text('draft_layout_json')->nullable();
            $table->text('published_layout_json')->nullable();
            $table->timestamps();
        });
        Schema::create('custom_pages', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('custom_page_layout_id')->nullable();
            $table->string('status')->default('draft');
            $table->text('draft_content_json')->nullable();
            $table->text('published_content_json')->nullable();
            $table->timestamps();
        });
    }

    private function page(): CustomPage
    {
        $layout = CustomPageLayout::create(['draft_layout_json' => ['rows' => [
            ['columns' => [['blocks' => [
                ['id' => 'text-one', 'type' => 'rich_text'],
                ['id' => 'accordion-one', 'type' => 'accordion', 'children' => [
                    ['id' => 'text-two', 'type' => 'rich_text'],
                ]],
            ]]]],
        ]]]);

        return CustomPage::create(['name' => 'Draft page', 'custom_page_layout_id' => $layout->id, 'draft_content_json' => ['blocks' => []], 'published_content_json' => ['blocks' => ['live' => 'unchanged']]]);
    }

    public function test_preview_uses_custom_page_sanitizer_and_does_not_save(): void
    {
        $page = $this->page();
        $before = DB::table('custom_pages')->first();
        $view = Mockery::mock(View::class);
        $view->shouldReceive('render')->once()->andReturn('<html>Custom Page Preview</html>');
        $renderer = Mockery::mock(CustomPageController::class);
        $renderer->shouldReceive('renderPage')->once()->withArgs(function (CustomPage $actual, bool $draft, array $snapshot) use ($page): bool {
            return $actual->id === $page->id && $draft
                && str_contains($snapshot['text-one']['content'], 'Edited text')
                && ! str_contains($snapshot['text-one']['content'], '<script>')
                && $snapshot['text-one']['content_format'] === 'html'
                && str_contains($snapshot['text-two']['content'], 'Second text')
                && ! isset($snapshot['not-in-layout']);
        })->andReturn($view);
        $this->app->instance(CustomPageController::class, $renderer);

        $this->actingAs(new Admin(['email' => 'admin@example.test']), 'admin')
            ->postJson(route('admin.custom-pages.content.preview', $page), ['blocks' => [
                'text-one' => ['content' => '<p>Edited text</p><script>alert(1)</script>'],
                'text-two' => ['content' => '<p>Second text</p>'],
                'not-in-layout' => ['content' => 'Ignored'],
            ]])->assertOk()->assertSee('Custom Page Preview')->assertHeader('Cache-Control', 'no-store, private');

        $this->assertEquals($before, DB::table('custom_pages')->first());
    }

    public function test_preview_requires_admin(): void
    {
        $this->postJson(route('admin.custom-pages.content.preview', $this->page()), ['blocks' => []])->assertUnauthorized();
    }

    public function test_preview_validates_blocks(): void
    {
        $this->actingAs(new Admin(['email' => 'admin@example.test']), 'admin')
            ->postJson(route('admin.custom-pages.content.preview', $this->page()), ['blocks' => 'invalid'])
            ->assertUnprocessable()->assertJsonValidationErrors('blocks');
    }

    public function test_preview_requires_layout(): void
    {
        $page = CustomPage::create(['name' => 'No layout']);
        $this->actingAs(new Admin(['email' => 'admin@example.test']), 'admin')
            ->postJson(route('admin.custom-pages.content.preview', $page), ['blocks' => []])->assertUnprocessable();
    }
}
