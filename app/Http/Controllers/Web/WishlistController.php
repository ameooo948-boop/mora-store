<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
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
        $wishlists = $this->service->paginate(
            $request->user()
        );

        return view(
            'web.wishlist.index',
            compact('wishlists')
        );
    }

    public function toggle(Request $request, Product $product)
    {
        $attached = $this->service->toggle(
            $request->user(),
            $product
        );

        if ($request->expectsJson()) {

            return response()->json([

                'success' => true,

                'attached' => $attached,

                'message' => $attached
                    ? 'Added to wishlist.'
                    : 'Removed from wishlist.',

            ]);
        }

        return back();
    }
}
