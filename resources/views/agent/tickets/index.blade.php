@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">

    Department Tickets

</h1>

@if($tickets->isEmpty())

    <div class="border rounded p-6">

        No tickets found.

    </div>

@else

<table class="w-full border-collapse">

    <thead>

        <tr class="border-b">

            <th class="text-left p-3">
                Ticket
            </th>

            <th class="text-left p-3">
                Title
            </th>

            <th class="text-left p-3">
                User
            </th>

            <th class="text-left p-3">
                Priority
            </th>

            <th class="text-left p-3">
                Status
            </th>

            <th class="text-left p-3">
                Handler
            </th>

            <th class="text-left p-3">
                Created
            </th>
            <th class="p-3">

                Action

            </th>

        </tr>

    </thead>

    <tbody>

    @foreach($tickets as $ticket)

        <tr class="border-b hover:bg-gray-50">

            <td class="p-3">

                {{ $ticket->ticket_number }}

            </td>

            <td class="p-3">

                {{ $ticket->title }}

            </td>

            <td class="p-3">

                {{ $ticket->creator->name }}

            </td>

            <td class="p-3">

                {{ $ticket->priority->name }}

            </td>

            <td class="p-3">

                {{ $ticket->status }}

            </td>

            <td class="p-3">

                {{ $ticket->currentHandler?->name ?? '-' }}

            </td>

            <td class="p-3">

                {{ $ticket->created_at->format('d M Y H:i') }}

            </td>
            <td class="p-3">

@if(
    $ticket->status === 'OPEN' &&
    $ticket->current_handler_id === null
)

<form
    method="POST"
    action="{{ route('agent.tickets.claim', $ticket) }}"
>
    @csrf
    @method('PATCH')

    <button
        class="bg-blue-600 text-white px-3 py-1 rounded"
    >
        Claim
    </button>

</form>

@elseif(
    $ticket->current_handler_id === auth()->id()
)

<a
    href="{{ route('agent.tickets.show', $ticket) }}"
    class="text-blue-600 hover:underline"
>
    Open
</a>

@else

<span class="text-gray-500">
    Assigned
</span>

@endif

</td>

        </tr>

    @endforeach

    </tbody>

</table>

<div class="mt-6">

    {{ $tickets->links() }}

</div>

@endif

@endsection