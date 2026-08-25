@extends('admin.layouts.app')

@section('title', 'Payment Details')
@section('page-title', 'Payment Details')

@section('content')

<div class="payment-details-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="payment-details-header">

        <div class="payment-heading">

            <a href="{{ route('admin.payments.index') }}" class="payment-back-btn" title="Back to Payments">
                <i class="bi bi-arrow-left"></i>
            </a>

            <div>

                <span class="payment-eyebrow">
                    PAYMENT DETAILS
                </span>

                <h1>
                    Payment #{{ $payment->id }}
                </h1>

                <div class="payment-meta">

                    <span>
                        <i class="bi bi-calendar3"></i>
                        {{ $payment->created_at->format('M d, Y h:i A') }}
                    </span>

                    @if($payment->transaction_id)

                    <span class="payment-dot"></span>

                    <span>
                        <i class="bi bi-upc-scan"></i>
                        {{ $payment->transaction_id }}
                    </span>

                    @endif

                </div>

            </div>

        </div>


        <div class="payment-header-status">

            <span class="payment-status bg-{{ $payment->status->badge() }}">

                <i class="bi bi-circle-fill"></i>

                {{ $payment->status->label() }}

            </span>

        </div>

    </div>


    {{-- =====================================================
         MAIN
    ====================================================== --}}

    <div class="row g-3">

        {{-- =================================================
             LEFT
        ================================================== --}}

        <div class="col-xl-8">


            {{-- =============================================
                 PAYMENT SUMMARY
            ============================================== --}}

            <div class="payment-panel mb-3">

                <div class="payment-panel-header">

                    <div class="payment-panel-title">

                        <div class="payment-panel-icon blue">
                            <i class="bi bi-credit-card-fill"></i>
                        </div>

                        <div>

                            <h3>
                                Payment Information
                            </h3>

                            <span>
                                Transaction and payment details
                            </span>

                        </div>

                    </div>

                </div>


                <div class="payment-info-grid">

                    <div class="payment-info-box amount">

                        <span>
                            Amount
                        </span>

                        <strong>
                            {{ number_format($payment->amount, 2) }}
                        </strong>

                    </div>


                    <div class="payment-info-box">

                        <span>
                            Payment Method
                        </span>

                        <strong>

                            <span class="payment-method-badge bg-{{ $payment->payment_method->badge() }}">

                                <i class="bi bi-wallet2"></i>

                                {{ $payment->payment_method->label() }}

                            </span>

                        </strong>

                    </div>


                    <div class="payment-info-box">

                        <span>
                            Payment Status
                        </span>

                        <strong>

                            <span class="payment-small-status bg-{{ $payment->status->badge() }}">

                                {{ $payment->status->label() }}

                            </span>

                        </strong>

                    </div>


                    <div class="payment-info-box">

                        <span>
                            Paid At
                        </span>

                        <strong>

                            {{ $payment->paid_at?->format('M d, Y') ?? '-' }}

                            @if($payment->paid_at)

                            <small>
                                {{ $payment->paid_at->format('h:i A') }}
                            </small>

                            @endif

                        </strong>

                    </div>

                </div>


                <div class="payment-transaction">

                    <div class="transaction-icon">
                        <i class="bi bi-fingerprint"></i>
                    </div>

                    <div>

                        <span>
                            Transaction ID
                        </span>

                        <strong>
                            {{ $payment->transaction_id ?? 'No transaction ID available' }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- =============================================
                 GATEWAY
            ============================================== --}}

            @if($payment->gateway_response)

            <div class="payment-panel mb-3">

                <div class="payment-panel-header">

                    <div class="payment-panel-title">

                        <div class="payment-panel-icon purple">
                            <i class="bi bi-hdd-network-fill"></i>
                        </div>

                        <div>

                            <h3>
                                Gateway Information
                            </h3>

                            <span>
                                Payment gateway response
                            </span>

                        </div>

                    </div>

                </div>


                <div class="gateway-grid">

                    <div class="gateway-item">

                        <span>
                            Session ID
                        </span>

                        <strong class="text-break">
                            {{ $payment->gateway_response['id'] ?? '-' }}
                        </strong>

                    </div>


                    <div class="gateway-item">

                        <span>
                            Currency
                        </span>

                        <strong>
                            {{ strtoupper($payment->gateway_response['currency'] ?? '-') }}
                        </strong>

                    </div>


                    <div class="gateway-item">

                        <span>
                            Gateway Status
                        </span>

                        <strong>
                            {{ ucfirst($payment->gateway_response['payment_status'] ?? '-') }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- RAW RESPONSE --}}

            <div class="payment-panel">

                <div class="payment-raw-header">

                    <div class="payment-panel-title">

                        <div class="payment-panel-icon dark">
                            <i class="bi bi-code-slash"></i>
                        </div>

                        <div>

                            <h3>
                                Gateway Response
                            </h3>

                            <span>
                                Raw response returned by the payment gateway
                            </span>

                        </div>

                    </div>


                    <button type="button" class="raw-toggle" data-bs-toggle="collapse" data-bs-target="#gatewayResponse" aria-expanded="false">

                        <i class="bi bi-chevron-down"></i>

                        View Response

                    </button>

                </div>


                <div id="gatewayResponse" class="collapse">

                    <div class="raw-response">

                        <pre>{{ json_encode(
    $payment->gateway_response,
    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
) }}</pre>

                    </div>

                </div>

            </div>

            @endif

        </div>


        {{-- =================================================
             RIGHT
        ================================================== --}}

        <div class="col-xl-4">


            {{-- =============================================
                 CUSTOMER
            ============================================== --}}

            <div class="payment-panel mb-3">

                <div class="payment-panel-header">

                    <div class="payment-panel-title">

                        <div class="payment-panel-icon green">
                            <i class="bi bi-person-fill"></i>
                        </div>

                        <div>

                            <h3>
                                Customer
                            </h3>

                            <span>
                                Customer information
                            </span>

                        </div>

                    </div>

                </div>


                <div class="payment-customer">

                    <div class="payment-avatar">

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

            </div>


            {{-- =============================================
                 ORDER
            ============================================== --}}

            <div class="payment-panel mb-3">

                <div class="payment-panel-header">

                    <div class="payment-panel-title">

                        <div class="payment-panel-icon orange">
                            <i class="bi bi-box-seam-fill"></i>
                        </div>

                        <div>

                            <h3>
                                Order
                            </h3>

                            <span>
                                Related order information
                            </span>

                        </div>

                    </div>

                </div>


                <div class="payment-order">

                    <div class="payment-order-row">

                        <span>
                            Order Number
                        </span>

                        <strong>
                            {{ $payment->order->order_number }}
                        </strong>

                    </div>


                    <div class="payment-order-row">

                        <span>
                            Order Total
                        </span>

                        <strong>
                            {{ number_format($payment->order->total, 2) }}
                        </strong>

                    </div>


                    <div class="payment-order-row">

                        <span>
                            Order Status
                        </span>

                        <span class="order-mini-status {{ $payment->order->status_badge }}">
                            {{ $payment->order->status_label }}
                        </span>

                    </div>


                    <div class="payment-order-divider"></div>


                    <a href="{{ route('admin.orders.show', $payment->order) }}" class="payment-view-order">

                        <i class="bi bi-arrow-up-right-square"></i>

                        View Order

                    </a>

                </div>

            </div>


            {{-- =============================================
                 PAYMENT TIMELINE
            ============================================== --}}

            <div class="payment-panel">

                <div class="payment-panel-header">

                    <div class="payment-panel-title">

                        <div class="payment-panel-icon indigo">
                            <i class="bi bi-clock-history"></i>
                        </div>

                        <div>

                            <h3>
                                Payment Timeline
                            </h3>

                            <span>
                                Payment activity
                            </span>

                        </div>

                    </div>

                </div>


                <div class="payment-timeline">

                    <div class="payment-timeline-item">

                        <div class="payment-timeline-dot">
                            <i class="bi bi-plus-lg"></i>
                        </div>

                        <div>

                            <strong>
                                Payment Created
                            </strong>

                            <span>
                                {{ $payment->created_at->format('M d, Y h:i A') }}
                            </span>

                        </div>

                    </div>


                    @if($payment->paid_at)

                    <div class="payment-timeline-item">

                        <div class="payment-timeline-dot success">
                            <i class="bi bi-check-lg"></i>
                        </div>

                        <div>

                            <strong>
                                Payment Completed
                            </strong>

                            <span>
                                {{ $payment->paid_at->format('M d, Y h:i A') }}
                            </span>

                        </div>

                    </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
