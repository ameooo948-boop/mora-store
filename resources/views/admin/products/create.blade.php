@extends('admin.layouts.app')

@section('title', 'Create Product')

@section('page-title', 'Create Product')

@section('content')

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">

    @csrf

    @include('admin.products._form')

</form>

@endsection
