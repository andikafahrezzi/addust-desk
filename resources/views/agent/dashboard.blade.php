@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold">
    Agent Dashboard
</h1>

<p>
    Welcome {{ auth()->user()->name }}
</p>

@endsection