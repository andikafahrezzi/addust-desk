@php
    $eventMap = [
        'CREATED'    => ['icon' => 'plus',    'class' => 'bg-accent-tint text-accent'],
        'ACCEPTED'   => ['icon' => 'check',   'class' => 'bg-accent-tint text-accent'],
        'RESOLVED'   => ['icon' => 'check',   'class' => 'bg-status-resolved/10 text-status-resolved'],
        'REOPENED'   => ['icon' => 'inbox',   'class' => 'bg-status-reopened/10 text-status-reopened'],
        'ESCALATED'  => ['icon' => 'flag',    'class' => 'bg-status-progress/10 text-status-progress'],
        'REASSIGNED' => ['icon' => 'users',   'class' => 'bg-accent-tint text-accent'],
        'CLOSED'     => ['icon' => 'archive', 'class' => 'bg-slate-100 text-slate-500'],
    ];

    $events = $ticket->events->sortBy('created_at')->values();
@endphp

<div class="bg-white border border-border rounded-xl p-6">

    <h2 class="text-sm font-semibold text-slate-900 mb-5">
        Timeline
    </h2>

    @forelse($events as $event)

        @php($e = $eventMap[$event->event_type] ?? ['icon' => 'ticket', 'class' => 'bg-slate-100 text-slate-500'])

        <div class="relative pl-10 {{ !$loop->last ? 'pb-6' : '' }}">

            @unless($loop->last)
                <span class="absolute left-[15px] top-8 bottom-0 w-px bg-border"></span>
            @endunless

            <span class="absolute left-0 top-0 w-8 h-8 rounded-full flex items-center justify-center {{ $e['class'] }}">
                <x-icon :name="$e['icon']" class="w-4 h-4" />
            </span>

            <div class="flex items-start justify-between gap-3 flex-wrap">
                <p class="text-sm font-medium text-slate-900">
                    {{ ucwords(strtolower(str_replace('_', ' ', $event->event_type))) }}
                </p>
                <span class="text-xs text-slate-400 whitespace-nowrap">
                    {{ $event->created_at->format('d M Y H:i') }}
                </span>
            </div>

            @if($event->description)
                <p class="text-sm text-slate-600 mt-0.5">
                    {{ $event->description }}
                </p>
            @endif

            @if($event->performedBy)
                <p class="text-xs text-slate-400 mt-1">
                    by <span class="text-slate-500 font-medium">{{ $event->performedBy->name }}</span>
                </p>
            @endif

        </div>

    @empty

        <p class="text-sm text-slate-400">
            No activity yet.
        </p>

    @endforelse

</div>