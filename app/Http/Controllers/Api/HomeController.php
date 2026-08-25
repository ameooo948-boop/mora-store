<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;

class HomeController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
    ) {}

    public function index()
    {
        return response()->json([
            'products' => ProductResource::collection(
                $this->productService->latest()
            ),
        ]);
    }
}
