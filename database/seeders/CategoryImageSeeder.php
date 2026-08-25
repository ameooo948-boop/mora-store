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
