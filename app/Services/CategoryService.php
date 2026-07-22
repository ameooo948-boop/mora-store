<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Services\ProductService;
use App\Services\StorageService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CategoryService
{

    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly StorageService $storageService,
        private readonly ProductService $productService
    ) {}

    public function create(array $data): Category
    {
        return DB::transaction(function () use ($data) {

            if (!empty($data['image'])) {

                $data['image'] = $this->storageService->upload(
                    $data['image'],
                    'categories'
                );
            }

            return $this->categoryRepository->create($data);
        });
    }

    public function update(Category $category, array $data): bool
    {
        return DB::transaction(function () use ($category, $data) {

            if (!empty($data['image'])) {

                $data['image'] = $this->storageService->replace(
                    file: $data['image'],
                    oldPath: $category->image,
                    folder: 'categories'
                );
            } else {

                unset($data['image']);
            }

            return $this->categoryRepository->update(
                $category,
                $data
            );
        });
    }

    public function delete(Category $category): bool
    {
        return DB::transaction(function () use ($category) {

            $category->children()->update([
                'parent_id' => null,
            ]);

            if ($category->products()->exists()) {
                return false;
            }

            if ($category->image) {
                $this->storageService->delete($category->image);
            }

            return $this->categoryRepository->delete($category);
        });
    }

    public function getParents()
    {
        return $this->categoryRepository->getParents();
    }

    public function paginate(
        ?string $search = null,
        ?int $status = null,
    ): LengthAwarePaginator {
        return $this->categoryRepository->paginate($search, $status);
    }

    public function getStatistics(): array
    {
        return $this->categoryRepository->getStatistics();
    }

    public function getActive(): Collection
    {
        return $this->categoryRepository->getActive();
    }
}
