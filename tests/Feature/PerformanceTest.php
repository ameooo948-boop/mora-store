<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PerformanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_listing_query_count(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        Role::findOrCreate('user', 'web');

        $user->assignRole('user');

        Product::factory()
            ->count(12)
            ->withRelations()
            ->sequence(
                fn ($sequence) => [
                    'slug' => 'performance-product-'.$sequence->index,
                    'sku' => 'PERF-SKU-'.$sequence->index,
                ]
            )
            ->create([
                'status' => true,
            ]);

        DB::enableQueryLog();

        $this->actingAs($user)
            ->get(route('products.index'))
            ->assertOk();

        DB::flushQueryLog();

        $this->actingAs($user)
            ->get(route('products.index'))
            ->assertOk();

        $secondQueries = DB::getQueryLog();

        $queries = DB::getQueryLog();

        $this->assertLessThanOrEqual(5, count($queries));
    }
}
