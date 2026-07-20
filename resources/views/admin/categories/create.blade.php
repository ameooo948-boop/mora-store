@extends('admin.layouts.app')

@section('title', 'Create Category')

@section('page-title', 'Create Category')

@section('content')

<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">

  @csrf

  @include('admin.categories._form')

</form>ٍ

@endsection