<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->paragraph(),
            'sku' => fake()->unique()->bothify('SKU-#####'),
            'price' => fake()->randomFloat(2, 10, 1000),
            'sale_price' => null,
            'quantity' => fake()->numberBetween(1, 100),
            'status' => true,
            'featured' => false,
            'sort_order' => 0,
        ];
    }

    public function withRelations(): static
    {
        return $this->state(fn() => [
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
        ]);
    }
}
