<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => $name,

            'slug' => Str::slug($name),

            'description' => fake()->optional()->paragraph(),

            'image' => null,

            'parent_id' => null,

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

    public function child(Category $parent): static
    {
        return $this->state(fn() => [
            'parent_id' => $parent->id,
        ]);
    }
}
