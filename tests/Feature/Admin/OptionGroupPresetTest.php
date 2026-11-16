<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class OptionGroupPresetTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('option_groups', function (Blueprint $table): void {
            $table->id(); $table->string('display_type');
        });
        Schema::create('product_options', function (Blueprint $table): void {
            $table->id(); $table->unsignedBigInteger('option_group_id');
        });
        DB::table('option_groups')->insert([['id' => 1, 'display_type' => 'radio_list'], ['id' => 2, 'display_type' => 'quantity_input']]);
        DB::table('product_options')->insert([['id' => 1, 'option_group_id' => 1], ['id' => 2, 'option_group_id' => 1], ['id' => 3, 'option_group_id' => 2]]);
        (require database_path('migrations/2026_11_10_000300_create_option_group_presets_table.php'))->up();
    }

    private function content(): array
    {
        return ['options' => [
            ['id' => 2, 'is_selected' => true, 'is_default' => true, 'is_active' => true, 'quantity_rule' => 'min_max_range', 'min_qty' => 10, 'max_qty' => 100],
            ['id' => 1, 'is_selected' => false, 'is_default' => false, 'is_active' => false, 'quantity_rule' => 'no_limit'],
        ]];
    }

    public function test_presets_preserve_order_selection_and_rules_and_support_crud(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $url = '/api/v1/admin/option-group-presets';
        $response = $this->postJson($url, ['name' => 'Standard', 'option_group_id' => 1, 'content' => $this->content()])->assertCreated();
        $id = $response->json('data.id');
        $response->assertJsonPath('data.content_json.options.0.id', 2)->assertJsonPath('data.content_json.options.0.is_default', true)
            ->assertJsonPath('data.content_json.options.0.min_qty', 10)->assertJsonPath('data.content_json.options.1.is_selected', false)->assertJsonPath('data.content_json.options.1.is_active', false);
        $this->getJson($url)->assertOk()->assertJsonCount(1, 'data')->assertJsonMissingPath('data.0.content_json');
        $copy = $this->getJson($url.'/'.$id)->assertOk()->json('data.content_json');
        $content = $this->content(); $content['options'] = array_reverse($content['options']);
        $this->putJson($url.'/'.$id, ['name' => 'Updated', 'option_group_id' => 1, 'content' => $content])->assertOk()->assertJsonPath('data.content_json.options.0.id', 1);
        $this->deleteJson($url.'/'.$id)->assertOk();
        $this->getJson($url.'/'.$id)->assertNotFound();
        $this->assertSame(2, $copy['options'][0]['id']);
    }

    public function test_group_scoping_quantity_limits_and_validation(): void
    {
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
        $url = '/api/v1/admin/option-group-presets';
        $response = $this->postJson($url, ['name' => 'Set', 'option_group_id' => 1, 'content' => $this->content()])->assertCreated();
        $this->postJson($url, ['name' => 'Set', 'option_group_id' => 1, 'content' => $this->content()])->assertUnprocessable()->assertJsonValidationErrors('name');
        $quantity = ['quantity_min' => 20, 'quantity_max' => 500, 'options' => []];
        $this->postJson($url, ['name' => 'Set', 'option_group_id' => 2, 'content' => $quantity])->assertCreated()->assertJsonPath('data.content_json.quantity_min', 20)->assertJsonPath('data.content_json.quantity_max', 500);
        $quantity['quantity_max'] = 10;
        $this->postJson($url, ['name' => 'Invalid', 'option_group_id' => 2, 'content' => $quantity])->assertUnprocessable()->assertJsonValidationErrors('content.quantity_max');
        $this->postJson($url, ['name' => 'Wrong group', 'option_group_id' => 2, 'content' => $this->content()])->assertUnprocessable()->assertJsonValidationErrors('content.options.0.id');
        $this->putJson($url.'/'.$response->json('data.id'), ['name' => 'Move', 'option_group_id' => 2, 'content' => ['options' => []]])->assertUnprocessable()->assertJsonValidationErrors('option_group_id');
        $content = $this->content(); $content['options'][0]['max_qty'] = 1;
        $this->postJson($url, ['name' => 'Inverted', 'option_group_id' => 1, 'content' => $content])->assertUnprocessable()->assertJsonValidationErrors('content.options.0.max_qty');
    }

    public function test_admin_authentication_is_required(): void
    {
        $url = '/api/v1/admin/option-group-presets';
        $this->getJson($url)->assertUnauthorized();
        $this->postJson($url, [])->assertUnauthorized();
        $this->putJson($url.'/1', [])->assertUnauthorized();
        $this->deleteJson($url.'/1')->assertUnauthorized();
    }
}
