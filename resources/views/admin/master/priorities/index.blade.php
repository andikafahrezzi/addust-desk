@extends('layouts.app')

@section('content')

<div class="flex items-center justify-between mb-6">

    <h1 class="text-2xl font-bold">

        Priorities

    </h1>

    <a
        href="{{ route('admin.priorities.create') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded"
    >
        Create Priority
    </a>

</div>

@if($priorities->isEmpty())

<div class="border rounded p-6">

    No priorities found.

</div>

@else

<table class="w-full border-collapse">

    <thead>

        <tr class="border-b">

            <th class="text-left p-3">
                Name
            </th>

            <th class="text-left p-3">
                SLA Response Minutes
            </th>
            <th class="text-left p-3">
                SLA Resolution Minutes
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

    @foreach($priorities as $priority)

        <tr class="border-b hover:bg-gray-50">

            <td class="p-3">

                {{ $priority->name }}

            </td>

            <td class="p-3">

                {{ $priority->sla_response_minutes }}   

            </td>
            <td class="p-3">

                {{ $priority->sla_resolution_minutes }}   

            </td>
            <td class="p-3">

                {{ $priority->created_at->format('d M Y H:i') }}

            </td>

            <td class="p-3 text-center">

                <a
                    href="{{ route('admin.priorities.edit', $priority) }}"
                    class="text-yellow-600 hover:underline"
                >
                    Edit
                </a>

                <form
                    action="{{ route('admin.priorities.destroy', $priority) }}"
                    method="POST"
                    class="inline"
                    onsubmit="return confirm('Delete this priority?')"
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

    {{ $priorities->links() }}

</div>

@endif

@endsection