<h2 class="text-xl font-semibold mt-8 mb-4">

    Timeline

</h2>

<div class="border rounded">

@forelse($ticket->events->sortBy('created_at') as $event)

<div class="border-b last:border-b-0 p-4">

    <div class="flex justify-between items-start">

        <div>

            <span
                class="inline-block px-2 py-1 rounded text-xs font-semibold
                @switch($event->event_type)
                    @case('CREATED')
                        bg-green-100 text-green-700
                        @break

                    @case('ACCEPTED')
                        bg-blue-100 text-blue-700
                        @break

                    @case('RESOLVED')
                        bg-emerald-100 text-emerald-700
                        @break

                    @case('REOPENED')
                        bg-yellow-100 text-yellow-700
                        @break

                    @case('ESCALATED')
                        bg-orange-100 text-orange-700
                        @break

                    @case('REASSIGNED')
                        bg-indigo-100 text-indigo-700
                        @break

                    @case('CLOSED')
                        bg-red-100 text-red-700
                        @break
                @endswitch
            ">

                {{ $event->event_type }}

            </span>

            <div class="mt-3">

                {{ $event->description }}

            </div>

            @if($event->performedBy)

                <div class="text-sm text-gray-500 mt-2">

                    By

                    <strong>

                        {{ $event->performedBy->name }}

                    </strong>

                </div>

            @endif

        </div>

        <small class="text-gray-500 whitespace-nowrap">

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