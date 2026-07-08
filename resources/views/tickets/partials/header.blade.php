<div class="mb-6">

    <h1 class="text-2xl font-bold">

        {{ $ticket->ticket_number }}

    </h1>

    <div class="border rounded p-4 mt-4">

        <p><strong>Title :</strong> {{ $ticket->title }}</p>
        

        <p><strong>Status :</strong> {{ $ticket->status }}</p>

        <p><strong>Category :</strong> {{ $ticket->category->name }}</p>

        <p><strong>Priority :</strong> {{ $ticket->priority->name }}</p>

        <p><strong>Department :</strong> {{ $ticket->currentDepartment->name }}</p>
        @if(
    auth()->user()->role->name === 'AGENT' &&
    $ticket->status === 'IN_PROGRESS' &&
    $ticket->current_handler_id === auth()->id()
)

    <form
        method="POST"
        action="{{ route('agent.tickets.resolve', $ticket) }}"
        class="mt-4"
        onsubmit="return confirm('Resolve this ticket?')"
    >

        @csrf
        @method('PATCH')

        <button
            type="submit"
            class="bg-green-600 text-white px-4 py-2 rounded"
        >
            Resolve Ticket
        </button>

    </form>

@endif

@if(
    auth()->user()->role->name === 'USER' &&
    $ticket->status === 'RESOLVED'
)

<div class="mt-4 flex gap-3">

    <form
        method="POST"
        action="{{ route('user.tickets.reopen', $ticket) }}"
        onsubmit="return confirm('Reopen this ticket?')"
    >

        @csrf
        @method('PATCH')

        <button
            type="submit"
            class="bg-yellow-500 text-white px-4 py-2 rounded"
        >
            Reopen Ticket
        </button>

    </form>

    <form
        method="POST"
        action="{{ route('user.tickets.close', $ticket) }}"
        onsubmit="return confirm('Close this ticket? This action cannot be undone.')"
    >

        @csrf
        @method('PATCH')

        <button
            type="submit"
            class="bg-red-600 text-white px-4 py-2 rounded"
        >
            Close Ticket
        </button>

    </form>

</div>

@endif

    </div>

</div>