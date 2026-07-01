@php
use Illuminate\Support\Str;
@endphp

<div class="border rounded p-4 mb-4">

    @if($message->replyTo)

        <div class="border-l-4 border-gray-400 bg-gray-50 pl-3 py-2 mb-3">

            <div class="text-sm font-semibold">
                ↩ {{ $message->replyTo->sender->name }}
            </div>

            <div class="text-sm text-gray-600">
                {{ \Illuminate\Support\Str::limit($message->replyTo->message, 80) }}
            </div>

        </div>

    @endif

    <div class="flex justify-between">

        <strong>
            {{ $message->sender->role->name }}
            {{ $message->sender->name }}
        </strong>

        <small>
            {{ $message->created_at->format('d M Y H:i') }}
        </small>

    </div>

    <hr class="my-2">

    <div>
        {{ $message->message }}
    </div>

    <div class="mt-3">
        <button
            type="button"
            class="reply-btn text-sm text-blue-600"
            data-id="{{ $message->id }}"
            data-author="{{ $message->sender->name }}"
            data-message="{{ \Illuminate\Support\Str::limit($message->message, 80) }}"
        >
            Reply
        </button>
    </div>

</div>