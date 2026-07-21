@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('page-title', 'Edit Product')

@section('content')


<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">

    @csrf
    @method('PUT')

    @include('admin.products._form')

</form>

<form id="delete-image-form" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>



@endsection
