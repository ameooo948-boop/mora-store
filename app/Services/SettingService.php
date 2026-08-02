<?php

namespace App\Services;

use App\Repositories\Contracts\SettingRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SettingService
{
    const CACHE_KEY = 'settings';

    public function __construct(
        protected SettingRepositoryInterface $repository,
    ) {}

    public function all(): array
    {
        return Cache::rememberForever(

            self::CACHE_KEY,

            fn() => $this->repository->all()

        );
    }

    public function get(
        string $key,
        mixed $default = null,
    ): mixed {

        return $this->all()[$key] ?? $default;
    }

    public function update(array $data): void
    {
        if (
            isset($data['site_logo']) &&
            $data['site_logo'] instanceof UploadedFile
        ) {

            $oldLogo = $this->get('site_logo');

            if (
                $oldLogo &&
                Storage::disk('public')->exists($oldLogo)
            ) {

                Storage::disk('public')->delete(
                    $oldLogo
                );
            }

            $data['site_logo'] = $this->upload(

                $data['site_logo'],

                'settings'

            );
        }

        if (
            isset($data['site_favicon']) &&
            $data['site_favicon'] instanceof UploadedFile
        ) {

            $oldFavicon = $this->get('site_favicon');

            if (
                $oldFavicon &&
                Storage::disk('public')->exists($oldFavicon)
            ) {

                Storage::disk('public')->delete(
                    $oldFavicon
                );
            }

            $data['site_favicon'] = $this->upload(

                $data['site_favicon'],

                'settings'

            );
        }

        if (! isset($data['maintenance_mode'])) {

            $data['maintenance_mode'] = false;
        }

        $this->repository->updateMany(
            $data
        );

        $this->clearCache();
    }
    
    private function upload(
        UploadedFile $file,
        string $directory,
    ): string {

        return $file->store(

            $directory,

            'public'

        );
    }

    public function value(
        string $key,
        mixed $default = '',
    ): mixed {
        return $this->get(
            $key,
            $default
        );
    }

    public function clearCache(): void
    {
        Cache::forget(
            self::CACHE_KEY
        );
    }
}
