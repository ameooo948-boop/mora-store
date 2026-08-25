<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class BrandImageSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'gigabyte' => [
                'gigabyte',
                'gigabyte-technology',
            ],
        ];

        foreach ($brands as $brandSlug => $possibleSlugs) {

            $brand = Brand::where('slug', $brandSlug)->first();

            if (! $brand) {
                continue;
            }

            foreach ($possibleSlugs as $iconSlug) {

                $url = "https://cdn.jsdelivr.net/npm/simple-icons@latest/icons/{$iconSlug}.svg";

                try {

                    $response = Http::timeout(20)
                        ->get($url);

                    if (! $response->successful()) {
                        continue;
                    }

                    $path = "brands/{$brandSlug}.svg";

                    Storage::disk('public')->put(
                        $path,
                        $response->body()
                    );

                    $brand->forceFill([
                        'logo' => $path,
                    ])->save();

                    $this->command->info(
                        "SUCCESS {$brand->name} using {$iconSlug}"
                    );

                    break;

                } catch (\Throwable $e) {
                    continue;
                }
            }

            if (! $brand->fresh()->logo) {
                $this->command->error(
                    "FAILED {$brand->name}"
                );
            }
        }
    }
}
