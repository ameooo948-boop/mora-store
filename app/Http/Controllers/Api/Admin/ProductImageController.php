<?php

namespace App\Http\Controllers\Api\Admin;

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
            return response()->json([
                'message' => 'Product must have at least one image.',
            ], 422);
        }

        return response()->json([
            'message' => 'Image deleted successfully.',
        ]);
    }
}
