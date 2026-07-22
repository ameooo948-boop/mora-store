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

    public function toggle(
        Request $request,
        Product $product
    ) {
        $added = $this->service->toggle(
            $request->user(),
            $product
        );

        return back()->with(
            'success',
            $added
                ? 'Product added to wishlist.'
                : 'Product removed from wishlist.'
        );
    }
}
