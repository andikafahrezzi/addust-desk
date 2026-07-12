@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">

    Edit Category

</h1>

<form
    action="{{ route('admin.categories.update', $category) }}"
    method="POST"
>

    @csrf

    @method('PUT')

    @include('admin.master.categories._form')

</form>

@endsection