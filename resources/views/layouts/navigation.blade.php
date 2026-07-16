@if ($tickets->isEmpty())

    <div class="text-center py-8">

        <p class="text-gray-500">

            {{ $isClosed
                ? 'No closed tickets found.'
                : 'No tickets found.' }}

        </p>

    </div>

@endif