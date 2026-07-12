@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">

    Create Category

</h1>

<form
    action="{{ route('admin.categories.store') }}"
    method="POST"
>

    @csrf

    @include('admin.master.categories._form')

</form>

@endsection