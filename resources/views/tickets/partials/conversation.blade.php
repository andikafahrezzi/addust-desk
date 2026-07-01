<h2 class="text-xl font-semibold mb-4">

    Conversation

</h2>

@forelse($messages as $message)

    @include(
        'tickets.partials.message',
        [
            'message' => $message
        ]
    )

@empty

    @include(
        'tickets.partials.empty'
    )

@endforelse

<div class="mt-6">

    {{ $messages->links() }}

</div>