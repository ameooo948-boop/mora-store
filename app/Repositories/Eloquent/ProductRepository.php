<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\Auth;

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

    public function paginateStore(
        ?string $search = null,
        ?int $category = null,
        ?int $brand = null,
        ?string $sort = null,
    ) {
        $query = Product::query()
            ->with([
                'category',
                'brand',
                'images',
            ]);

        $query = $this->withWishlistStatus($query);

        return $query

            ->active()
            ->when(
                filled($search),
                function ($query) use ($search) {

                    $query->where(
                        'name',
                        'like',
                        "%{$search}%"
                    );
                }
            )
            ->when(
                $category !== null,
                fn ($query) => $query->where(
                    'category_id',
                    $category
                )
            )
            ->when(
                $brand !== null,
                fn ($query) => $query->where(
                    'brand_id',
                    $brand
                )
            )
            ->when(
                $sort === 'price_low',
                fn ($query) => $query->orderBy('price')
            )
            ->when(
                $sort === 'price_high',
                fn ($query) => $query->orderByDesc('price')
            )
            ->when(
                $sort === 'oldest',
                fn ($query) => $query->oldest()
            )
            ->when(
                ! in_array(
                    $sort,
                    [
                        'price_low',
                        'price_high',
                        'oldest',
                    ]
                ),
                fn ($query) => $query->latest()
            )
            ->paginate(12)
            ->withQueryString();
    }

    public function getStatistics(): array
    {
        return [

            'total' => Product::count(),

            'active' => Product::active()->count(),
            'inactive' => Product::inactive()->count(),

            'out_of_stock' => Product::where('quantity', 0)->count(),

        ];
    }

    public function latest(int $limit = 8)
    {
        $query = Product::query()
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
            ]);

        $query = $this->withWishlistStatus($query);

        return $query
            ->active()
            ->latest()
            ->take($limit)
            ->get();
    }

    public function find(Product $product)
    {
        $query = Product::query()
            ->with([
                'brand',
                'category',
                'images',
                'approvedReviews.user',
            ])
            ->withAvg(
                'approvedReviews',
                'rating'
            )
            ->withCount(
                'approvedReviews'
            );

        $query = $this->withWishlistStatus($query);

        return $query
            ->active()
            ->findOrFail($product->id);
    }

    public function related(Product $product, int $limit = 4)
    {
        $query = Product::query()
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
            ]);

        $query = $this->withWishlistStatus($query);

        return $query
            ->active()
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->take($limit)
            ->get();
    }

    private function withWishlistStatus($query)
    {
        if (Auth::check()) {
            $query->withExists([
                'wishlists as is_in_wishlist' => function ($query) {
                    $query->where('user_id', Auth::id());
                },
            ]);
        }

        return $query;
    }
}
