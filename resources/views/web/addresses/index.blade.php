@extends('admin.layouts.app')

@section('title', 'My Addresses')

@section('page-title', 'My Addresses')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                My Addresses

            </h3>

            <p class="text-muted mb-0">

                Manage your shipping addresses

            </p>

        </div>

        <a href="{{ route('addresses.create') }}" class="btn btn-primary">

            <i class="bi bi-plus-circle me-2"></i>

            Add Address

        </a>

    </div>

    <div class="row">

        @forelse($addresses as $address)

        <div class="col-lg-6 col-xl-4 mb-4">

            @include('web.partials.card-address')

        </div>

        @empty

        <div class="col-12">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center py-5">

                    <i class="bi bi-geo-alt display-3 text-muted"></i>

                    <h4 class="mt-3">

                        No Addresses Yet

                    </h4>

                    <p class="text-muted">

                        Add your first shipping address.

                    </p>

                    <a href="{{ route('addresses.create') }}" class="btn btn-primary">

                        <i class="bi bi-plus-circle me-2"></i>

                        Add Address

                    </a>

                </div>

            </div>

        </div>

        @endforelse

    </div>

    @if($addresses->hasPages())

    <div class="mt-4">

        {{ $addresses->links() }}

    </div>

    @endif

</div>

@endsection
