<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\Faq;
use App\Models\HomeProductCard;
use App\Models\OptionPriceRule;
use App\Models\OptionPriceRuleCondition;
use App\Models\OptionPriceRuleTier;
use App\Models\Product;
use App\Models\ProductCompleteSummaryCustomRow;
use App\Models\ProductConfirmSummaryCustomRow;
use App\Models\ProductLayout;
use App\Models\ProductOptionGroup;
use App\Models\ProductOptionGroupItem;
use App\Models\ProductOptionStep;
use App\Models\ProductPage;
use App\Models\ProductPdfSummaryCustomRow;
use App\Models\ProductPriceRule;
use App\Models\ProductPriceRuleCondition;
use App\Models\ProductPriceRuleTier;
use App\Models\ProductSideMenuItem;
use App\Services\ProductDuplicator;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductDuplicateTest extends TestCase
{
    private array $models = [
        Product::class, ProductLayout::class, ProductPage::class,
        ProductOptionStep::class, ProductOptionGroup::class, ProductOptionGroupItem::class,
        ProductPriceRule::class, ProductPriceRuleCondition::class, ProductPriceRuleTier::class,
        OptionPriceRule::class, OptionPriceRuleCondition::class, OptionPriceRuleTier::class,
        ProductPdfSummaryCustomRow::class, ProductConfirmSummaryCustomRow::class,
        ProductCompleteSummaryCustomRow::class, Faq::class, ProductSideMenuItem::class,
        HomeProductCard::class,
    ];

    protected function setUp(): void
    {
        parent::setUp();

        // The project's base catalog tables are installed via SQL, not migrations.
        foreach ($this->models as $model) {
            $instance = new $model;
            Schema::create($instance->getTable(), function (Blueprint $table) use ($instance): void {
                $table->id();
                foreach ($instance->getFillable() as $column) {
                    if ($column === 'slug') {
                        $table->string($column)->nullable()->unique();
                    } elseif (str_ends_with($column, '_id')) {
                        $table->unsignedBigInteger($column)->nullable();
                    } else {
                        $table->text($column)->nullable();
                    }
                }
                $table->timestamps();
            });
        }
    }

    private function source(): Product
    {
        $layout = ProductLayout::create([
            'name' => 'Layout', 'slug' => 'layout', 'status' => 'published',
            'draft_layout_json' => ['rows' => [['id' => 'row-1', 'blocks' => [['id' => 'block-1']]]]],
            'published_layout_json' => ['rows' => [['id' => 'row-1']]], 'published_at' => now(),
        ]);
        $product = Product::create([
            'name' => 'Acrylic', 'slug' => 'acrylic/figure', 'product_code' => 'AC01',
            'status' => 'active', 'product_layout_id' => $layout->id,
            'shipping_fee' => 800, 'shipping_free_minimum' => 11000,
            'price_display_type' => 'with_tax', 'meta_description' => 'Description',
            'show_notice' => true, 'notice_text' => 'Notice', 'complete_head_text' => 'Thanks',
        ]);
        ProductPage::create([
            'product_id' => $product->id, 'draft_content_json' => ['blocks' => ['block-1' => ['image' => '/image.webp']]],
            'published_content_json' => ['blocks' => ['block-1' => ['text' => 'Published']]],
            'published_at' => now(),
        ]);

        return $product;
    }

    public function test_duplicate_copies_the_complete_product_graph_and_remaps_owned_ids(): void
    {
        Sanctum::actingAs(new Admin);
        $source = $this->source();
        $step = ProductOptionStep::create(['product_id' => $source->id, 'step_name' => 'Size', 'sort_order' => 3]);
        $group = ProductOptionGroup::create([
            'product_id' => $source->id, 'product_option_step_id' => $step->id,
            'option_group_id' => 21, 'summary_label' => 'Size', 'sort_order' => 5,
        ]);
        ProductOptionGroupItem::create([
            'product_option_group_id' => $group->id, 'product_option_id' => 31,
            'is_default' => true, 'quantity_rule' => 'exact', 'exact_qty' => 2,
        ]);
        foreach ([ProductPriceRule::class, OptionPriceRule::class] as $model) {
            $rule = $model::create(['product_id' => $source->id, 'rule_name' => 'Price', 'tax_rate' => 10]);
            $rule->conditions()->create(['product_option_id' => 31]);
            $priceColumn = $model === ProductPriceRule::class ? 'unit_price' : 'additional_price';
            $rule->tiers()->create(['quantity' => 100, $priceColumn => 200]);
        }
        foreach ([ProductPdfSummaryCustomRow::class, ProductConfirmSummaryCustomRow::class,
            ProductCompleteSummaryCustomRow::class, Faq::class, ProductSideMenuItem::class,
            HomeProductCard::class] as $model) {
            $model::create(['product_id' => $source->id, 'sort_order' => 7]);
        }
        $before = [];
        foreach ($this->models as $model) {
            $before[$model] = $model::first()->getAttributes();
        }

        $response = $this->postJson('/api/v1/admin/products/'.$source->id.'/duplicate')
            ->assertCreated()->assertJsonPath('data.name', 'Acrylic (Copy)')
            ->assertJsonPath('data.slug', 'acrylic/figure-copy')->assertJsonPath('data.status', 'draft');
        $copy = Product::findOrFail($response->json('data.id'));

        $this->assertNotEquals($source->product_layout_id, $copy->product_layout_id);
        $this->assertSame($source->layout->draft_layout_json, $copy->layout->draft_layout_json);
        $this->assertSame($source->layout->published_layout_json, $copy->layout->published_layout_json);
        $this->assertSame($source->page->draft_content_json, $copy->page->draft_content_json);
        $this->assertSame($source->page->published_content_json, $copy->page->published_content_json);
        $this->assertSame($source->shipping_fee, $copy->shipping_fee);
        $this->assertSame($source->notice_text, $copy->notice_text);
        $copyGroup = $copy->optionGroupAssignments()->firstOrFail();
        $this->assertEquals($copy->optionSteps()->firstOrFail()->id, $copyGroup->product_option_step_id);
        $this->assertEquals(31, $copyGroup->items()->firstOrFail()->product_option_id);
        $this->assertEquals(2, $copyGroup->items()->firstOrFail()->exact_qty);
        foreach ([ProductPriceRule::class, OptionPriceRule::class] as $model) {
            $rule = $model::where('product_id', $copy->id)->firstOrFail();
            $this->assertEquals(31, $rule->conditions()->firstOrFail()->product_option_id);
            $this->assertEquals(100, $rule->tiers()->firstOrFail()->quantity);
            $priceColumn = $model === ProductPriceRule::class ? 'unit_price' : 'additional_price';
            $this->assertEquals(200, $rule->tiers()->firstOrFail()->getAttribute($priceColumn));
        }
        foreach ($this->models as $model) {
            $this->assertSame(2, $model::count(), $model);
            $this->assertSame($before[$model], $model::first()->getAttributes(), $model);
        }
        $copy->page->update(['draft_content_json' => ['blocks' => []]]);
        $this->assertNotSame($source->page->fresh()->draft_content_json, $copy->page->fresh()->draft_content_json);

        $this->postJson('/api/v1/admin/products/'.$source->id.'/duplicate')
            ->assertCreated()->assertJsonPath('data.slug', 'acrylic/figure-copy-2');
    }

    public function test_duplicate_supports_products_without_layout_or_optional_settings(): void
    {
        Sanctum::actingAs(new Admin);
        Schema::drop('product_complete_summary_custom_rows');
        $source = Product::create(['name' => 'Simple', 'slug' => 'simple', 'status' => 'draft']);
        $this->postJson('/api/v1/admin/products/'.$source->id.'/duplicate')
            ->assertCreated()->assertJsonPath('data.product_layout_id', null);
    }

    public function test_duplicate_requires_authentication_and_valid_product(): void
    {
        $source = $this->source();
        $this->postJson('/api/v1/admin/products/'.$source->id.'/duplicate')->assertUnauthorized();
        Sanctum::actingAs(new Admin);
        $this->postJson('/api/v1/admin/products/999/duplicate')->assertNotFound();
        $this->assertSame(1, Product::count());
    }

    public function test_failure_rolls_back_the_product_and_layout(): void
    {
        $source = $this->source();
        DB::statement("CREATE TRIGGER reject_page_copy BEFORE INSERT ON product_pages BEGIN SELECT RAISE(ABORT, 'Test failure'); END");
        try {
            app(ProductDuplicator::class)->duplicate($source);
            $this->fail('Expected page insert to fail');
        } catch (\Illuminate\Database\QueryException $exception) {
            $this->assertStringContainsString('Test failure', $exception->getMessage());
        }
        $this->assertSame(1, Product::count());
        $this->assertSame(1, ProductLayout::count());
        $this->assertSame(1, ProductPage::count());
    }
}
