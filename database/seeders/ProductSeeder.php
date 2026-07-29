<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder

{
    public function run(): void
    {
        $categories = Category::all();
        $brands = Brand::all();

        Product::factory()
            ->count(10)
            ->make()
            ->each(function ($product) use ($categories, $brands) {

                $product->category_id = $categories->random()->id;
                $product->brand_id = $brands->random()->id;

                $product->save();
            });
    }
}
