@extends('admin.layouts.app')

@section('title','Edit Address')

@section('page-title','Edit Address')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h3 class="fw-bold">

            Edit Address

        </h3>

        <p class="text-muted">

            Update your shipping address.

        </p>

    </div>

    <form action="{{ route('addresses.update',$address) }}" method="POST">

        @csrf

        @method('PUT')

        @include('web.addresses._form')

    </form>

</div>

@endsection
