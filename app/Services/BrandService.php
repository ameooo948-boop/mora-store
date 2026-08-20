<?php

namespace App\Services;

use App\DTOs\Brand\CreateBrandData;
use App\DTOs\Brand\UpdateBrandData;
use App\Models\Brand;
use App\Repositories\Contracts\BrandRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BrandService
{
    public function __construct(
        private readonly BrandRepositoryInterface $brandRepository,
        private readonly StorageService $storageService
    ) {}

    public function create(CreateBrandData $data): Brand
    {
        return DB::transaction(function () use ($data) {

            $logo = $data->logo;

            if ($logo) {
                $logo = $this->storageService->upload(
                    $logo,
                    'brands'
                );
            }

            return $this->brandRepository->create([
                'name' => $data->name,
                'description' => $data->description,
                'logo' => $logo,
                'status' => $data->status,
                'sort_order' => $data->sortOrder,
            ]);
        });
    }

    public function update(
        Brand $brand,
        UpdateBrandData $data,
    ): bool {
        return DB::transaction(function () use ($brand, $data) {

            $logo = $data->logo;

            if ($logo) {
                $logo = $this->storageService->replace(
                    file: $logo,
                    oldPath: $brand->logo,
                    folder: 'brands'
                );
            }

            $updateData = [
                'name' => $data->name,
                'description' => $data->description,
                'status' => $data->status,
                'sort_order' => $data->sortOrder,
            ];

            if ($logo) {
                $updateData['logo'] = $logo;
            }

            return $this->brandRepository->update(
                $brand,
                $updateData
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

    public function paginate(
        ?int $status = null,
        ?string $search = null
    ): LengthAwarePaginator {
        return $this->brandRepository->paginate(
            $status,
            $search
        );
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
