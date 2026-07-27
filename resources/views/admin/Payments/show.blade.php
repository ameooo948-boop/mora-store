@extends('admin.layouts.app')

@section('title', 'Payment Details')

@section('page-title', 'Payment Details')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                Payment #{{ $payment->id }}

            </h3>

            <small class="text-muted">

                {{ $payment->created_at->format('Y-m-d H:i') }}

            </small>

        </div>

        <span class="badge bg-{{ $payment->status->badge() }} fs-6">

            {{ $payment->status->label() }}

        </span>

    </div>

    <div class="row">

        <div class="col-lg-8">

            {{-- Payment Information --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Payment Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">

                            Amount

                        </span>

                        <strong>

                            {{ number_format($payment->amount, 2) }}

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">

                            Payment Method

                        </span>

                        <span class="badge bg-{{ $payment->payment_method->badge() }}">

                            {{ $payment->payment_method->label() }}

                        </span>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">

                            Status

                        </span>

                        <span class="badge bg-{{ $payment->status->badge() }}">

                            {{ $payment->status->label() }}

                        </span>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">

                            Transaction ID

                        </span>

                        <strong class="text-break">

                            {{ $payment->transaction_id ?? '-' }}

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between">

                        <span class="text-muted">

                            Paid At

                        </span>

                        <strong>

                            {{ $payment->paid_at?->format('Y-m-d H:i') ?? '-' }}

                        </strong>

                    </div>

                </div>

            </div>

            @if($payment->gateway_response)

            {{-- Gateway Information --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Gateway Information

                    </h5>

                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">

                            Session ID

                        </span>

                        <strong class="text-break">

                            {{ $payment->gateway_response['id'] ?? '-' }}

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">

                            Currency

                        </span>

                        <strong>

                            {{ strtoupper($payment->gateway_response['currency'] ?? '-') }}

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between">

                        <span class="text-muted">

                            Payment Status

                        </span>

                        <strong>

                            {{ ucfirst($payment->gateway_response['payment_status'] ?? '-') }}

                        </strong>

                    </div>

                </div>

            </div>

            {{-- Raw Gateway Response --}}
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <button class="btn btn-link text-decoration-none p-0" data-bs-toggle="collapse" data-bs-target="#gatewayResponse">

                        View Raw Gateway Response

                    </button>

                </div>

                <div id="gatewayResponse" class="collapse">

                    <div class="card-body">

                        <pre class="mb-0 small">{{ json_encode($payment->gateway_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>

                    </div>

                </div>

            </div>

            @endif

        </div>

        <div class="col-lg-4">

            {{-- Customer --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    Customer

                </div>

                <div class="card-body">

                    <strong>

                        {{ $payment->order->user->name }}

                    </strong>

                    <br>

                    {{ $payment->order->user->email }}

                </div>

            </div>

            {{-- Order --}}
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    Order

                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-between mb-2">

                        <span>Order</span>

                        <strong>

                            {{ $payment->order->order_number }}

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-2">

                        <span>Total</span>

                        <strong>

                            {{ number_format($payment->order->total,2) }}

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-4">

                        <span>Status</span>

                        <span class="badge {{ $payment->order->status_badge }}">

                            {{ $payment->order->status_label }}

                        </span>

                    </div>

                    <a href="{{ route('admin.orders.show', $payment->order) }}" class="btn btn-primary w-100">

                        <i class="bi bi-box me-1"></i>

                        View Order

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
