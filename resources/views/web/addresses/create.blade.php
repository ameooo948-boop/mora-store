@extends('admin.layouts.app')

@section('title','Add Address')

@section('page-title','Add Address')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h3 class="fw-bold">

            Add New Address

        </h3>

        <p class="text-muted">

            Create a new shipping address.

        </p>

    </div>

    <form action="{{ route('addresses.store') }}" method="POST">

        @csrf

        @include('web.addresses._form')

    </form>

</div>

@endsection
