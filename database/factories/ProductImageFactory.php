<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;

    public function definition(): array
    {
        $images = collect(File::files(public_path('storage/products')))
            ->map(fn($file) => 'products/' . $file->getFilename())
            ->toArray();

        return [
            'product_id' => Product::factory(),
            'image' => fake()->randomElement($images),
            'sort_order' => 0,
        ];
    }
}
