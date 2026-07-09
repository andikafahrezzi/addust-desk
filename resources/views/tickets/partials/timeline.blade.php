<h2 class="text-xl font-semibold mt-8 mb-4">

    Timeline

</h2>

<div class="border rounded">

@forelse(
    $ticket->events->sortBy('created_at')
    as $event
)

    <div class="border-b last:border-b-0 p-4">

        <div class="flex justify-between items-center">

            <div>

                <div class="font-medium">

                    {{ $event->description }}

                </div>

                @if($event->performedBy)

                    <div class="text-sm text-gray-500">

                        {{ $event->performedBy->name }}

                    </div>

                @endif

            </div>

            <small class="text-gray-500">

                {{ $event->created_at->format('d M Y H:i') }}

            </small>

        </div>

    </div>

@empty

    <div class="p-4 text-gray-500">

        No activity yet.

    </div>

@endforelse

</div>