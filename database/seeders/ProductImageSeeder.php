<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $apiKey = config('services.pexels.key');

        if (! $apiKey) {
            $this->command?->error(
                'PEXELS_API_KEY is missing from .env'
            );

            return;
        }

        $products = Product::with(['brand', 'category'])
            ->orderBy('id')
            ->get();

        $created = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($products as $product) {

            /*
            |--------------------------------------------------------------------------
            | Skip products that already have an image
            |--------------------------------------------------------------------------
            */

            if (
                ProductImage::where('product_id', $product->id)->exists()
            ) {
                $this->command?->line(
                    "SKIPPED: {$product->name}"
                );

                $skipped++;

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Build a precise Pexels search
            |--------------------------------------------------------------------------
            */

            $brand = $product->brand?->name;
            $category = $product->category?->name;

            $queryParts = array_filter([
                $brand,
                $product->name,
                $category,
                'product',
            ]);

            $query = implode(' ', $queryParts);

            try {

                $response = Http::timeout(30)
                    ->retry(2, 1500)
                    ->withHeaders([
                        'Authorization' => $apiKey,
                        'Accept' => 'application/json',
                    ])
                    ->get('https://api.pexels.com/v1/search', [
                        'query' => $query,
                        'per_page' => 5,
                        'orientation' => 'landscape',
                        'size' => 'large',
                        'locale' => 'en-US',
                    ]);

                /*
                |--------------------------------------------------------------------------
                | Rate limit
                |--------------------------------------------------------------------------
                */

                if ($response->status() === 429) {

                    $this->command?->error(
                        "RATE LIMIT: {$product->name}"
                    );

                    $failed++;

                    // Stop instead of burning the remaining requests.
                    break;
                }

                if (! $response->successful()) {

                    $this->command?->error(
                        "ERROR {$product->name}: HTTP {$response->status()}"
                    );

                    $failed++;

                    continue;
                }

                $photos = $response->json('photos', []);

                if (empty($photos)) {

                    /*
                    |--------------------------------------------------------------------------
                    | Fallback search
                    |--------------------------------------------------------------------------
                    */

                    $fallbackQuery = trim(
                        ($category ?: 'electronics').' product'
                    );

                    $fallback = Http::timeout(30)
                        ->withHeaders([
                            'Authorization' => $apiKey,
                            'Accept' => 'application/json',
                        ])
                        ->get('https://api.pexels.com/v1/search', [
                            'query' => $fallbackQuery,
                            'per_page' => 5,
                            'orientation' => 'landscape',
                            'size' => 'large',
                            'locale' => 'en-US',
                        ]);

                    if ($fallback->status() === 429) {

                        $this->command?->error(
                            "RATE LIMIT during fallback: {$product->name}"
                        );

                        $failed++;
                        break;
                    }

                    if ($fallback->successful()) {
                        $photos = $fallback->json('photos', []);
                    }
                }

                if (empty($photos)) {

                    $this->command?->warn(
                        "NO IMAGE: {$product->name}"
                    );

                    $failed++;

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Pick the first result with a usable image URL
                |--------------------------------------------------------------------------
                */

                $photo = collect($photos)->first(
                    fn ($photo) => ! empty($photo['src']['large2x']) ||
                        ! empty($photo['src']['large']) ||
                        ! empty($photo['src']['medium'])
                );

                if (! $photo) {

                    $this->command?->warn(
                        "NO USABLE IMAGE: {$product->name}"
                    );

                    $failed++;

                    continue;
                }

                $imageUrl =
                    $photo['src']['large2x']
                    ?? $photo['src']['large']
                    ?? $photo['src']['medium'];

                /*
                |--------------------------------------------------------------------------
                | Download image
                |--------------------------------------------------------------------------
                */

                $imageResponse = Http::timeout(45)
                    ->retry(2, 1500)
                    ->withHeaders([
                        'User-Agent' => 'Mora Store',
                        'Accept' => 'image/avif,image/webp,image/jpeg,image/png,*/*',
                    ])
                    ->get($imageUrl);

                if (! $imageResponse->successful()) {

                    $this->command?->error(
                        "IMAGE DOWNLOAD ERROR {$product->name}: HTTP {$imageResponse->status()}"
                    );

                    $failed++;

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Store locally
                |--------------------------------------------------------------------------
                */

                $filename = $product->slug.'.jpg';
                $path = "products/{$filename}";

                Storage::disk('public')->put(
                    $path,
                    $imageResponse->body()
                );

                /*
                |--------------------------------------------------------------------------
                | Save relation
                |--------------------------------------------------------------------------
                */

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'sort_order' => 0,
                ]);

                $created++;

                $photographer = $photo['photographer'] ?? 'Unknown';

                $this->command?->info(
                    "SUCCESS {$product->name} -> {$path} | Photo by {$photographer} on Pexels"
                );

                /*
                |--------------------------------------------------------------------------
                | Small delay
                |--------------------------------------------------------------------------
                */

                usleep(250000);

            } catch (\Throwable $e) {

                $this->command?->error(
                    "EXCEPTION {$product->name}: {$e->getMessage()}"
                );

                $failed++;
            }
        }

        $this->command?->newLine();

        $this->command?->info(
            "Images created: {$created}"
        );

        $this->command?->info(
            "Products skipped: {$skipped}"
        );

        $this->command?->info(
            "Failed: {$failed}"
        );
    }
}
