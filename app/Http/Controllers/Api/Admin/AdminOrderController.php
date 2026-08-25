<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderStatusRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use DomainException;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function __construct(
        private readonly OrderService $service
    ) {}

    public function index(Request $request)
    {
        $status = $request->filled('status')
            ? OrderStatus::tryFrom($request->status)
            : null;

        $orders = $this->service->paginateAdmin(
            $request->search,
            $status,
        );

        return response()->json([
            'orders' => OrderResource::collection($orders),
            'meta' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'total' => $orders->total(),
            ],
            'statistics' => $this->service->getStatisticsAdmin(),
            'statuses' => OrderStatus::cases(),
        ]);
    }

    public function show(int $id)
    {
        $order = $this->service->findForAdmin($id);

        abort_if(! $order, 404);

        return response()->json([
            'order' => new OrderResource($order),
            'available_statuses' => $order->status->transitions(),
        ]);
    }

    public function updateStatus(
        UpdateOrderStatusRequest $request,
        int $id
    ) {
        $order = $this->service->findForAdmin($id);

        abort_if(! $order, 404);

        try {
            $this->service->updateStatus(
                $order,
                OrderStatus::from($request->status)
            );

            return response()->json([
                'message' => 'Order status updated successfully.',
                'order' => new OrderResource($order->fresh()),
            ]);
        } catch (DomainException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}