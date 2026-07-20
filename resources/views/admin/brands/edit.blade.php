@extends('admin.layouts.app')

@section('title', 'Edit Brand')

@section('page-title', 'Edit Brand')

@section('content')

<form action="{{ route('admin.brands.update',$brand) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf

    @method('PUT')

    @include('admin.brands._form')

</form>

@endsection