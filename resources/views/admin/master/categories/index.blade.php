@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">

    <h1 class="text-2xl font-bold">

        Categories

    </h1>

    <a
        href="{{ route('admin.categories.create') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded"
    >
        Create Category
    </a>

</div>

@if($categories->isEmpty())

<div class="border rounded p-6">

    No categories found.

</div>

@else

<table class="w-full border-collapse">

    <thead>

        <tr class="border-b">

            <th class="text-left p-3">
                Name
            </th>

            <th class="text-left p-3">
                Created
            </th>

            <th class="text-center p-3">
                Action
            </th>

        </tr>

    </thead>

    <tbody>

    @foreach($categories as $category)

        <tr class="border-b hover:bg-gray-50">

            <td class="p-3">

                {{ $category->name }}

            </td>

            <td class="p-3">

                {{ $category->created_at->format('d M Y H:i') }}

            </td>

            <td class="p-3 text-center">

                <a
                    href="{{ route('admin.categories.edit', $category) }}"
                    class="text-yellow-600 hover:underline"
                >
                    Edit
                </a>

                <form
                    action="{{ route('admin.categories.destroy', $category) }}"
                    method="POST"
                    class="inline"
                    onsubmit="return confirm('Delete this category?')"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="text-red-600 ml-3"
                    >
                        Delete
                    </button>

                </form>

            </td>

        </tr>

    @endforeach

    </tbody>

</table>

<div class="mt-6">

    {{ $categories->links() }}

</div>

@endif

@endsection