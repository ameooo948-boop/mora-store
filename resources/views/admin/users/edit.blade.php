@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')

<form action="{{ route('admin.users.update', $user) }}" method="POST">

    @csrf

    @method('PUT')

    @include('admin.users._form')

</form>

@endsection
