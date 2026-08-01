<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): bool
    {
        return $product->update($data);
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }

    public function paginateAdmin(
        ?string $search = null,
        ?int $category = null,
        ?int $brand = null,
        ?int $status = null,
    ) {
        return Product::query()

            ->with([
                'category',
                'brand',
                'images',
            ])

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('name', 'like', "%{$search}%");
                });
            })

            ->when($category !== null, function ($query) use ($category) {
                $query->where('category_id', $category);
            })

            ->when($brand !== null, function ($query) use ($brand) {
                $query->where('brand_id', $brand);
            })

            ->when($status !== null, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()

            ->paginate(10)

            ->withQueryString();
    }


    public function paginateStore(array $filters = [])
    {
        return Product::query()

            ->with([
                'category',
                'brand',
                'images',
            ])

            ->where('status', true)

            ->when(
                filled($filters['search'] ?? null),
                function ($query) use ($filters) {

                    $query->where(function ($q) use ($filters) {

                        $q->where(
                            'name',
                            'like',
                            "%{$filters['search']}%"
                        );
                    });
                }
            )

            ->when(
                filled($filters['category'] ?? null),
                fn($query) => $query->where(
                    'category_id',
                    $filters['category']
                )
            )

            ->when(
                filled($filters['brand'] ?? null),
                fn($query) => $query->where(
                    'brand_id',
                    $filters['brand']
                )
            )

            ->when(
                ($filters['sort'] ?? null) === 'price_low',
                fn($query) => $query->orderBy('price')
            )

            ->when(
                ($filters['sort'] ?? null) === 'price_high',
                fn($query) => $query->orderByDesc('price')
            )

            ->when(
                ($filters['sort'] ?? null) === 'oldest',
                fn($query) => $query->oldest()
            )

            ->when(
                ! in_array(
                    $filters['sort'] ?? null,
                    [
                        'price_low',
                        'price_high',
                        'oldest',
                    ]
                ),
                fn($query) => $query->latest()
            )

            ->paginate(12)

            ->withQueryString();
    }


    public function getStatistics(): array
    {
        return [

            'total' => Product::count(),

            'active' => Product::where('status', true)->count(),

            'inactive' => Product::where('status', false)->count(),

            'out_of_stock' => Product::where('quantity', 0)->count(),

        ];
    }

    public function latest(int $limit = 8)
    {
        return Product::query()
            ->with([
                'brand',
                'category',
                'images',
                'approvedReviews.user',
            ])

            ->withAvg([
                'approvedReviews',
            ], 'rating')

            ->withCount([
                'approvedReviews',
            ])

            ->where('status', true)
            ->latest()
            ->take($limit)
            ->get();
    }

    public function find(Product $product)
    {
        return Product::query()

            ->with([
                'brand',
                'category',
                'images',
                'approvedReviews.user',
            ])

            ->withAvg([
                'approvedReviews',
            ], 'rating')

            ->withCount([
                'approvedReviews',
            ])

            ->where('status', true)
            ->findOrFail($product->id);
    }

    public function related(Product $product, int $limit = 4)
    {
        return Product::query()

            ->with([
                'brand',
                'category',
                'images',
                'approvedReviews.user',
            ])

            ->withAvg([
                'approvedReviews',
            ], 'rating')

            ->withCount([
                'approvedReviews',
            ])

            ->where('status', true)

            ->where('category_id', $product->category_id)

            ->whereKeyNot($product->id)

            ->take($limit)

            ->get();
    }
}
