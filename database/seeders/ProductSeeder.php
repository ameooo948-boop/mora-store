<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Database\Factories\ProductFactory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $created = 0;
        $skipped = 0;

        foreach (ProductFactory::products() as $product) {

            $categoryId = Category::where(
                'slug',
                $product['category']
            )->value('id');

            $brandId = Brand::where(
                'slug',
                $product['brand']
            )->value('id');

            if (! $categoryId || ! $brandId) {

                $this->command?->warn(
                    "Skipped {$product['name']}: brand or category not found."
                );

                $skipped++;

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Check existing products INCLUDING soft deleted products
            |--------------------------------------------------------------------------
            */

            $exists = Product::withTrashed()
                ->where(function ($query) use ($product) {
                    $query->where('slug', $product['slug'])
                        ->orWhere('sku', $product['sku']);
                })
                ->exists();

            if ($exists) {

                $this->command?->warn(
                    "Skipped existing product: {$product['name']}"
                );

                $skipped++;

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Create
            |--------------------------------------------------------------------------
            */

            Product::factory()->create([
                'name' => $product['name'],
                'slug' => $product['slug'],
                'description' => $product['description'],
                'sku' => $product['sku'],
                'price' => $product['price'],
                'sale_price' => $product['sale_price'] ?? null,
                'quantity' => $product['quantity'] ?? 10,
                'status' => true,
                'featured' => $product['featured'] ?? false,
                'sort_order' => $product['sort_order'] ?? 0,

                'category_id' => $categoryId,
                'brand_id' => $brandId,
            ]);

            $this->command?->info(
                "Created: {$product['name']}"
            );

            $created++;
        }

        $this->command?->newLine();

        $this->command?->info(
            "Products created: {$created}"
        );

        $this->command?->info(
            "Products skipped: {$skipped}"
        );
    }
}
