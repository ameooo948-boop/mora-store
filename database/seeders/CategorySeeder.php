<?php

namespace Database\Seeders;

use App\Models\Category;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (CategoryFactory::mainCategories() as $index => $data) {
            $parent = Category::factory()->create([
                'name' => $data['name'],
                'slug' => $data['slug'],
                'description' => $data['description'],
                'parent_id' => null,
                'sort_order' => $index + 1,
            ]);

            foreach (
                CategoryFactory::subCategories()[$data['name']] ?? [] as $childIndex => $child
            ) {
                Category::factory()->create([
                    'name' => $child['name'],
                    'slug' => $child['slug'],
                    'description' => "Browse our {$child['name']} products.",
                    'parent_id' => $parent->id,
                    'sort_order' => $childIndex + 1,
                ]);
            }
        }
    }
}
