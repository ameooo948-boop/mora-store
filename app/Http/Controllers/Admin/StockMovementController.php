<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StockMovementType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StockMovement\IndexStockMovementRequest;
use App\Services\StockMovementService;

class StockMovementController extends Controller
{
    public function __construct(
        protected StockMovementService $service,
    ) {}

    public function index(
        IndexStockMovementRequest $request,
    ) {

        return view(
            'admin.stock-movements.index',
            [

                'movements' => $this->service->paginate(

                    search: $request->search,

                    type: $request->filled('type')
                        ? StockMovementType::tryFrom(
                            $request->type
                        )
                        : null,

                ),

                'statistics' => $this->service->statistics(),

                'types' => StockMovementType::cases(),

            ]
        );
    }
    public function show(
        int $id,
    ) {

        $movement = $this->service->find($id);

        abort_if(
            ! $movement,
            404
        );

        return view(
            'admin.stock-movements.show',
            compact('movement')
        );
    }
}
