<?php

namespace App\Repositories\Eloquent;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data): bool
    {
        return $category->update($data);
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }

    public function getParents()
    {
        return Category::query()
            ->orderBy('name', 'asc')
            ->get();
    }

    public function paginate(
        ?string $search = null,
        ?int $status = null,
    ): LengthAwarePaginator {
        return Category::query()

            ->withCount('products')

            ->when($search, function ($query) use ($search) {

                $query->where('name', 'like', "%{$search}%");
            })

            ->when(! is_null($status), function ($query) use ($status) {

                $query->where('status', $status);
            })

            ->latest()

            ->paginate(10)

            ->withQueryString();
    }

    public function getStatistics(): array
    {
        return [
            'total' => Category::count(),
            'active' => Category::active()->count(),
            'inactive' => Category::inactive()->count(),
            'main' => Category::main()->count(),
            'with_products' => Category::has('products')->count(),
        ];
    }

    public function getActive(): Collection
    {
        return Cache::rememberForever(
            'categories.active',
            fn () => Category::active()
                ->orderBy('sort_order')
                ->get()
        );
    }

    public function getActiveParents()
    {
        return Category::query()
            ->active()
            ->main()
            ->with([
                'children' => fn ($query) => $query
                    ->active()
                    ->orderBy('sort_order'),
            ])
            ->withCount([
                'products as direct_products_count' => fn ($query) => $query->active(),
                'children as children_count' => fn ($query) => $query->active(),
            ])
            ->orderBy('sort_order')
            ->get();
    }

    public function findBySlug(string $slug): ?Category
    {
        return Category::query()
            ->active()
            ->where('slug', $slug)
            ->with([
                'parent',
                'children' => fn ($query) => $query
                    ->active()
                    ->orderBy('sort_order'),
            ])
            ->first();
    }

    public function getProductsForCategory(Category $category)
    {
        $categoryIds = collect([$category->id])
            ->merge($category->children()->active()->pluck('id'));

        return Product::query()
            ->active()
            ->whereIn('category_id', $categoryIds)
            ->with([
                'brand',
                'images',
            ])
            ->latest()
            ->paginate(12);
    }
}
