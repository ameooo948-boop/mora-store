<?php

use App\Services\ImageDownloader;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

test('it downloads a direct image url into public storage', function () {
    Http::fake([
        'https://images.example.test/phone.jpg' => Http::response(
            'fake-jpeg-bytes',
            200,
            ['Content-Type' => 'image/jpeg']
        ),
    ]);

    $path = app(ImageDownloader::class)->download(
        url: 'https://images.example.test/phone.jpg',
        directory: 'products/samsung-galaxy-s25',
        filename: '1.jpg'
    );

    expect($path)->toBe('products/samsung-galaxy-s25/1.jpg');
    Storage::disk('public')->assertExists($path);
    expect(Storage::disk('public')->get($path))->toBe('fake-jpeg-bytes');
});

test('it extracts og:image when given an html product page', function () {
    Http::fake([
        'https://shop.example.test/s25' => Http::response(
            '<html><head><meta property="og:image" content="https://cdn.example.test/s25-hero.jpg"></head></html>',
            200,
            ['Content-Type' => 'text/html; charset=UTF-8']
        ),
        'https://cdn.example.test/s25-hero.jpg' => Http::response(
            'hero-bytes',
            200,
            ['Content-Type' => 'image/jpeg']
        ),
    ]);

    $path = app(ImageDownloader::class)->download(
        url: 'https://shop.example.test/s25',
        directory: 'products/samsung-galaxy-s25',
        filename: '2.jpg'
    );

    expect($path)->toBe('products/samsung-galaxy-s25/2.jpg');
    expect(Storage::disk('public')->get($path))->toBe('hero-bytes');
});

test('product image seeder maps at least three images for every catalog product', function () {
    $seeder = new ReflectionClass(Database\Seeders\ProductImageSeeder::class);
    $source = file_get_contents($seeder->getFileName());

    preg_match_all("/'([a-z0-9-]+)' => \[/", $source, $matches);
    $slugs = $matches[1] ?? [];

    $catalog = collect(Database\Factories\ProductFactory::products())
        ->pluck('slug')
        ->all();

    expect($slugs)->toEqualCanonicalizing($catalog);

    foreach ($slugs as $slug) {
        preg_match(
            "/'{$slug}' => \[(.*?)\],/s",
            $source,
            $block
        );

        $count = substr_count($block[1] ?? '', '$this->photo(');

        expect($count)->toBeGreaterThanOrEqual(3);
    }
});
