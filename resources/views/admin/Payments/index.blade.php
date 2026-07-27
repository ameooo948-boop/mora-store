@extends('admin.layouts.app')

@section('title', 'Payments')

@section('content')

<div class="card">

    <div class="card-header">

        <div class="d-flex justify-content-between align-items-center">

            <h3 class="card-title mb-0">
                Payments
            </h3>

            <form method="GET" class="d-flex">

                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search...">

            </form>

        </div>

    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Order</th>

                        <th>Customer</th>

                        <th>Amount</th>

                        <th>Method</th>

                        <th>Status</th>

                        <th>Paid At</th>

                        <th class="text-end">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($payments as $payment)

                    <tr>

                        <td>{{ $payment->id }}</td>

                        <td>
                            #{{ $payment->order->id }}
                        </td>

                        <td>

                            <div class="fw-semibold">
                                {{ $payment->order->user->name }}
                            </div>

                            <small class="text-muted">
                                {{ $payment->order->user->email }}
                            </small>

                        </td>

                        <td>

                            {{ number_format($payment->amount,2) }}

                        </td>

                        <td>

                            <span class="badge bg-{{ $payment->payment_method->badge() }}">
                                {{ $payment->payment_method->label() }}
                            </span>

                        </td>

                        <td>

                            <span class="badge bg-{{ $payment->status->badge() }}">
                                {{ $payment->status->label() }}
                            </span>

                        </td>

                        <td>

                            {{ $payment->paid_at?->format('Y-m-d H:i') ?? '-' }}

                        </td>

                        <td class="text-end">

                            <a href="{{ route('admin.payments.show',$payment) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8" class="text-center py-5">

                            No payments found.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    @if($payments->hasPages())

    <div class="card-footer">

        {{ $payments->links() }}

    </div>

    @endif

</div>

@endsection
