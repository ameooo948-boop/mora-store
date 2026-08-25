<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService,
    ) {}

    public function index(Request $request)
    {
        $user = $request->user();

        $orders = $this->orderService->getUserOrders($user);

        return response()->json([
            'orders' => OrderResource::collection($orders),
            'statistics' => $this->orderService->getStatistics($user),
        ]);
    }

    public function show(Request $request, Order $order)
    {
        $order = $this->orderService->findUserOrder($request->user(), $order->id);

        abort_if(! $order, 404);

        return response()->json([
            'order' => new OrderResource($order),
        ]);
    }
}
