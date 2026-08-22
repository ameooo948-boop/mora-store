<?php

namespace Database\Seeders;

use App\Models\Brand;
use Database\Factories\BrandFactory;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        foreach (BrandFactory::brands() as $index => $brand) {
            Brand::factory()->create([
                'name' => $brand['name'],
                'slug' => $brand['slug'],
                'description' => $brand['description'],
                'logo' => null,
                'status' => true,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
