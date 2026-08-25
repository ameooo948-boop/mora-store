<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    public function test_guest_cannot_access_api_products(): void
    {
        $response = $this->getJson('/api/products');

        $response->assertUnauthorized();
    }

    public function test_guest_cannot_access_api_categories(): void
    {
        $response = $this->getJson('/api/categories');

        $response->assertUnauthorized();
    }

    public function test_guest_cannot_access_api_brands(): void
    {
        $response = $this->getJson('/api/brands');

        $response->assertUnauthorized();
    }

    public function test_authenticated_user_can_get_products(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        Product::factory()
            ->withRelations()
            ->create([
                'status' => true,
                'quantity' => 10,
            ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/products');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'products',
                'meta' => [
                    'current_page',
                    'last_page',
                    'total',
                ],
                'categories',
                'brands',
            ]);
    }

    public function test_authenticated_user_can_get_product(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = Product::factory()
            ->withRelations()
            ->create([
                'status' => true,
                'quantity' => 10,
            ]);

        $this->assertTrue((bool) $product->status);

        Sanctum::actingAs($user);

        $response = $this->getJson(
            "/api/products/{$product->slug}"
        );

        $response
            ->assertOk()
            ->assertJsonStructure([
                'product',
                'related_products',
                'average_rating',
                'reviews_count',
                'reviews',
                'user_review',
                'can_review',
            ]);
    }

    public function test_authenticated_user_can_get_categories(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        Category::factory()->create([
            'status' => true,
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/categories');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'categories',
            ]);
    }

    public function test_authenticated_user_can_get_brands(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        Brand::factory()->create([
            'status' => true,
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/brands');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'brands',
            ]);
    }

    public function test_authenticated_user_can_access_cart(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/cart');

        $response->assertOk();
    }

    public function test_authenticated_user_can_access_orders(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/orders');

        $response->assertOk();
    }

    public function test_authenticated_user_can_access_wishlist(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/wishlist');

        $response->assertOk();
    }
}
