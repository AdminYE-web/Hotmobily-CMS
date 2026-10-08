<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\ProductOption;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ProductOptionDeletionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('product_options', function (Blueprint $table): void {
            $table->id();
            $table->string('option_code');
            $table->text('option_images')->nullable();
            $table->timestamps();
        });
    }

    public function test_admin_can_delete_an_unused_option(): void
    {
        $option = ProductOption::create(['option_code' => 'UNUSED', 'option_images' => []]);

        $this->actingAs(new Admin(['email' => 'admin@example.test']), 'admin')
            ->delete(route('admin.product-options.destroy', $option))
            ->assertRedirect(route('admin.product-options.index'))
            ->assertSessionHas('status');

        $this->assertDatabaseMissing('product_options', ['id' => $option->id]);
    }

    #[DataProvider('references')]
    public function test_referenced_options_cannot_be_deleted(string $tableName, string $column): void
    {
        Schema::create($tableName, function (Blueprint $table) use ($column): void {
            $table->id();
            $table->unsignedBigInteger($column);
        });

        $option = ProductOption::create(['option_code' => 'USED']);
        DB::table($tableName)->insert([$column => $option->id]);

        $this->actingAs(new Admin(['email' => 'admin@example.test']), 'admin')
            ->delete(route('admin.product-options.destroy', $option))
            ->assertRedirect(route('admin.product-options.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('product_options', ['id' => $option->id]);
        $this->assertDatabaseHas($tableName, [$column => $option->id]);
    }

    public static function references(): array
    {
        return [
            ['product_option_group_items', 'product_option_id'],
            ['option_dependencies', 'trigger_product_option_id'],
            ['option_dependencies', 'target_product_option_id'],
            ['option_price_rules', 'target_product_option_id'],
            ['option_price_rule_conditions', 'product_option_id'],
            ['product_price_rule_conditions', 'product_option_id'],
            ['product_option_groups', 'price_summary_option_id'],
            ['product_option_groups', 'confirm_price_summary_option_id'],
            ['product_option_groups', 'complete_price_summary_option_id'],
            ['product_option_group_items', 'price_summary_option_id'],
            ['product_option_group_items', 'confirm_price_summary_option_id'],
            ['product_option_group_items', 'complete_price_summary_option_id'],
        ];
    }

    public function test_guests_cannot_delete_options(): void
    {
        $option = ProductOption::create(['option_code' => 'PRIVATE']);

        $this->delete(route('admin.product-options.destroy', $option))->assertRedirect();

        $this->assertDatabaseHas('product_options', ['id' => $option->id]);
    }
}
