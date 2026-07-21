<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Product;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly CategoryRepositoryInterface $categoryRepository,
        private readonly BrandRepositoryInterface $brandRepository,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = $this->productService->paginate(
            search: $request->search
        );

        $statistics = $this->productService->getStatistics();

        return view('admin.products.index', compact(
            'products',
            'statistics'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create', [
            'categories' => $this->categoryRepository->getActive(),
            'brands' => $this->brandRepository->getActive(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $this->productService->create(
            $request->validated(),
        );

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product' => $product,

            'categories' => $this->categoryRepository->getActive(),
            'brands' => $this->brandRepository->getActive(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( UpdateProductRequest $request, Product $product ) 
    {
        $this->productService->update(
            $product,
            $request->validated()
        );

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->productService->delete($product);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
