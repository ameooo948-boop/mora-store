<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\Product\CreateProductData;
use App\DTOs\Product\UpdateProductData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
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
        $status = $request->input('status');

        $status = $request->filled('status')
            ? (int) $request->status
            : null;

        $products = $this->productService->paginateAdmin(

            $request->search,
            $request->category,
            $request->brand,
            $status,

        );

        $statistics = $this->productService->getStatistics();

        $categories = Category::orderBy('name')->get();

        $brands = Brand::orderBy('name')->get();

        return view(
            'admin.products.index',
            compact(
                'products',
                'statistics',
                'categories',
                'brands'
            )
        );
    }

    public function show(Product $product)
    {
        $product->load([
            'category',
            'brand',
            'images',
        ]);

        return view(
            'admin.products.show',
            compact('product')
        );
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
            new CreateProductData(
                categoryId: $request->integer('category_id'),
                brandId: $request->integer('brand_id'),
                name: $request->string('name')->value(),
                description: $request->input('description'),
                price: (float) $request->input('price'),
                salePrice: $request->filled('sale_price')
                    ? (float) $request->input('sale_price')
                    : null,
                quantity: $request->integer('quantity'),
                status: $request->boolean('status'),
                featured: $request->boolean('featured'),
                sortOrder: $request->integer('sort_order', 0),
                images: $request->file('images', []),
            )
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
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->productService->update(
            $product,
            new UpdateProductData(
                categoryId: $request->integer('category_id'),
                brandId: $request->integer('brand_id'),
                name: $request->string('name')->value(),
                description: $request->input('description'),
                price: (float) $request->input('price'),
                salePrice: $request->filled('sale_price')
                    ? (float) $request->input('sale_price')
                    : null,
                quantity: $request->integer('quantity'),
                status: $request->boolean('status'),
                featured: $request->boolean('featured'),
                sortOrder: $request->integer('sort_order', 0),
                images: $request->file('images', []),
            )
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
