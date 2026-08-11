<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\Services\OrderService;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);
    }

    public function test_user_can_place_order_with_cash_on_delivery(): void
    {
        Notification::fake();

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

        $address = Address::create([
            'user_id' => $user->id,
            'full_name' => 'Test User',
            'phone' => '01012345678',
            'country' => 'Egypt',
            'state' => 'Dakahlia',
            'city' => 'Mansoura',
            'address_line' => 'Test Address',
            'postal_code' => '35511',
            'is_default' => true,
        ]);

        /*
         * Create cart
         */
        $cart = Cart::create([
            'user_id' => $user->id,
        ]);

        /*
         * Create cart item
         *
         * cart_items does not contain a price column.
         */
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        /*
         * Place order
         */
        $orderService = app(OrderService::class);

        $order = $orderService->placeOrder(
            $user,
            $address->id,
            PaymentMethod::CashOnDelivery,
        );

        /*
         * Order
         */
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'user_id' => $user->id,
            'status' => OrderStatus::Pending->value,
            'subtotal' => 200,
            'shipping' => 0,
            'discount' => 0,
            'total' => 200,
        ]);

        /*
         * Order item
         */
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 100,
            'total' => 200,
        ]);

        /*
         * Payment
         */
        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
            'amount' => 200,
            'payment_method' => PaymentMethod::CashOnDelivery->value,
            'status' => PaymentStatus::Pending->value,
        ]);

        /*
         * Stock
         */
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'quantity' => 8,
        ]);

        /*
         * Cart should be empty
         */
        $this->assertDatabaseMissing('cart_items', [
            'cart_id' => $cart->id,
        ]);
    }

    public function test_user_cannot_place_order_when_stock_is_insufficient(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = Product::factory()
            ->withRelations()
            ->create([
                'price' => 100,
                'sale_price' => null,
                'quantity' => 2,
                'status' => true,
            ]);

        $address = Address::create([
            'user_id' => $user->id,
            'full_name' => 'Test User',
            'phone' => '01012345678',
            'country' => 'Egypt',
            'state' => 'Dakahlia',
            'city' => 'Mansoura',
            'address_line' => 'Test Address',
            'postal_code' => '35511',
            'is_default' => true,
        ]);

        $cart = Cart::create([
            'user_id' => $user->id,
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Not enough stock for');

        app(OrderService::class)->placeOrder(
            $user,
            $address->id,
            PaymentMethod::CashOnDelivery,
        );

        $this->assertDatabaseMissing('orders', [
            'user_id' => $user->id,
        ]);
    }

    public function test_user_cannot_place_order_using_another_users_address(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $anotherUser = User::factory()->create([
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

        $address = Address::create([
            'user_id' => $anotherUser->id,
            'full_name' => 'Another User',
            'phone' => '01012345678',
            'country' => 'Egypt',
            'state' => 'Dakahlia',
            'city' => 'Mansoura',
            'address_line' => 'Another User Address',
            'postal_code' => '35511',
            'is_default' => true,
        ]);

        $cart = Cart::create([
            'user_id' => $user->id,
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $this->expectException(\Exception::class);

        app(OrderService::class)->placeOrder(
            $user,
            $address->id,
            PaymentMethod::CashOnDelivery,
        );
    }

    public function test_order_failure_does_not_modify_cart_or_stock(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $product = Product::factory()
            ->withRelations()
            ->create([
                'price' => 100,
                'sale_price' => null,
                'quantity' => 2,
                'status' => true,
            ]);

        $address = Address::create([
            'user_id' => $user->id,
            'full_name' => 'Test User',
            'phone' => '01012345678',
            'country' => 'Egypt',
            'state' => 'Dakahlia',
            'city' => 'Mansoura',
            'address_line' => 'Test Address',
            'postal_code' => '35511',
            'is_default' => true,
        ]);

        $cart = Cart::create([
            'user_id' => $user->id,
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        try {
            app(OrderService::class)->placeOrder(
                $user,
                $address->id,
                PaymentMethod::CashOnDelivery,
            );

            $this->fail('Expected order placement to fail.');
        } catch (\Exception $e) {
            $this->assertStringContainsString(
                'Not enough stock for',
                $e->getMessage()
            );
        }

        $this->assertDatabaseMissing('orders', [
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'quantity' => 2,
        ]);

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);
    }
}
