@extends('web.layouts.app')

@section('title', 'Notifications')

@section('content')

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                Notifications

            </h3>

            <p class="text-muted mb-0">

                View all your notifications.

            </p>

        </div>

        @if($notifications->whereNull('read_at')->count())

        <form action="{{ route('notifications.read-all') }}" method="POST">

            @csrf

            @method('PATCH')

            <button class="btn btn-outline-primary">

                <i class="bi bi-check2-all me-2"></i>

                Mark All As Read

            </button>

        </form>

        @endif

    </div>

    <div class="card border-0 shadow-sm">

        <div class="list-group list-group-flush">

            @forelse($notifications as $notification)

            <div class="list-group-item py-3">

                <div class="d-flex justify-content-between align-items-start">

                    <div class="d-flex">

                        <div class="me-3">

                            <i class="bi {{ $notification->data['icon'] }} fs-3 text-primary"></i>

                        </div>

                        <div>

                            <h6 class="mb-1">

                                {{ $notification->data['title'] }}

                            </h6>

                            <p class="mb-1 text-muted">

                                {{ $notification->data['message'] }}

                            </p>

                            <small class="text-secondary">

                                {{ $notification->created_at->diffForHumans() }}

                            </small>

                        </div>

                    </div>

                    <div class="text-end">
                        @if(is_null($notification->read_at))

                        <span class="badge bg-primary mb-2">

                            New

                        </span>

                        <form action="{{ route('notifications.read',$notification->id) }}" method="POST">

                            @csrf

                            @method('PATCH')

                            <button class="btn btn-sm btn-outline-secondary">

                                Mark Read

                            </button>

                        </form>

                        @endif

                        @if(!empty($notification->data['url']))

                        <a href="{{ $notification->data['url'] }}" class="btn btn-sm btn-link mt-2">

                            View

                        </a>

                        @endif

                    </div>

                </div>

            </div>

            @empty

            <div class="text-center py-5">

                <i class="bi bi-bell display-4 text-secondary"></i>

                <h5 class="mt-3">

                    No Notifications

                </h5>

                <p class="text-muted mb-0">

                    You don't have any notifications yet.

                </p>

            </div>

            @endforelse
        </div>

        @if($notifications instanceof \Illuminate\Contracts\Pagination\Paginator)

        <div class="card-footer">

            {{ $notifications->links() }}

        </div>

        @endif

    </div>

</div>

@endsection
