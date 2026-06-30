@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">
    Create Ticket
</h1>

<form
    action="{{ route('user.tickets.store') }}"
    method="POST"
>

    @csrf

    {{-- Title --}}

    <div class="mb-4">

        <label class="block font-semibold">
            Title
        </label>

        <input
            type="text"
            name="title"
            value="{{ old('title') }}"
            class="border rounded w-full p-2"
        >

        @error('title')
            <p class="text-red-500">
                {{ $message }}
            </p>
        @enderror

    </div>

    {{-- Category --}}

    <div class="mb-4">

        <label class="block font-semibold">
            Category
        </label>

        <select
            name="category_id"
            class="border rounded w-full p-2"
        >

            <option value="">
                -- Select Category --
            </option>

            @foreach($categories as $category)

                <option
                    value="{{ $category->id }}"
                    @selected(old('category_id') == $category->id)
                >
                    {{ $category->name }}
                </option>

            @endforeach

        </select>

        @error('category_id')
            <p class="text-red-500">
                {{ $message }}
            </p>
        @enderror

    </div>

    {{-- Priority --}}

    <div class="mb-4">

        <label class="block font-semibold">
            Priority
        </label>

        <select
            name="priority_id"
            class="border rounded w-full p-2"
        >

            <option value="">
                -- Select Priority --
            </option>

            @foreach($priorities as $priority)

                <option
                    value="{{ $priority->id }}"
                    @selected(old('priority_id') == $priority->id)
                >
                    {{ $priority->name }}
                </option>

            @endforeach

        </select>

        @error('priority_id')
            <p class="text-red-500">
                {{ $message }}
            </p>
        @enderror

    </div>

    {{-- Description --}}

    <div class="mb-6">

        <label class="block font-semibold">
            Description
        </label>

        <textarea
            name="description"
            rows="6"
            class="border rounded w-full p-2"
        >{{ old('description') }}</textarea>

        @error('description')
            <p class="text-red-500">
                {{ $message }}
            </p>
        @enderror

    </div>

    <button
        type="submit"
        class="bg-blue-600 text-white px-5 py-2 rounded"
    >
        Create Ticket
    </button>

</form>

@endsection