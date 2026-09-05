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
    ): Category {
        return DB::transaction(function () use ($category, $data) {

            $this->assertValidParent($category, $data->parentId);

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

            $this->categoryRepository->update(
                $category,
                $updateData
            );

            $category->refresh();

            Cache::forget('categories.active');

            return $category;

        });
    }

    private function assertValidParent(Category $category, ?int $parentId): void
    {
        if ($parentId === null) {
            return;
        }

        $visited = [$category->id => true];
        $cursor = Category::query()->find($parentId);

        while ($cursor) {
            if (isset($visited[$cursor->id])) {
                throw new \DomainException('A category cannot be placed inside one of its descendants.');
            }

            $visited[$cursor->id] = true;
            $cursor = $cursor->parent_id ? Category::query()->find($cursor->parent_id) : null;
        }
    }

    public function delete(Category $category): bool
    {
        return DB::transaction(function () use ($category) {

            if ($category->products()->exists()) {
                return false;
            }

            $category->children()->update([
                'parent_id' => null,
            ]);

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

    public function getActiveParents()
    {
        return $this->categoryRepository->getActiveParents();
    }

    public function findBySlug(string $slug): ?Category
    {
        return $this->categoryRepository->findBySlug($slug);
    }

    public function getProductsForCategory(Category $category)
    {
        return $this->categoryRepository->getProductsForCategory($category);
    }
}
