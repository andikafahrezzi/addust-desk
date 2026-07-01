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

    </div>

</div>