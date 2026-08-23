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
        $logos = [

            'gigabyte' => 'gigabyte',

            'tcl' => 'tcltechnology',

            'soundcore' => 'soundcore',
        ];

        foreach ($logos as $slug => $url) {

            $brand = Brand::where('slug', $slug)->first();

            if (! $brand) {
                continue;
            }

            try {

                $response = Http::timeout(30)
                    ->retry(3, 2000)
                    ->get($url);

                if (! $response->successful()) {

                    $this->command->error(
                        "{$brand->name}: HTTP {$response->status()}"
                    );

                    continue;
                }

                $path = "brands/{$slug}.svg";

                Storage::disk('public')->put(
                    $path,
                    $response->body()
                );

                $brand->forceFill([
                    'logo' => $path,
                ])->save();

                $this->command->info(
                    "SUCCESS {$brand->name}"
                );

            } catch (\Throwable $e) {

                $this->command->error(
                    "ERROR {$brand->name}: {$e->getMessage()}"
                );
            }
        }
    }
}
