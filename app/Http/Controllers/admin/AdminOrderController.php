<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderStatusRequest;
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

        $statuses = OrderStatus::cases();
        $statistics = $this->service->getStatisticsAdmin();
        $orders = $this->service->paginateAdmin(
            $request->search,
            $status,
        );

        return view(
            'admin.orders.index',
            compact('orders', 'statistics', 'statuses')
        );
    }

    public function show(int $id)
    {
        $order = $this->service->findForAdmin($id);

        abort_if(! $order, 404);

        $availableStatuses = $order->status->transitions();

        return view(
            'admin.orders.show',
            compact(
                'order',
                'availableStatuses'
            )
        );
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

            return back()->with(
                'success',
                'Order status updated successfully.'
            );
        } catch (DomainException $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
}
