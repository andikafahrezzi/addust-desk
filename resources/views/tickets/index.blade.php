@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">

    <h1 class="text-2xl font-bold">
        My Tickets
    </h1>

    <a
        href="{{ route('user.tickets.create') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded"
    >
        + Create Ticket
    </a>

</div>

@if(session('success'))

    <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>

@endif

<table class="w-full border border-gray-300">

    <thead class="bg-gray-200">

        <tr>

            <th class="border p-2">Ticket Number</th>

            <th class="border p-2">Title</th>

            <th class="border p-2">Category</th>

            <th class="border p-2">Priority</th>

            <th class="border p-2">Status</th>

            <th class="border p-2">Department</th>

            <th class="border p-2">Created</th>

        </tr>

    </thead>

    <tbody>

    @forelse($tickets as $ticket)

        <tr>

            <td class="border p-2">

                <a
                    href="{{ route('user.tickets.show', $ticket) }}"
                    class="text-blue-600 hover:underline"
                >
                    {{ $ticket->ticket_number }}
                </a>

            </td>

            <td class="border p-2">

                {{ $ticket->title }}

            </td>

            <td class="border p-2">

                {{ $ticket->category->name }}

            </td>

            <td class="border p-2">

                {{ $ticket->priority->name }}

            </td>

            <td class="border p-2">

                {{ $ticket->status }}

            </td>

            <td class="border p-2">

                {{ $ticket->currentDepartment->name }}

            </td>

            <td class="border p-2">

                {{ $ticket->created_at->format('d M Y H:i') }}

            </td>

        </tr>

    @empty

        <tr>

            <td colspan="7" class="text-center p-4">

                No tickets found.

            </td>

        </tr>

    @endforelse

    </tbody>

</table>

<div class="mt-4">

    {{ $tickets->links() }}

</div>

@endsection