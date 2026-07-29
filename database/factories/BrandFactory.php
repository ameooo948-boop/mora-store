<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        $name = fake()->unique()->company();

        return [
            'name' => $name,

            'slug' => Str::slug($name),

            'description' => fake()->optional()->paragraph(),

            'logo' => null,

            'status' => true,

            'sort_order' => 0,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn() => [
            'status' => false,
        ]);
    }
}
