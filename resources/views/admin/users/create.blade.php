@extends('admin.layouts.app')

@section('title', 'Create User')

@section('content')

<form
    action="{{ route('admin.users.store') }}"
    method="POST">

    @csrf

    @include('admin.users._form')

</form>

@endsection