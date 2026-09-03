<?php

namespace Tests\Feature\Admin;

use App\Models\Admin;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('admin', function (Blueprint $table): void {
            $table->string('user', 50)->primary();
            $table->string('pass', 255);
            $table->string('dept', 50)->nullable();
            $table->text('lang')->nullable();
            $table->string('staff_name', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('token', 100)->nullable();
            $table->dateTime('token_expire')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->smallInteger('super_admin')->nullable();
        });
    }

    public function test_login_page_is_available_to_guests(): void
    {
        $this->get('/admin/login')
            ->assertOk()
            ->assertSee('管理画面ログイン')
            ->assertSee('name="user"', false)
            ->assertSee('name="password"', false);
    }

    public function test_dashboard_redirects_guests_to_admin_login(): void
    {
        $this->get('/admin')
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_login_with_current_legacy_password(): void
    {
        $admin = Admin::query()->create([
            'user' => 'admin-test',
            'pass' => 'legacy-password',
            'dept' => 'Web',
            'staff_name' => 'Test Admin',
            'email' => 'admin@example.test',
            'super_admin' => 1,
        ]);

        $this->post('/admin/login', [
            'user' => 'admin-test',
            'password' => 'legacy-password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin, 'admin');

        $this->get('/admin')
            ->assertOk()
            ->assertSee('ダッシュボード')
            ->assertSee('Test Admin')
            ->assertSee('SUPER ADMIN');
    }

    public function test_invalid_password_is_rejected(): void
    {
        Admin::query()->create([
            'user' => 'admin-test',
            'pass' => 'correct-password',
        ]);

        $this->from('/admin/login')->post('/admin/login', [
            'user' => 'admin-test',
            'password' => 'wrong-password',
        ])
            ->assertRedirect('/admin/login')
            ->assertSessionHasErrors('user');

        $this->assertGuest('admin');
    }

    public function test_admin_can_logout(): void
    {
        $admin = Admin::query()->create([
            'user' => 'admin-test',
            'pass' => 'legacy-password',
        ]);

        $this->actingAs($admin, 'admin')
            ->post('/admin/logout')
            ->assertRedirect(route('admin.login'));

        $this->assertGuest('admin');
    }
}
