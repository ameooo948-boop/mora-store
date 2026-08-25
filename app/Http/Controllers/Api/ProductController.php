<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Services\CatalogService;
use App\Services\ReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(
        private readonly CatalogService $catalogService,
        private readonly ReviewService $reviewService,
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'category', 'brand', 'sort']);

        $products = $this->catalogService->products($filters);

        return response()->json([
            'products' => ProductResource::collection($products),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'total' => $products->total(),
            ],
            'categories' => CategoryResource::collection($this->catalogService->categories()),
            'brands' => BrandResource::collection($this->catalogService->brands()),
        ]);
    }

    public function show(Product $product)
    {
        $product = $this->catalogService->findProduct($product);

        $userReview = Auth::check()
            ? $this->reviewService->findByUser(
                $product,
                Auth::user()
            )
            : null;

        return response()->json([
            'product' => new ProductResource($product),

            'related_products' => ProductResource::collection(
                $this->catalogService->relatedProducts($product)
            ),

            'average_rating' => $this->reviewService->averageRating($product),

            'reviews_count' => $this->reviewService->reviewsCount($product),

            'reviews' => ReviewResource::collection(
                $this->reviewService->approvedByProduct($product)
            ),

            'user_review' => $userReview
                ? new ReviewResource($userReview)
                : null,

            'can_review' => Auth::check()
                ? $this->reviewService->canReview(
                    $product,
                    Auth::user()
                )
                : false,
        ]);
    }
}
