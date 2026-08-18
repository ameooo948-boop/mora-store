<?php

namespace Tests\Feature;

use App\Enums\CouponType;
use App\Enums\PaymentMethod;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_checkout(): void
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

        $cart = $user->cart()->create();

        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        Address::create([
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

        $response = $this->actingAs($user)
            ->get(route('checkout.index'));

        $response->assertOk();

        $response->assertViewIs('web.checkout.index');

        $response->assertViewHas('cart');
        $response->assertViewHas('totals');
        $response->assertViewHas('addresses');
        $response->assertViewHas('paymentMethods');
    }

    public function test_guest_cannot_view_checkout(): void
    {
        $response = $this->get(route('checkout.index'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_can_apply_valid_coupon(): void
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

        $cart = $user->cart()->create();

        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $coupon = Coupon::create([
            'code' => 'TEST10',
            'type' => CouponType::FIXED,
            'value' => 10,
            'minimum_amount' => 0,
            'maximum_discount' => null,
            'usage_limit' => 100,
            'used_count' => 0,
            'starts_at' => now()->subDay(),
            'expires_at' => now()->addDay(),
            'status' => true,
        ]);

        $response = $this->actingAs($user)
            ->post(route('checkout.coupon.store'), [
                'coupon_code' => $coupon->code,
            ]);

        $response->assertRedirect();

        $response->assertSessionHas(
            'coupon_success',
            'Coupon applied successfully.'
        );

        $this->assertSame(
            $coupon->id,
            session('coupon.id')
        );

        $this->assertSame(
            $coupon->code,
            session('coupon.code')
        );
    }

    public function test_user_cannot_apply_invalid_coupon(): void
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

        $cart = $user->cart()->create();

        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($user)
            ->post(route('checkout.coupon.store'), [
                'coupon_code' => 'INVALID-CODE',
            ]);

        $response->assertSessionHasErrors([
            'coupon' => 'Coupon not found.',
        ]);

        $this->assertNull(session('coupon'));
    }

    public function test_user_can_remove_coupon(): void
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

        $cart = $user->cart()->create();

        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $coupon = Coupon::create([
            'code' => 'TEST10',
            'type' => CouponType::FIXED,
            'value' => 10,
            'minimum_amount' => 0,
            'maximum_discount' => null,
            'usage_limit' => 100,
            'used_count' => 0,
            'starts_at' => now()->subDay(),
            'expires_at' => now()->addDay(),
            'status' => true,
        ]);

        $this->actingAs($user)
            ->post(route('checkout.coupon.store'), [
                'coupon_code' => $coupon->code,
            ])
            ->assertRedirect();

        $this->assertNotNull(session('coupon'));

        $response = $this->actingAs($user)
            ->delete(route('checkout.coupon.destroy'));

        $response->assertRedirect();

        $response->assertSessionHas(
            'success',
            'Coupon removed successfully.'
        );

        $this->assertNull(session('coupon'));
    }

    public function test_user_can_place_order_from_checkout_with_cash_on_delivery(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $this->seed();

        $this->seed(RolesAndPermissionsSeeder::class);

        $product = Product::factory()
            ->withRelations()
            ->create([
                'price' => 100,
                'sale_price' => null,
                'quantity' => 10,
                'status' => true,
            ]);

        $cart = $user->cart()->create();

        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 2,
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


        $response = $this->actingAs($user)
            ->post(route('checkout.store'), [
                'address_id' => $address->id,
                'payment_method' => PaymentMethod::CashOnDelivery->value,
            ]);

        $response->assertRedirect();


        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total' => 200,
        ]);

        $this->assertDatabaseHas('payments', [
            'status' => 'pending',
        ]);

        $this->assertDatabaseCount('cart_items', 0);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'quantity' => 8,
        ]);
    }
    public function test_cart_can_be_cleared(): void
    {
        $user = User::factory()->create();

        $product = Product::factory()
            ->withRelations()
            ->create([
                'quantity' => 10,
                'status' => true,
            ]);

        $cart = $user->cart()->create();

        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
        ]);

        app(\App\Services\CartService::class)
            ->clear($user->id);

        $this->assertDatabaseMissing('cart_items', [
            'cart_id' => $cart->id,
        ]);
    }

    public function test_product_stock_can_be_decreased(): void
    {
        $product = Product::factory()
            ->withRelations()
            ->create([
                'quantity' => 10,
                'status' => true,
            ]);

        app(\App\Services\ProductService::class)
            ->decreaseStock($product, 2);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'quantity' => 8,
        ]);
    }
}
