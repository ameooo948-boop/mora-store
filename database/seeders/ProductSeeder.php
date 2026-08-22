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
        foreach (ProductFactory::products() as $product) {
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

                'category_id' => Category::where(
                    'slug',
                    $product['category']
                )->value('id'),

                'brand_id' => Brand::where(
                    'slug',
                    $product['brand']
                )->value('id'),
            ]);
        }
    }
}
