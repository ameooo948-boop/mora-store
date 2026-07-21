<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    public function paginate(
        ?string $search = null,
        ?int $category = null,
        ?int $status = null,
    ): LengthAwarePaginator {
        return Product::query()

            ->with([
                'category',
                'brand',
                'images',
            ])

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })

            ->when($category !== null, function ($query) use ($category) {
                $query->where('category_id', $category);
            })

            ->when($status !== null, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()

            ->paginate(10)

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
}
