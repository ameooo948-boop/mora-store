<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\StockMovementType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StockMovement\IndexStockMovementRequest;
use App\Http\Resources\StockMovementResource;
use App\Services\StockMovementService;

class StockMovementController extends Controller
{
    public function __construct(
        protected StockMovementService $service,
    ) {}

    public function index(IndexStockMovementRequest $request)
    {
        $movements = $this->service->paginate(
            search: $request->search,
            type: $request->filled('type') ? StockMovementType::tryFrom($request->type) : null,
        );

        return response()->json([
            'movements' => StockMovementResource::collection($movements),
            'meta' => [
                'current_page' => $movements->currentPage(),
                'last_page' => $movements->lastPage(),
                'total' => $movements->total(),
            ],
            'statistics' => $this->service->statistics(),
            'types' => StockMovementType::cases(),
        ]);
    }

    public function show(int $id)
    {
        $movement = $this->service->find($id);

        abort_if(! $movement, 404);

        return response()->json([
            'movement' => new StockMovementResource($movement),
        ]);
    }
}
