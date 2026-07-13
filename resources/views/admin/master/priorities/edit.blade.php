@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">

    Edit Priority

</h1>

<form
    action="{{ route('admin.priorities.update', $priority) }}"
    method="POST"
>

    @csrf

    @method('PUT')

    @include('admin.master.priorities._form')

</form>

@endsection