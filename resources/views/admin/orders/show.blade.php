@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('page-title', 'Order Details')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                Order {{ $order->order_number }}

            </h3>

            <small class="text-muted">

                {{ $order->formatted_date }}

            </small>

        </div>

        <span class="badge {{ $order->status_badge }} fs-6">

            {{ $order->status_label }}

        </span>

    </div>

    <div class="row">

        <div class="col-lg-8">

            {{-- Products --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Products

                    </h5>

                </div>

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead>

                            <tr>

                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($order->items as $item)

                            <tr>

                                <td>

                                    {{ $item->product->name }}

                                </td>

                                <td>

                                    {{ number_format($item->price,2) }}

                                </td>

                                <td>

                                    {{ $item->quantity }}

                                </td>

                                <td>

                                    {{ number_format($item->total,2) }}

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            {{-- Customer --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    Customer

                </div>

                <div class="card-body">

                    <strong>

                        {{ $order->user->name }}

                    </strong>

                    <br>

                    {{ $order->user->email }}

                </div>

            </div>

            {{-- Shipping --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-header bg-white">

                    Shipping Address

                </div>

                <div class="card-body">

                    {{ $order->shipping_name }}

                    <br>

                    {{ $order->shipping_phone }}

                    <hr>

                    {{ $order->shipping_country }}

                    <br>

                    {{ $order->shipping_state }}

                    <br>

                    {{ $order->shipping_city }}

                    <br>

                    {{ $order->shipping_address }}

                    <br>

                    {{ $order->shipping_postal_code }}

                </div>

            </div>

            {{-- Summary --}}
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    Summary

                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <span>Subtotal</span>

                        <span>{{ number_format($order->subtotal,2) }}</span>

                    </div>

                    <div class="d-flex justify-content-between">

                        <span>Shipping</span>

                        <span>{{ number_format($order->shipping,2) }}</span>

                    </div>

                    <div class="d-flex justify-content-between">

                        <span>Discount</span>

                        <span>{{ number_format($order->discount,2) }}</span>

                    </div>

                    <hr>

                    <div class="d-flex justify-content-between fw-bold">

                        <span>Total</span>

                        <span>{{ number_format($order->total,2) }}</span>

                    </div>

                </div>

            </div>

            @if(count($availableStatuses))

            <form action="{{ route('admin.orders.status', $order) }}" method="POST">

                @csrf
                @method('PATCH')

                <div class="mb-3">

                    <select name="status" class="form-select">

                        @foreach($availableStatuses as $status)

                        <option value="{{ $status->value }}">

                            {{ $status->label() }}

                        </option>

                        @endforeach

                    </select>

                </div>

                <button class="btn btn-primary w-100">

                    Update Status

                </button>

            </form>

            @else

            <div class="alert alert-info mb-0">

                This order has reached its final status.

            </div>

            @endif

        </div>

    </div>

</div>

@endsection
