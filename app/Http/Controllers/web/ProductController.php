<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CatalogService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private readonly CatalogService $catalogService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only([
            'search',
            'category',
            'brand',
            'sort',
        ]);

        return view(
            'web.products.index',
            [
                'products' => $this->catalogService->products($filters),

                'categories' => $this->catalogService->categories(),

                'brands' => $this->catalogService->brands(),
            ]
        );
    }

    public function show(Product $product)
    {
        $product = $this->catalogService->findProduct($product);

        return view(
            'web.products.show',
            [
                'product' => $product,

                'relatedProducts' => $this->catalogService
                    ->relatedProducts($product),
            ]
        );
    }
}
