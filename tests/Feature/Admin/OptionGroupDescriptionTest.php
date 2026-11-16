<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use App\Models\OptionGroup;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class OptionGroupDescriptionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Schema::create('option_groups', function (Blueprint $table): void {
            $table->id();
            $table->string('group_code')->unique();
            $table->string('group_name');
            $table->string('display_type');
            $table->text('help_text')->nullable();
            $table->text('remark_text')->nullable();
            foreach (['is_main_price_group', 'is_required', 'show_in_order_summary', 'is_active'] as $flag) $table->boolean($flag)->default(false);
            $table->timestamps();
        });
        (require database_path('migrations/2026_11_10_000100_add_description_to_option_groups_table.php'))->up();
        $this->actingAs(new Admin(['email' => 'qa@example.test']), 'admin');
    }

    public function test_description_saves_safe_rich_text_and_can_be_updated_or_cleared(): void
    {
        $data = ['group_code' => 'qa', 'group_name' => 'QA Group', 'display_type' => 'button', 'description' => '<p><strong>Details</strong> <a href="https://example.com/guide">Guide</a> <a href="#option-group-help">More details</a></p><script>alert(1)</script>'];
        $this->post(route('admin.option-groups.store'), $data)->assertRedirect(route('admin.option-groups.index'));
        $group = OptionGroup::firstOrFail();
        $this->assertStringContainsString('<strong>Details</strong>', $group->description);
        $this->assertStringContainsString('href="https://example.com/guide"', $group->description);
        $this->assertStringContainsString('href="#option-group-help">More details</a>', $group->description);
        $this->assertStringNotContainsString('<script', $group->description);
        $this->get(route('admin.option-groups.edit', $group))->assertOk()->assertSee('name="description"', false)->assertSee('&lt;strong&gt;Details&lt;/strong&gt;', false);
        $data['description'] = '<p>Updated description</p>';
        $this->put(route('admin.option-groups.update', $group), $data)->assertRedirect();
        $this->assertSame('<p>Updated description</p>', $group->fresh()->description);
        $data['description'] = '';
        $this->put(route('admin.option-groups.update', $group), $data)->assertRedirect();
        $this->assertNull($group->fresh()->description);
    }

    public function test_invalid_form_retains_description_for_correction(): void
    {
        $this->from(route('admin.option-groups.create'))->post(route('admin.option-groups.store'), [
            'group_code' => 'qa', 'display_type' => 'button', 'description' => '<p>Keep my draft</p>',
        ])->assertSessionHasErrors('group_name')->assertSessionHasInput('description', '<p>Keep my draft</p>');
        $this->assertSame(0, OptionGroup::count());
    }
}
