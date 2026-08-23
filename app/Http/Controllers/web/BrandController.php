<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Services\BrandService;
use App\Services\ProductService;

class BrandController extends Controller
{
    public function __construct(
        private readonly BrandService $brandService,
        private readonly ProductService $productService,
    ) {}

    public function index()
    {
        $brands = $this->brandService->getActive();

        $brands->loadCount([
            'products' => fn ($query) => $query->where('status', true),
        ]);

        return view('web.brands.index', compact('brands'));
    }

    public function show(Brand $brand)
    {
        abort_unless($brand->status, 404);

        $products = $this->productService->paginateStore(
            brand: $brand->id,
        );

        $brand->loadCount([
            'products' => fn ($query) => $query->where('status', true),
        ]);

        return view(
            'web.brands.show',
            compact('brand', 'products')
        );
    }
}
