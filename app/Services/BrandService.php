<?php

namespace App\Services;

use App\Models\Brand;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Services\StorageService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BrandService
{

    public function __construct(
        private readonly BrandRepositoryInterface $brandRepository,
        private readonly StorageService $storageService
    ) {}

    public function create(array $data): Brand
    {
        return DB::transaction(function () use ($data) {

            if (!empty($data['logo'])) {

                $data['logo'] = $this->storageService->upload(
                    $data['logo'],
                    'brands'
                );
            }

            $brand = $this->brandRepository->create($data);

            Cache::forget('categories.active');

            return $brand;
        });
    }
    public function update(Brand $brand, array $data): bool
    {
        return DB::transaction(function () use ($brand, $data) {

            if (!empty($data['logo'])) {

                $data['logo'] = $this->storageService->replace(
                    file: $data['logo'],
                    oldPath: $brand->logo,
                    folder: 'brands'
                );
            } else {

                unset($data['logo']);
            }

            $result = $this->brandRepository->update(
                $brand,
                $data
            );

            Cache::forget('categories.active');

            return $result;
        });
    }

    public function delete(Brand $brand): bool
    {
        return DB::transaction(function () use ($brand) {

            if ($brand->products()->exists()) {
                return false;
            }

            if ($brand->logo) {
                $this->storageService->delete($brand->logo);
            }

            $result = $this->brandRepository->delete($brand);

            if ($result) {
                Cache::forget('categories.active');
            }

            return $result;
        });
    }

    public function paginate(?int $status = null, ?string $search = null): LengthAwarePaginator
    {
        return $this->brandRepository->paginate($status, $search);
    }

    public function getStatistics(): array
    {
        return $this->brandRepository->getStatistics();
    }

    public function getActive(): Collection
    {
        return $this->brandRepository->getActive();
    }
}
