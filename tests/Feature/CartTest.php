<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_product_to_cart(): void
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

        app(CartService::class)->add(
            $user->id,
            $product,
            2
        );

        $this->assertDatabaseHas('carts', [
            'user_id' => $user->id,
        ]);

        $cart = Cart::where('user_id', $user->id)->first();

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    public function test_adding_same_product_increases_quantity(): void
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

        $cartService = app(CartService::class);

        $cartService->add(
            $user->id,
            $product,
            2
        );

        $cartService->add(
            $user->id,
            $product,
            3
        );

        $cart = Cart::where('user_id', $user->id)->first();

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 5,
        ]);

        $this->assertSame(
            1,
            CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->count()
        );
    }

    public function test_user_cannot_add_more_than_available_stock(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = Product::factory()
            ->withRelations()
            ->create([
                'price' => 100,
                'sale_price' => null,
                'quantity' => 5,
                'status' => true,
            ]);

        $this->expectException(\Exception::class);

        $this->expectExceptionMessage(
            'You can only add 5 more item(s).'
        );

        app(CartService::class)->add(
            $user->id,
            $product,
            6
        );
    }

    public function test_user_can_update_cart_item_quantity(): void
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

        $cartService = app(CartService::class);

        $cartService->add(
            $user->id,
            $product,
            2
        );

        $result = $cartService->updateQuantity(
            $user->id,
            $product,
            7
        );

        $this->assertTrue($result);

        $cart = Cart::where('user_id', $user->id)->first();

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 7,
        ]);
    }

    public function test_user_cannot_update_cart_quantity_above_stock(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = Product::factory()
            ->withRelations()
            ->create([
                'price' => 100,
                'sale_price' => null,
                'quantity' => 5,
                'status' => true,
            ]);

        $cartService = app(CartService::class);

        $cartService->add(
            $user->id,
            $product,
            2
        );

        $this->expectException(\Exception::class);

        $this->expectExceptionMessage(
            'Only 5 item(s) available.'
        );

        $cartService->updateQuantity(
            $user->id,
            $product,
            6
        );
    }

    public function test_user_can_remove_product_from_cart(): void
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

        $cartService = app(CartService::class);

        $cartService->add(
            $user->id,
            $product,
            2
        );

        $result = $cartService->remove(
            $user->id,
            $product
        );

        $this->assertTrue($result);

        $cart = Cart::where('user_id', $user->id)->first();

        $this->assertDatabaseMissing('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_user_can_clear_cart(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product1 = Product::factory()
            ->withRelations()
            ->create([
                'price' => 100,
                'sale_price' => null,
                'quantity' => 10,
                'status' => true,
            ]);

        $product2 = Product::factory()
            ->withRelations()
            ->create([
                'price' => 200,
                'sale_price' => null,
                'quantity' => 10,
                'status' => true,
            ]);

        $cartService = app(CartService::class);

        $cartService->add($user->id, $product1, 2);
        $cartService->add($user->id, $product2, 3);

        $result = $cartService->clear($user->id);

        $this->assertTrue($result);

        $cart = Cart::where('user_id', $user->id)->first();

        $this->assertDatabaseMissing('cart_items', [
            'cart_id' => $cart->id,
        ]);
    }
}
