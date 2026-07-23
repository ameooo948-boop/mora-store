<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderService $orderService,
    ) {}

    public function index(Request $request)
    {
        $user = $request->user();

        $orders = $this->orderService->getUserOrders($user);

        $statistics = $this->orderService->getStatistics($user);

        return view('web.orders.index', compact(
            'orders',
            'statistics'
        ));
    }

    public function show(Request $request, Order $order)
    {
        $order = $this->orderService
            ->findUserOrder($request->user(), $order->id);

        abort_if(!$order, 404);

        return view('web.orders.show', compact('order'));
    }
}
