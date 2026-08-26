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
        $queries = [
            'mobile-phones' => 'smartphone',
            'iphones' => 'iPhone smartphone',
            'android-phones' => 'Android smartphone',
            'budget-phones' => 'smartphone',
            'mid-range-phones' => 'smartphone',
            'flagship-phones' => 'premium smartphone',

            'laptops' => 'laptop',
            'gaming-laptops' => 'gaming laptop',
            'business-laptops' => 'business laptop',
            'student-laptops' => 'laptop studying',
            'ultrabooks' => 'ultrabook laptop',
            '2-in-1-laptops' => '2 in 1 laptop',
            'professional-laptops' => 'professional laptop',

            'desktop-computers' => 'desktop computer',
            'gaming-pcs' => 'gaming PC',
            'office-pcs' => 'office desktop computer',
            'all-in-one-pcs' => 'all in one computer',
            'mini-pcs' => 'mini PC',

            'graphics-cards' => 'graphics card GPU',
            'processors' => 'computer processor CPU',
            'motherboards' => 'computer motherboard',
            'ram' => 'computer RAM',
            'ssds' => 'SSD storage',
            'hard-drives' => 'hard disk drive',
            'power-supplies' => 'PC power supply',
            'pc-cases' => 'gaming PC case',
            'cpu-coolers' => 'CPU cooler',

            'monitors' => 'computer monitor',
            'gaming-monitors' => 'gaming monitor',
            '4k-monitors' => '4K monitor',
            'curved-monitors' => 'curved computer monitor',
            'professional-monitors' => 'professional monitor',

            'tvs' => 'smart television',
            'smart-tvs' => 'smart TV',
            'led-tvs' => 'LED television',
            'oled-tvs' => 'OLED television',
            'qled-tvs' => 'QLED television',
            '4k-tvs' => '4K television',

            'refrigerators' => 'modern refrigerator',
            'washing-machines' => 'washing machine',
            'dishwashers' => 'dishwasher',
            'microwaves' => 'microwave oven',
            'electric-ovens' => 'electric oven',
            'vacuum-cleaners' => 'vacuum cleaner',

            'air-conditioners' => 'air conditioner',
            'split-air-conditioners' => 'split air conditioner',
            'inverter-air-conditioners' => 'inverter air conditioner',
            'portable-air-conditioners' => 'portable air conditioner',

            'audio' => 'audio equipment',
            'wireless-earbuds' => 'wireless earbuds',
            'headphones' => 'headphones',
            'bluetooth-speakers' => 'bluetooth speaker',
            'soundbars' => 'soundbar',
            'home-audio-systems' => 'home audio system',

            'mobile-accessories' => 'smartphone accessories',
            'chargers' => 'phone charger',
            'charging-cables' => 'USB charging cable',
            'power-banks' => 'power bank',
            'phone-cases' => 'smartphone case',
            'screen-protectors' => 'phone screen protector',
            'wireless-chargers' => 'wireless charger',

            'keyboards' => 'computer keyboard',
            'gaming-keyboards' => 'gaming keyboard',
            'mice' => 'computer mouse',
            'gaming-mice' => 'gaming mouse',
            'webcams' => 'computer webcam',
            'mouse-pads' => 'gaming mouse pad',
            'laptop-bags' => 'laptop bag',
            'laptop-stands' => 'laptop stand',

            'routers' => 'WiFi router',
            'wifi-extenders' => 'WiFi extender',
            'network-switches' => 'network switch',
            'network-adapters' => 'network adapter',
            'mesh-wifi-systems' => 'mesh WiFi system',

            'playstation' => 'PlayStation console',
            'xbox' => 'Xbox console',
            'nintendo' => 'Nintendo console',
            'gaming-controllers' => 'gaming controller',
            'gaming-headsets' => 'gaming headset',
            'gaming-accessories' => 'gaming accessories',

            'smart-watches' => 'smart watch',
            'smart-bands' => 'fitness smart band',
            'smart-home-devices' => 'smart home technology',
            'smart-cameras' => 'smart security camera',

            'external-ssds' => 'external SSD',
            'external-hard-drives' => 'external hard drive',
            'usb-flash-drives' => 'USB flash drive',
            'memory-cards' => 'SD memory card',
        ];

        $apiKey = config('services.pexels.key');

        if (! $apiKey) {
            $this->command?->error('PEXELS_API_KEY is missing.');

            return;
        }

        $categories = Category::query()
            ->whereNull('image')
            ->where('status', true)
            ->orderBy('id')
            ->get();

        foreach ($categories as $category) {

            $query = $queries[$category->slug]
                ?? $category->name.' technology product';

            try {

                $search = Http::timeout(30)
                    ->withHeaders([
                        'Authorization' => $apiKey,
                    ])
                    ->get('https://api.pexels.com/v1/search', [
                        'query' => $query,
                        'orientation' => 'landscape',
                        'size' => 'large',
                        'per_page' => 5,
                    ]);

                if (! $search->successful()) {
                    $this->command?->error(
                        "{$category->slug}: Search HTTP {$search->status()}"
                    );

                    continue;
                }

                $photos = $search->json('photos', []);

                if (empty($photos)) {
                    $this->command?->warn(
                        "{$category->slug}: No suitable photos found."
                    );

                    continue;
                }

                /*
                 * Use the first search result.
                 */
                $photo = $photos[0];

                $imageUrl =
                    $photo['src']['large2x']
                    ?? $photo['src']['large']
                    ?? null;

                if (! $imageUrl) {
                    continue;
                }

                /*
                 * Download the actual image.
                 */
                $image = Http::timeout(45)
                    ->get($imageUrl);

                if (! $image->successful()) {
                    $this->command?->error(
                        "{$category->slug}: Image download failed."
                    );

                    continue;
                }

                $path = "categories/{$category->slug}.jpg";

                Storage::disk('public')->put(
                    $path,
                    $image->body()
                );

                $category->forceFill([
                    'image' => $path,
                ])->save();

                $this->command?->info(
                    "SUCCESS {$category->name}"
                );

                /*
                 * Small delay.
                 */
                usleep(300000);

            } catch (\Throwable $e) {

                $this->command?->error(
                    "{$category->slug}: {$e->getMessage()}"
                );
            }
        }

        $this->command?->info(
            'Category images imported successfully.'
        );
    }
}
