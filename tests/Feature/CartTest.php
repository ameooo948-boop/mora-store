<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Product;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_product_to_cart(): void
    {
        $user = User::factory()->create();

        $product = Product::factory()
            ->withRelations()
            ->create([
                'quantity' => 10,
            ]);

        $response = $this
            ->actingAs($user)
            ->post(route('cart.store', $product), [
                'quantity' => 2,
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity'   => 2,
        ]);
    }
}
