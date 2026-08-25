<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Services\ProductImageService;

class ProductImageController extends Controller
{
    public function __construct(
        private readonly ProductImageService $productImageService,
    ) {}

    public function destroy(ProductImage $productImage)
    {
        if (! $this->productImageService->delete($productImage)) {
            return back()->with(
                'error',
                'Product must have at least one image.'
            );
        }

        return back()->with(
            'success',
            'Image deleted successfully.'
        );
    }
}
