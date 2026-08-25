<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(
        protected NotificationService $service,
    ) {}

    public function index(Request $request)
    {
        $notifications = $this->service->paginate($request->user());

        return response()->json([
            'notifications' => $notifications,
            'meta' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'total' => $notifications->total(),
            ],
        ]);
    }

    public function read(Request $request, string $id)
    {
        $this->service->markAsRead($request->user(), $id);

        return response()->json([
            'message' => 'Notification marked as read.',
        ]);
    }

    public function readAll(Request $request)
    {
        $this->service->markAllAsRead($request->user());

        return response()->json([
            'message' => 'All notifications marked as read.',
        ]);
    }
}
