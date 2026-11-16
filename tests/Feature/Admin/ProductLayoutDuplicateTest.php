<?php

namespace Tests\Feature\Admin;

use App\Models\ProductLayout;
use App\Models\Admin;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductLayoutDuplicateTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('product_layouts', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('status');
            $table->text('draft_layout_json')->nullable();
            $table->text('published_layout_json')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    private function source(): ProductLayout
    {
        return ProductLayout::create([
            'name' => 'Rubber Strap', 'slug' => 'rubber-strap', 'description' => 'Original description',
            'status' => 'published', 'published_at' => now(),
            'published_layout_json' => ['version' => 2, 'rows' => []],
            'draft_layout_json' => ['version' => 2, 'rows' => [
                ['id' => 'row-1', 'columns' => [['width' => 100, 'blocks' => [
                    ['id' => 'accordion-1', 'type' => 'accordion', 'children' => [
                        ['id' => 'table-1', 'type' => 'custom_table', 'settings' => ['title' => 'Details']],
                    ]],
                ]]]],
            ]],
        ]);
    }

    public function test_duplicate_preserves_nested_structure_and_is_an_independent_draft(): void
    {
        Sanctum::actingAs(new Admin);
        $source = $this->source();
        $before = $source->fresh()->getAttributes();

        $response = $this->postJson('/api/v1/admin/product-layouts/'.$source->id.'/duplicate')
            ->assertCreated()->assertJsonPath('data.name', 'Rubber Strap (Copy)')
            ->assertJsonPath('data.slug', 'rubber-strap-copy')->assertJsonPath('data.status', 'draft')
            ->assertJsonPath('data.published_at', null)->assertJsonPath('data.published_layout_json', null);

        $copy = ProductLayout::findOrFail($response->json('data.id'));
        $this->assertNotEquals($source->id, $copy->id);
        $this->assertSame($source->description, $copy->description);
        $this->assertSame($source->draft_layout_json, $copy->draft_layout_json);
        $copy->update(['draft_layout_json' => ['version' => 2, 'rows' => []]]);
        $this->assertSame($before, $source->fresh()->getAttributes());

        $this->postJson('/api/v1/admin/product-layouts/'.$source->id.'/duplicate')
            ->assertCreated()->assertJsonPath('data.slug', 'rubber-strap-copy-2');
    }

    public function test_duplicate_uses_published_layout_when_no_draft_exists(): void
    {
        Sanctum::actingAs(new Admin);
        $source = $this->source();
        $published = $source->draft_layout_json;
        $source->update(['draft_layout_json' => null, 'published_layout_json' => $published]);

        $this->postJson('/api/v1/admin/product-layouts/'.$source->id.'/duplicate')
            ->assertCreated()->assertJsonPath('data.draft_layout_json', $published);
    }

    public function test_duplicate_requires_authentication(): void
    {
        $this->postJson('/api/v1/admin/product-layouts/'.$this->source()->id.'/duplicate')
            ->assertUnauthorized();
        $this->assertSame(1, ProductLayout::count());
    }

    public function test_duplicate_returns_not_found_for_missing_layout(): void
    {
        Sanctum::actingAs(new Admin);
        $this->postJson('/api/v1/admin/product-layouts/999/duplicate')->assertNotFound();
    }
}
