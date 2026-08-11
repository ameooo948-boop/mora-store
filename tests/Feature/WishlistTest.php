<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use App\Services\WishlistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_product_to_wishlist(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = Product::factory()
            ->withRelations()
            ->create([
                'price' => 100,
                'sale_price' => null,
                'quantity' => 10,
                'status' => true,
            ]);

        $result = app(WishlistService::class)->toggle(
            $user,
            $product
        );

        $this->assertTrue($result);

        $this->assertDatabaseHas('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->assertTrue(
            app(WishlistService::class)->exists(
                $user,
                $product
            )
        );
    }

    public function test_user_can_remove_product_from_wishlist_using_toggle(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = Product::factory()
            ->withRelations()
            ->create([
                'price' => 100,
                'sale_price' => null,
                'quantity' => 10,
                'status' => true,
            ]);

        $wishlistService = app(WishlistService::class);

        // Add
        $wishlistService->toggle(
            $user,
            $product
        );

        // Remove
        $result = $wishlistService->toggle(
            $user,
            $product
        );

        $this->assertFalse($result);

        $this->assertDatabaseMissing('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $this->assertFalse(
            $wishlistService->exists(
                $user,
                $product
            )
        );
    }

    public function test_wishlist_is_isolated_between_users(): void
    {
        $userA = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $userB = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = Product::factory()
            ->withRelations()
            ->create([
                'price' => 100,
                'sale_price' => null,
                'quantity' => 10,
                'status' => true,
            ]);

        $wishlistService = app(WishlistService::class);

        $wishlistService->toggle(
            $userA,
            $product
        );

        $this->assertTrue(
            $wishlistService->exists(
                $userA,
                $product
            )
        );

        $this->assertFalse(
            $wishlistService->exists(
                $userB,
                $product
            )
        );

        $this->assertDatabaseHas('wishlists', [
            'user_id' => $userA->id,
            'product_id' => $product->id,
        ]);

        $this->assertDatabaseMissing('wishlists', [
            'user_id' => $userB->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_exists_returns_false_when_product_is_not_in_wishlist(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = Product::factory()
            ->withRelations()
            ->create([
                'price' => 100,
                'sale_price' => null,
                'quantity' => 10,
                'status' => true,
            ]);

        $this->assertFalse(
            app(WishlistService::class)->exists(
                $user,
                $product
            )
        );
    }
}
