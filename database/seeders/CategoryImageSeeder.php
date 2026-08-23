<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class CategoryImageSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [

            'mobile-phones' => [
                'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9',
            ],

            'laptops' => [
                'https://images.unsplash.com/photo-1496181133206-80ce9b88a853',
            ],

            'desktop-computers' => [
                'https://images.unsplash.com/photo-1593640408182-31c70c8268f5',
            ],

            'computer-components' => [
                'https://images.unsplash.com/photo-1591488320449-011701bb6704',
            ],

            'monitors' => [
                'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf',
            ],

            'tvs' => [
                'https://images.unsplash.com/photo-1593359677879-a4bb92f829d1',
            ],

            'home-appliances' => [
                'https://images.unsplash.com/photo-1584622650111-993a426fbf0a',
            ],

            'audio' => [
                'https://images.unsplash.com/photo-1505740420928-5e560c06d30e',
            ],

            'air-conditioners' => [
                'https://images.unsplash.com/photo-1621905252507-b35492cc74b4',
            ],

            'mobile-accessories' => [
                'https://images.unsplash.com/photo-1585060544812-6b45742d762f',
            ],
            'computer-accessories' => [
                'https://images.unsplash.com/photo-1527814050087-3793815479db',
            ],

            'networking' => [
                'https://images.unsplash.com/photo-1558494949-ef010cbdcc31',
            ],

            'gaming' => [
                'https://images.unsplash.com/photo-1593305841991-05c297ba4575',
            ],

            'smart-devices' => [
                'https://images.unsplash.com/photo-1551817958-d9d86fb29431',
            ],

            'storage' => [
                'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b',
            ],
        ];

        foreach ($categories as $slug => $urls) {

            $category = Category::where('slug', $slug)->first();

            if (! $category) {
                continue;
            }

            $url = $urls[0].'?auto=format&fit=crop&w=1200&q=85';

            try {

                $response = Http::timeout(30)
                    ->retry(2, 1000)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0',
                    ])
                    ->get($url);

                if (! $response->successful()) {

                    $this->command?->warn(
                        "Category image failed: {$slug}"
                    );

                    continue;
                }

                $path = "categories/{$slug}.jpg";

                Storage::disk('public')->put(
                    $path,
                    $response->body()
                );

                $category->update([
                    'image' => $path,
                ]);

                $this->command?->info(
                    "Category image downloaded: {$slug}"
                );

            } catch (\Throwable $e) {

                $this->command?->error(
                    "Category image error: {$slug}"
                );
            }
        }
    }
}
