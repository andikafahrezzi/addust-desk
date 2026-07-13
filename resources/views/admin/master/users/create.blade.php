@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">

    Create User

</h1>

<form
    action="{{ route('admin.users.store') }}"
    method="POST"
>

    @csrf

    @include('admin.master.users._form')

    <div class="mt-5">

        <label class="block mb-2 font-medium">

            Password

        </label>

        <input
            type="password"
            name="password"
            class="w-full border rounded px-3 py-2"
            required
        >

    </div>

    <div class="mt-5">

        <label class="block mb-2 font-medium">

            Confirm Password

        </label>

        <input
            type="password"
            name="password_confirmation"
            class="w-full border rounded px-3 py-2"
            required
        >

    </div>

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