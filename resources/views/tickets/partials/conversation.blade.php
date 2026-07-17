<div class="bg-white border border-border rounded-xl p-6">

    <h2 class="text-sm font-semibold text-slate-900 mb-5">
        Conversation
    </h2>

    <div class="space-y-4">

        @forelse($messages as $message)

            @include(
                'tickets.partials.message',
                [
                    'message' => $message
                ]
            )

        @empty

            @include('tickets.partials.empty')

        @endforelse

    </div>

    @if($messages->hasPages())
        <div class="mt-6">
            {{ $messages->links() }}
        </div>
    @endif

</div>