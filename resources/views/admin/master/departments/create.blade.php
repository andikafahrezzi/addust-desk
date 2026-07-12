@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">

    Create Department

</h1>

<form
    action="{{ route('admin.departments.store') }}"
    method="POST"
>

    @csrf

    @include('admin.master.departments._form')

</form>

@endsection