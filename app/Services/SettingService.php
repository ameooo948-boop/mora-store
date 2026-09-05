<?php

namespace App\Services;

use App\DTOs\Setting\UpdateSettingData;
use App\Repositories\Contracts\SettingRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
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

            fn () => $this->repository->all()

        );
    }

    public function get(
        string $key,
        mixed $default = null,
    ): mixed {

        return $this->all()[$key] ?? $default;
    }

    public function update(UpdateSettingData $data): void
    {
        $settings = [
            'site_name' => $data->siteName,
            'site_description' => $data->siteDescription,
            'currency' => $data->currency,
            'currency_symbol' => $data->currencySymbol,
            'shipping_cost' => $data->shippingCost,
            'tax_percentage' => $data->taxPercentage,
            'email' => $data->email,
            'phone' => $data->phone,
            'address' => $data->address,
            'facebook' => $data->facebook,
            'instagram' => $data->instagram,
            'linkedin' => $data->linkedin,
            'maintenance_mode' => $data->maintenanceMode,
        ];

        $oldLogo = $data->siteLogo ? $this->get('site_logo') : null;
        $oldFavicon = $data->siteFavicon ? $this->get('site_favicon') : null;

        if ($data->siteLogo) {
            $settings['site_logo'] = $this->upload(
                $data->siteLogo,
                'settings'
            );
        }

        if ($data->siteFavicon) {
            $settings['site_favicon'] = $this->upload(
                $data->siteFavicon,
                'settings'
            );
        }

        $this->repository->updateMany($settings);

        $this->clearCache();

        // Delete replaced files only after the database update succeeds.
        foreach ([$oldLogo, $oldFavicon] as $oldFile) {
            if ($oldFile) {
                DB::afterCommit(function () use ($oldFile) {
                    Storage::disk('public')->delete($oldFile);
                });
            }
        }
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
