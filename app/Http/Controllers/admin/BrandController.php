<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBrandRequest;
use App\Http\Requests\Admin\UpdateBrandRequest;
use App\Services\BrandService;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    public function __construct(
        private readonly BrandService $brandService,
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->filled('status')
            ? (int) $request->status
            : null;

        $brands = $this->brandService->paginate(
            $status,
            $request->search,
        );

        $statistics = $this->brandService->getStatistics();

        return view(
            'admin.brands.index',
            compact(
                'brands',
                'statistics',
            )
        );
    }

    public function show(Brand $brand)
    {
        $brand->loadCount('products');

        return view(
            'admin.brands.show',
            compact('brand')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $this->brandService->create($request->validated());
        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully.');
    }

    /**

     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {

        return view('admin.brands.edit', compact(
            'brand'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $this->brandService->update(
            $brand,
            $request->validated()
        );

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        if (! $this->brandService->delete($brand)) {
            return redirect()
                ->route('admin.brands.index')
                ->with('error', 'Cannot delete Brand because it contains products.');
        }

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Brand deleted successfully.');
    }
}
