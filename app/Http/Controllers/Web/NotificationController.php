<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(
        protected NotificationService $service,
    ) {}

    public function index(
        Request $request,
    ) {
        return view(

            'web.notifications.index',

            [

                'notifications' => $this->service->paginate(

                    $request->user()

                ),

            ]

        );
    }
    public function read(
        Request $request,
        string $id,
    ) {

        $this->service->markAsRead(

            $request->user(),

            $id

        );

        return back();
    }

    public function readAll(
        Request $request,
    ) {

        $this->service->markAllAsRead(

            $request->user()

        );

        return back();
    }
}
