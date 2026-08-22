<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageDownloader
{
    public function download(
        string $url,
        string $directory,
        string $filename
    ): ?string {
        try {
            $response = $this->fetch($url);

            if (! $response?->successful()) {
                return null;
            }

            $contentType = (string) $response->header('Content-Type');

            if ($this->isHtml($contentType)) {
                return $this->downloadFromPage($url, $directory, $filename);
            }

            return $this->store(
                $response->body(),
                $contentType,
                $directory,
                $filename
            );
        } catch (\Throwable $e) {
            report($e);

            return null;
        }
    }

    public function downloadFromPage(
        string $pageUrl,
        string $directory,
        string $filename
    ): ?string {
        try {
            $html = $this->fetch($pageUrl)?->body();

            if (! $html) {
                return null;
            }

            preg_match(
                '/<meta[^>]+property=["\']og:image["\'][^>]+content=["\']([^"\']+)["\']/i',
                $html,
                $matches
            );

            if (! isset($matches[1])) {
                preg_match(
                    '/<meta[^>]+content=["\']([^"\']+)["\'][^>]+property=["\']og:image["\']/i',
                    $html,
                    $matches
                );
            }

            if (! isset($matches[1])) {
                return null;
            }

            $imageUrl = html_entity_decode($matches[1]);

            if (str_starts_with($imageUrl, '//')) {
                $imageUrl = 'https:'.$imageUrl;
            }

            $response = $this->fetch($imageUrl);

            if (! $response?->successful()) {
                return null;
            }

            return $this->store(
                $response->body(),
                (string) $response->header('Content-Type'),
                $directory,
                $filename
            );

        } catch (\Throwable $e) {
            report($e);

            return null;
        }
    }

    private function fetch(string $url): ?Response
    {
        return Http::timeout(30)
            ->retry(2, 1000)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0',
                'Accept' => 'image/avif,image/webp,image/apng,image/*,*/*;q=0.8',
            ])
            ->get($url);
    }

    private function isHtml(string $contentType): bool
    {
        return str_contains($contentType, 'text/html');
    }

    private function store(
        string $contents,
        string $contentType,
        string $directory,
        string $filename
    ): string {
        $extension = match (true) {
            str_contains($contentType, 'png') => 'png',
            str_contains($contentType, 'webp') => 'webp',
            default => 'jpg',
        };

        $filename = Str::beforeLast($filename, '.')
            .'.'.$extension;

        $path = "{$directory}/{$filename}";

        Storage::disk('public')->put($path, $contents);

        return $path;
    }
}
