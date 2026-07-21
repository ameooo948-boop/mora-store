<?php

namespace App\Services;

use App\Repositories\Contracts\BrandRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Brand;
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

            return $this->brandRepository->create($data);
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

            return $this->brandRepository->update(
                $brand,
                $data
            );
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

            return $this->brandRepository->delete($brand);
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
}
