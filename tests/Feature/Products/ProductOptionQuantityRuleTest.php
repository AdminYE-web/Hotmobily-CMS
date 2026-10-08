<?php

namespace Tests\Feature\Products;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProductOptionQuantityRuleTest extends TestCase
{
    private int $productId;

    private int $optionId;

    private string $productSlug = 'quantity-rule-test';

    protected function setUp(): void
    {
        parent::setUp();

        foreach ($this->testTables() as $table) {
            Schema::dropIfExists($table);
        }

        Schema::create('products', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('status');
        });

        Schema::create('product_option_steps', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('step_name');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_summary_step')->default(false);
        });

        Schema::create('option_groups', function (Blueprint $table): void {
            $table->id();
            $table->string('group_code');
            $table->string('group_name');
            $table->string('display_type')->default('radio_list');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_required')->default(false);
        });

        Schema::create('product_option_groups', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('option_group_id');
            $table->unsignedBigInteger('product_option_step_id')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('has_option_configuration')->default(true);
        });

        Schema::create('product_options', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('option_group_id');
            $table->string('option_code');
            $table->string('option_name');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_disabled')->default(false);
        });

        Schema::create('product_option_group_items', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('product_option_group_id');
            $table->unsignedBigInteger('product_option_id');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('quantity_rule')->default('no_limit');
            $table->unsignedInteger('min_qty')->nullable();
            $table->unsignedInteger('max_qty')->nullable();
            $table->unsignedInteger('exact_qty')->nullable();
        });

        $this->productId = DB::table('products')->insertGetId([
            'name' => 'Quantity Rule Product',
            'slug' => $this->productSlug,
            'status' => 'active',
        ]);

        $optionGroupId = DB::table('option_groups')->insertGetId([
            'group_code' => 'TYPE',
            'group_name' => 'Product Type',
            'display_type' => 'radio_list',
            'is_active' => true,
            'is_required' => true,
        ]);

        $assignmentId = DB::table('product_option_groups')->insertGetId([
            'product_id' => $this->productId,
            'option_group_id' => $optionGroupId,
            'product_option_step_id' => null,
            'sort_order' => 1,
            'has_option_configuration' => true,
        ]);

        $this->optionId = DB::table('product_options')->insertGetId([
            'option_group_id' => $optionGroupId,
            'option_code' => 'STANDARD',
            'option_name' => 'Standard',
            'is_active' => true,
            'is_disabled' => false,
        ]);

        DB::table('product_option_group_items')->insert([
            'product_option_group_id' => $assignmentId,
            'product_option_id' => $this->optionId,
            'sort_order' => 1,
            'is_default' => true,
            'is_active' => true,
            'quantity_rule' => 'min_max_range',
            'min_qty' => 100,
            'max_qty' => 300,
        ]);
    }

    protected function tearDown(): void
    {
        foreach ($this->testTables() as $table) {
            Schema::dropIfExists($table);
        }

        parent::tearDown();
    }

    public function test_rejects_quantity_above_the_selected_options_maximum(): void
    {
        $this->from('/products/'.$this->productSlug)
            ->post(route('products.customer.store', ['productPath' => $this->productSlug]), [
                'quantity' => 500,
                'selected_option_ids' => [$this->optionId],
            ])
            ->assertSessionHasErrors(['quantity']);

        $this->assertFalse(session()->has('configured_order_'.$this->productId));
    }

    public function test_accepts_quantity_inside_the_selected_options_range(): void
    {
        $this->post(route('products.customer.store', ['productPath' => $this->productSlug]), [
            'quantity' => 250,
            'selected_option_ids' => [$this->optionId],
        ])->assertRedirect(route('products.customer', ['productPath' => $this->productSlug]));

        $this->assertSame(
            250,
            session()->get('configured_order_'.$this->productId.'.quantity')
        );
    }

    public function test_rejects_out_of_range_quantity_for_estimate_pdf_too(): void
    {
        $this->from('/products/'.$this->productSlug)
            ->post(route('products.estimate.pdf', ['productPath' => $this->productSlug]), [
                'quantity' => 500,
                'selected_option_ids' => [$this->optionId],
            ])
            ->assertSessionHasErrors(['quantity']);
    }

    public function test_exact_quantity_option_accepts_only_its_configured_quantity(): void
    {
        DB::table('product_option_group_items')
            ->where('product_option_id', $this->optionId)
            ->update([
                'quantity_rule' => 'exact_quantity_only',
                'min_qty' => null,
                'max_qty' => null,
                'exact_qty' => 10,
            ]);

        $this->post(route('products.customer.store', ['productPath' => $this->productSlug]), [
            'quantity' => 10,
            'selected_option_ids' => [$this->optionId],
        ])->assertRedirect(route('products.customer', ['productPath' => $this->productSlug]));

        $this->assertSame(10, session()->get('configured_order_'.$this->productId.'.quantity'));

        $this->from('/products/'.$this->productSlug)
            ->post(route('products.customer.store', ['productPath' => $this->productSlug]), [
                'quantity' => 11,
                'selected_option_ids' => [$this->optionId],
            ])
            ->assertSessionHasErrors(['quantity']);
    }

    /** @return list<string> */
    private function testTables(): array
    {
        return [
            'product_option_group_items',
            'product_options',
            'product_option_groups',
            'option_groups',
            'product_option_steps',
            'products',
        ];
    }
}
