<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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

                'averageRating' => $this->reviewService
                    ->averageRating($product),

                'reviewsCount' => $this->reviewService
                    ->reviewsCount($product),

                'reviews' => $this->reviewService
                    ->approvedByProduct($product),

                'userReview' => Auth::check()
                    ? $this->reviewService->findByUser(
                        $product,
                        Auth::user()
                    )
                    : null,

                'canReview' => Auth::check()
                    ? $this->reviewService->canReview(
                        $product,
                        Auth::user()
                    )
                    : false,
            ]
        );
    }
}
