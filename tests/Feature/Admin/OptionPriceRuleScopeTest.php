<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\OptionPriceRule;
use App\Models\Product;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class OptionPriceRuleScopeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('products', function (Blueprint $table): void {
            $table->id(); $table->string('name'); $table->string('slug');
        });
        Schema::create('option_groups', function (Blueprint $table): void {
            $table->id(); $table->string('group_code'); $table->string('group_name'); $table->boolean('is_active')->default(true);
        });
        Schema::create('product_options', function (Blueprint $table): void {
            $table->id(); $table->unsignedBigInteger('option_group_id'); $table->string('option_code'); $table->string('option_name'); $table->boolean('is_active')->default(true);
        });
        Schema::create('product_option_groups', function (Blueprint $table): void {
            $table->id(); $table->unsignedBigInteger('product_id'); $table->unsignedBigInteger('option_group_id');
            $table->integer('sort_order')->default(0); $table->boolean('has_option_configuration')->default(false);
        });
        Schema::create('product_option_group_items', function (Blueprint $table): void {
            $table->id(); $table->unsignedBigInteger('product_option_group_id'); $table->unsignedBigInteger('product_option_id'); $table->integer('sort_order')->default(0);
        });
        Schema::create('option_price_rules', function (Blueprint $table): void {
            $table->id(); $table->unsignedBigInteger('product_id'); $table->string('rule_name'); $table->string('price_type');
            $table->unsignedBigInteger('target_product_option_id'); $table->decimal('tax_rate', 5, 2); $table->timestamps();
        });
        Schema::create('option_price_rule_conditions', function (Blueprint $table): void {
            $table->id(); $table->unsignedBigInteger('option_price_rule_id'); $table->unsignedBigInteger('product_option_id'); $table->timestamps();
        });
        Schema::create('option_price_rule_tiers', function (Blueprint $table): void {
            $table->id(); $table->unsignedBigInteger('option_price_rule_id'); $table->integer('quantity'); $table->decimal('additional_price', 12, 2); $table->decimal('additional_price_with_tax', 12, 2); $table->timestamps();
        });
        (require database_path('migrations/2026_11_11_000000_allow_global_option_price_rules.php'))->up();
        DB::table('products')->insert([['id' => 1, 'name' => 'A', 'slug' => 'a'], ['id' => 2, 'name' => 'B', 'slug' => 'b']]);
        DB::table('option_groups')->insert([['id' => 1, 'group_code' => 'shared', 'group_name' => 'Shared', 'is_active' => true], ['id' => 2, 'group_code' => 'future', 'group_name' => 'Future', 'is_active' => true], ['id' => 3, 'group_code' => 'inactive', 'group_name' => 'Inactive', 'is_active' => false]]);
        foreach ([10 => 1, 20 => 1, 30 => 2, 40 => 3] as $id => $group) DB::table('product_options')->insert(['id' => $id, 'option_group_id' => $group, 'option_code' => 'option'.$id, 'option_name' => 'Option '.$id, 'is_active' => true]);
        DB::table('product_option_groups')->insert([['product_id' => 1, 'option_group_id' => 1], ['product_id' => 2, 'option_group_id' => 1]]);
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
    }

    private function payload(): array
    {
        return ['rule_name' => 'Shared price', 'applies_to_all_products' => 1, 'price_type' => 'per_order', 'target_product_option_id' => 10, 'condition_product_option_ids' => [20], 'tax_rate' => 10, 'tiers' => [['quantity' => 1, 'additional_price' => 273.63, 'additional_price_with_tax' => 300.99]]];
    }

    public function test_global_rule_saves_without_product_and_can_change_scope(): void
    {
        $data = $this->payload();
        $this->post(route('admin.option-price-rules.store'), $data)->assertSessionHasNoErrors()->assertRedirect();
        $rule = OptionPriceRule::firstOrFail();
        $this->assertNull($rule->product_id);
        $this->assertSame([20], $rule->conditions->pluck('product_option_id')->all());
        $this->assertSame('300.00', $rule->tiers->first()->additional_price_with_tax);
        $this->get(route('admin.option-price-rules.edit', $rule))->assertOk()->assertSee('All products');
        $data['applies_to_all_products'] = 0; $data['product_id'] = 1;
        $this->put(route('admin.option-price-rules.update', $rule), $data)->assertSessionHasNoErrors()->assertRedirect();
        $this->assertSame(1, $rule->fresh()->product_id);
        $data['applies_to_all_products'] = 1;
        $this->put(route('admin.option-price-rules.update', $rule), $data)->assertSessionHasNoErrors()->assertRedirect();
        $this->assertNull($rule->fresh()->product_id);
        $this->get(route('admin.option-price-rules.index'))->assertOk()->assertSee('All products');
    }

    public function test_global_rules_validate_active_options_while_specific_rules_require_assignments(): void
    {
        $data = $this->payload(); $data['target_product_option_id'] = 30;
        $this->post(route('admin.option-price-rules.store'), $data)->assertSessionHasNoErrors()->assertRedirect();
        $data['applies_to_all_products'] = 0; $data['product_id'] = 1;
        $this->post(route('admin.option-price-rules.store'), $data)->assertSessionHasErrors('target_product_option_id');
        unset($data['product_id']);
        $this->post(route('admin.option-price-rules.store'), $data)->assertSessionHasErrors('product_id');
        $data['applies_to_all_products'] = 1; $data['target_product_option_id'] = 40;
        $this->post(route('admin.option-price-rules.store'), $data)->assertSessionHasErrors('target_product_option_id');
        $this->assertSame(1, OptionPriceRule::count());
    }

    public function test_storefront_exposes_global_rules_for_both_products_and_specific_rules_only_for_their_product(): void
    {
        $data = $this->payload();
        $this->post(route('admin.option-price-rules.store'), $data)->assertSessionHasNoErrors();
        $data['applies_to_all_products'] = 0; $data['product_id'] = 1;
        $this->post(route('admin.option-price-rules.store'), $data)->assertSessionHasNoErrors();
        $controller = app(\App\Http\Controllers\Storefront\ProductController::class);
        $method = new \ReflectionMethod($controller, 'storefrontOrderPricing');
        $first = $method->invoke($controller, Product::findOrFail(1))['option_rules'];
        $second = $method->invoke($controller, Product::findOrFail(2))['option_rules'];
        $this->assertCount(2, $first); $this->assertCount(1, $second);
        $this->assertTrue($first[0]['is_global']); $this->assertFalse($first[1]['is_global']);
        $this->assertTrue($second[0]['is_global']);
        $this->assertSame([20], $second[0]['conditions']);
    }
}
