@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">

    Edit User

</h1>

<form
    action="{{ route('admin.users.update', $user) }}"
    method="POST"
>

    @csrf

    @method('PUT')

    @include('admin.master.users._form')

    <div class="flex gap-3 mt-6">

        <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded"
        >

            Save

        </button>

        <a
            href="{{ route('admin.users.index') }}"
            class="border px-4 py-2 rounded"
        >

            Cancel

        </a>

    </div>

</form>

@endsection