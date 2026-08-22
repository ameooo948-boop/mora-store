<?php

namespace App\Services;

use App\DTOs\Category\CreateCategoryData;
use App\DTOs\Category\UpdateCategoryData;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly StorageService $storageService,
        private readonly ProductService $productService
    ) {}

    public function create(CreateCategoryData $data): Category
    {
        return DB::transaction(function () use ($data) {

            $image = $data->image;

            if ($image) {
                $image = $this->storageService->upload(
                    $image,
                    'categories'
                );
            }

            $category = $this->categoryRepository->create([
                'name' => $data->name,
                'description' => $data->description,
                'image' => $image,
                'parent_id' => $data->parentId,
                'status' => $data->status,
                'sort_order' => $data->sortOrder,
            ]);

            Cache::forget('categories.active');

            return $category;
        });
    }

    public function update(
        Category $category,
        UpdateCategoryData $data,
    ): bool {
        return DB::transaction(function () use ($category, $data) {

            $image = $data->image;

            if ($image) {
                $image = $this->storageService->replace(
                    file: $image,
                    oldPath: $category->image,
                    folder: 'categories'
                );
            }

            $updateData = [
                'name' => $data->name,
                'description' => $data->description,
                'parent_id' => $data->parentId,
                'status' => $data->status,
                'sort_order' => $data->sortOrder,
            ];

            if ($image) {
                $updateData['image'] = $image;
            }

            $result = $this->categoryRepository->update(
                $category,
                $updateData
            );

            Cache::forget('categories.active');

            return $result;

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
            
            $result = $this->categoryRepository->delete($category);

            if ($result) {
                Cache::forget('categories.active');
            }

            return $result;
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
        return $this->categoryRepository->paginate(
            $search,
            $status
        );
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
