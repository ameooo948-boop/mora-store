<?php

namespace App\Http\Controllers\Api\Admin;

use App\DTOs\Brand\CreateBrandData;
use App\DTOs\Brand\UpdateBrandData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Services\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct(
        private readonly BrandService $brandService,
    ) {}

    public function index(Request $request)
    {
        $status = $request->filled('status')
            ? (int) $request->status
            : null;

        $brands = $this->brandService->paginate(
            $status,
            $request->search,
        );

        return response()->json([
            'brands' => BrandResource::collection($brands),
            'meta' => [
                'current_page' => $brands->currentPage(),
                'last_page' => $brands->lastPage(),
                'total' => $brands->total(),
            ],
            'statistics' => $this->brandService->getStatistics(),
        ]);
    }

    public function show(Brand $brand)
    {
        $brand->loadCount('products');

        return response()->json([
            'brand' => new BrandResource($brand),
        ]);
    }

    public function store(StoreBrandRequest $request)
    {
        $brand = $this->brandService->create(
            new CreateBrandData(
                name: $request->string('name')->value(),
                description: $request->input('description'),
                logo: $request->file('logo'),
                status: $request->boolean('status'),
                sortOrder: $request->integer('sort_order', 0),
            )
        );

        return response()->json([
            'message' => 'Brand created successfully.',
            'brand' => new BrandResource($brand),
        ], 201);
    }

    public function update(
        UpdateBrandRequest $request,
        Brand $brand
    ) {
        $brand = $this->brandService->update(
            $brand,
            new UpdateBrandData(
                name: $request->string('name')->value(),
                description: $request->input('description'),
                logo: $request->file('logo'),
                status: $request->boolean('status'),
                sortOrder: $request->integer('sort_order', 0),
            )
        );

        return response()->json([
            'message' => 'Brand updated successfully.',
            'brand' => new BrandResource($brand),
        ]);
    }

    public function destroy(Brand $brand)
    {
        if (! $this->brandService->delete($brand)) {
            return response()->json([
                'message' => 'Cannot delete Brand because it contains products.',
            ], 422);
        }

        return response()->json([
            'message' => 'Brand deleted successfully.',
        ]);
    }
}