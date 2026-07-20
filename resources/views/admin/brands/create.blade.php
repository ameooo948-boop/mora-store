@extends('admin.layouts.app')

@section('title', 'Create Brand')

@section('page-title', 'Create Brand')

@section('content')

<form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">

  @csrf

  @include('admin.brands._form')

</form>ٍ

@endsection