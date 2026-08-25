<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
        ]);

        $adminRole->givePermissionTo(
            Permission::firstOrCreate([
                'name' => 'view payments',
            ])
        );

        Role::firstOrCreate([
            'name' => 'customer',
        ]);

    }

    private function admin(): User
    {
        $admin = User::factory()->create();

        $admin->assignRole('admin');

        return $admin;
    }

    private function user(): User
    {
        return User::factory()->create();
    }

    public function test_guest_cannot_access_admin_products(): void
    {
        $this->getJson('/api/admin/products')
            ->assertUnauthorized();
    }

    public function test_normal_user_cannot_access_admin_products(): void
    {
        Sanctum::actingAs($this->user());

        $this->getJson('/api/admin/products')
            ->assertForbidden();
    }

    public function test_admin_can_access_admin_products(): void
    {
        Sanctum::actingAs($this->admin());

        $this->getJson('/api/admin/products')
            ->assertOk();
    }

    public function test_admin_can_access_admin_categories(): void
    {
        Sanctum::actingAs($this->admin());

        $this->getJson('/api/admin/categories')
            ->assertOk();
    }

    public function test_admin_can_access_admin_brands(): void
    {
        Sanctum::actingAs($this->admin());

        $this->getJson('/api/admin/brands')
            ->assertOk();
    }

    public function test_admin_can_access_admin_reviews(): void
    {
        Sanctum::actingAs($this->admin());

        $this->getJson('/api/admin/reviews')
            ->assertOk();
    }

    public function test_admin_can_access_admin_orders(): void
    {
        Sanctum::actingAs($this->admin());

        $this->getJson('/api/admin/orders')
            ->assertOk();
    }

    public function test_admin_can_access_admin_payments(): void
    {
        Sanctum::actingAs($this->admin());

        $this->getJson('/api/admin/payments')
            ->assertOk();
    }

    public function test_admin_can_access_admin_stock_movements(): void
    {
        Sanctum::actingAs($this->admin());

        $this->getJson('/api/admin/stock-movements')
            ->assertOk();
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        Sanctum::actingAs($this->admin());

        $this->getJson('/api/admin/dashboard')
            ->assertOk();
    }

    public function test_admin_can_access_admin_settings(): void
    {
        Sanctum::actingAs($this->admin());

        $this->getJson('/api/admin/settings')
            ->assertOk();
    }
}
