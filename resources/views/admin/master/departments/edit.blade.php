@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">

    Edit Department

</h1>

<form
    action="{{ route('admin.departments.update', $department) }}"
    method="POST"
>

    @csrf

    @method('PUT')

    @include('admin.master.departments._form')

</form>

@endsection