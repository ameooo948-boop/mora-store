<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WishlistResource;
use App\Models\Product;
use App\Services\WishlistService;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct(
        private readonly WishlistService $service
    ) {}

    public function index(Request $request)
    {
        $wishlists = $this->service->paginate($request->user());

        return response()->json([
            'wishlists' => WishlistResource::collection($wishlists),
            'meta' => [
                'current_page' => $wishlists->currentPage(),
                'last_page' => $wishlists->lastPage(),
                'total' => $wishlists->total(),
            ],
        ]);
    }

    public function toggle(Request $request, Product $product)
    {
        $attached = $this->service->toggle($request->user(), $product);

        return response()->json([
            'attached' => $attached,
            'message' => $attached ? 'Added to wishlist.' : 'Removed from wishlist.',
        ]);
    }
}
