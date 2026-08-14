@extends('web.layouts.app')

@section('title', 'Notifications')

@section('content')

<div class="notifications-page">

    <div class="container">

        {{-- =====================================================
            HEADER
        ====================================================== --}}

        <div class="notifications-header">

            <div class="notifications-header-content">

                <span class="notifications-eyebrow">
                    <i class="bi bi-bell-fill"></i>
                    ACCOUNT CENTER
                </span>

                <h1>
                    Notifications
                </h1>

                <p>
                    Stay up to date with your latest account activity.
                </p>

            </div>

            @if($notifications->whereNull('read_at')->count())

            <form action="{{ route('notifications.read-all') }}" method="POST">

                @csrf
                @method('PATCH')

                <button type="submit" class="mark-all-btn">

                    <i class="bi bi-check2-all"></i>

                    <span>
                        Mark All As Read
                    </span>

                </button>

            </form>

            @endif

        </div>


        {{-- =====================================================
            MAIN CARD
        ====================================================== --}}

        <section class="notifications-card">


            {{-- =================================================
                SUMMARY
            ================================================== --}}

            <div class="notifications-card-top">

                <div class="notifications-summary">

                    <div class="notifications-summary-icon">
                        <i class="bi bi-bell"></i>
                    </div>

                    <div class="notifications-summary-text">

                        <span>
                            YOUR ACTIVITY
                        </span>

                        <strong>
                            {{ $notifications->total() }}
                            {{ Str::plural('Notification', $notifications->total()) }}
                        </strong>

                    </div>

                </div>


                @if($notifications->whereNull('read_at')->count())

                <div class="unread-counter">

                    <span></span>

                    {{ $notifications->whereNull('read_at')->count() }}

                    unread

                </div>

                @else

                <div class="all-read-badge">

                    <i class="bi bi-check-circle-fill"></i>

                    All caught up

                </div>

                @endif

            </div>


            {{-- =================================================
                NOTIFICATIONS LIST
            ================================================== --}}

            <div class="notifications-list">

                @forelse($notifications as $notification)

                @php

                $isUnread = is_null($notification->read_at);

                $icon = $notification->data['icon'] ?? 'bi-bell';

                $title = $notification->data['title'] ?? 'Notification';

                $message = $notification->data['message'] ?? '';

                $url = $notification->data['url'] ?? null;

                @endphp


                <article class="notification-item {{ $isUnread ? 'is-unread' : '' }}">


                    {{-- Unread Indicator --}}

                    @if($isUnread)

                    <span class="notification-unread-dot"></span>

                    @endif


                    {{-- Icon --}}

                    <div class="notification-icon">

                        <i class="bi {{ $icon }}"></i>

                    </div>


                    {{-- Content --}}

                    <div class="notification-content">

                        <div class="notification-title-row">

                            <h2>
                                {{ $title }}
                            </h2>

                            @if($isUnread)

                            <span class="notification-new">
                                New
                            </span>

                            @endif

                        </div>


                        @if($message)

                        <p>
                            {{ $message }}
                        </p>

                        @endif


                        <div class="notification-meta">

                            <span>

                                <i class="bi bi-clock"></i>

                                {{ $notification->created_at->diffForHumans() }}

                            </span>

                            <span class="notification-meta-separator">
                                •
                            </span>

                            <span>

                                {{ $notification->created_at->format('d M Y') }}

                            </span>

                        </div>

                    </div>


                    {{-- Actions --}}

                    <div class="notification-actions">

                        @if($url)

                        <a href="{{ $url }}" class="notification-view-btn">

                            <span>
                                View
                            </span>

                            <i class="bi bi-arrow-up-right"></i>

                        </a>

                        @endif


                        @if($isUnread)

                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">

                            @csrf
                            @method('PATCH')

                            <button type="submit" class="notification-read-btn" title="Mark as read">

                                <i class="bi bi-check2"></i>

                                <span>
                                    Mark Read
                                </span>

                            </button>

                        </form>

                        @else

                        <span class="notification-read-status">

                            <i class="bi bi-check2-circle"></i>

                            Read

                        </span>

                        @endif

                    </div>

                </article>


                @empty


                {{-- =================================================
                    EMPTY STATE
                ================================================== --}}

                <div class="notifications-empty">

                    <div class="notifications-empty-icon">

                        <i class="bi bi-bell-slash"></i>

                    </div>

                    <span>
                        ALL QUIET
                    </span>

                    <h2>
                        No Notifications
                    </h2>

                    <p>
                        You don't have any notifications yet.
                        We'll let you know when something important happens.
                    </p>

                </div>

                @endforelse

            </div>


            {{-- =================================================
                PAGINATION
            ================================================== --}}

            @if($notifications instanceof \Illuminate\Contracts\Pagination\Paginator)

            <div class="notifications-pagination">

                {{ $notifications->links() }}

            </div>

            @endif

        </section>

    </div>

</div>

@endsection
