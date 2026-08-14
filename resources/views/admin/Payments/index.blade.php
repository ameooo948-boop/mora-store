@extends('admin.layouts.app')

@section('title', 'Payments')
@section('page-title', 'Payments')

@section('content')

<div class="payments-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="payments-header">

        <div>

            <span class="payments-eyebrow">
                FINANCIAL MANAGEMENT
            </span>

            <h1>
                Payments
            </h1>

            <p>
                Monitor and manage all payment transactions.
            </p>

        </div>


        <div class="payments-header-icon">

            <i class="bi bi-credit-card-2-front-fill"></i>

        </div>

    </div>


    {{-- =====================================================
         PAYMENTS CARD
    ====================================================== --}}

    <div class="payments-panel">

        {{-- Toolbar --}}

        <div class="payments-toolbar">

            <div class="payments-toolbar-title">

                <div class="payments-title-icon">

                    <i class="bi bi-receipt-cutoff"></i>

                </div>

                <div>

                    <h3>
                        Payment Transactions
                    </h3>

                    <span>
                        All recorded payments
                    </span>

                </div>

            </div>


            <form method="GET" class="payments-search">

                <i class="bi bi-search"></i>

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search payments...">

                @if(request('search'))

                <a href="{{ route('admin.payments.index') }}" class="payments-search-clear" title="Clear search">
                    <i class="bi bi-x"></i>
                </a>

                @endif

            </form>

        </div>


        {{-- =================================================
             TABLE
        ================================================== --}}

        <div class="table-responsive">

            <table class="table payments-table align-middle mb-0">

                <thead>

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Order
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Amount
                        </th>

                        <th>
                            Method
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Paid At
                        </th>

                        <th class="text-end">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($payments as $payment)

                    <tr>

                        {{-- ID --}}

                        <td>

                            <span class="payment-id">
                                #{{ $payment->id }}
                            </span>

                        </td>


                        {{-- ORDER --}}

                        <td>

                            <a href="{{ route('admin.orders.show', $payment->order) }}" class="payment-order-link">

                                <i class="bi bi-box-seam"></i>

                                {{ $payment->order->order_number }}

                            </a>

                        </td>


                        {{-- CUSTOMER --}}

                        <td>

                            <div class="payment-customer-cell">

                                <div class="payment-customer-avatar">

                                    {{ strtoupper(
                                        substr($payment->order->user->name, 0, 1)
                                    ) }}

                                </div>

                                <div>

                                    <strong>
                                        {{ $payment->order->user->name }}
                                    </strong>

                                    <span>
                                        {{ $payment->order->user->email }}
                                    </span>

                                </div>

                            </div>

                        </td>


                        {{-- AMOUNT --}}

                        <td>

                            <div class="payment-amount">

                                {{ number_format($payment->amount, 2) }}

                            </div>

                        </td>


                        {{-- METHOD --}}

                        <td>

                            <span class="payment-method">

                                <i class="bi bi-wallet2"></i>

                                {{ $payment->payment_method->label() }}

                            </span>

                        </td>


                        {{-- STATUS --}}

                        <td>

                            <span class="payment-status-badge bg-{{ $payment->status->badge() }}">

                                <i class="bi bi-circle-fill"></i>

                                {{ $payment->status->label() }}

                            </span>

                        </td>


                        {{-- PAID AT --}}

                        <td>

                            @if($payment->paid_at)

                            <div class="payment-date">

                                <strong>
                                    {{ $payment->paid_at->format('M d, Y') }}
                                </strong>

                                <span>
                                    {{ $payment->paid_at->format('h:i A') }}
                                </span>

                            </div>

                            @else

                            <span class="payment-not-paid">
                                Not paid
                            </span>

                            @endif

                        </td>


                        {{-- ACTION --}}

                        <td class="text-end">

                            <a href="{{ route('admin.payments.show', $payment) }}" class="payment-view-btn" title="View Payment">

                                <i class="bi bi-arrow-up-right"></i>

                                <span>
                                    View
                                </span>

                            </a>

                        </td>

                    </tr>


                    @empty

                    <tr>

                        <td colspan="8">

                            <div class="payments-empty">

                                <div class="payments-empty-icon">

                                    <i class="bi bi-credit-card-2-back"></i>

                                </div>

                                <h4>
                                    No Payments Found
                                </h4>

                                <p>
                                    There are no payment transactions matching your search.
                                </p>

                                @if(request('search'))

                                <a href="{{ route('admin.payments.index') }}" class="payments-empty-btn">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                    Clear Search
                                </a>

                                @endif

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =================================================
             FOOTER / PAGINATION
        ================================================== --}}

        @if($payments->hasPages())

        <div class="payments-footer">

            <div class="payments-results">

                Showing

                <strong>
                    {{ $payments->firstItem() }}
                </strong>

                to

                <strong>
                    {{ $payments->lastItem() }}
                </strong>

                of

                <strong>
                    {{ $payments->total() }}
                </strong>

                payments

            </div>


            <div class="payments-pagination">

                {{ $payments->appends(request()->query())->links() }}

            </div>

        </div>

        @endif

    </div>

</div>

@endsection
