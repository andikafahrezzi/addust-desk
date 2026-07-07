@php
use Illuminate\Support\Str;
@endphp

<div class="border rounded p-4 mb-4">

    @if($message->replyTo)

    <div class="border-l-4 border-gray-400 bg-gray-50 pl-3 py-2 mb-3">

        <div class="text-sm font-semibold">
            ↩ {{ $message->replyTo->sender->name }}
        </div>

        @if($message->replyTo->deleted_at)

            <div class="text-sm italic text-gray-500">
                This message has been deleted.
            </div>

        @else

            <div class="text-sm text-gray-600">
                {{ Str::limit($message->replyTo->message, 80) }}
            </div>

        @endif

    </div>

@endif
@if($message->attachments->isNotEmpty())

    <div class="mt-3 space-y-2">

        @foreach($message->attachments as $attachment)

            <div class="border rounded px-3 py-2">

<a
    href="{{ route($attachmentDownloadRouteName, $attachment) }}"
    class="text-blue-600 hover:underline"
>
    📎 {{ $attachment->original_name }}
</a>

            </div>

        @endforeach

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

    <div id="message-display-{{ $message->id }}">
    @if($message->deleted_at)

    <span class="italic text-gray-500">
        This message has been deleted.
    </span>

@else

    {{ $message->message }}

@endif

</div>
@if(!$message->deleted_at)
<div
    id="message-edit-{{ $message->id }}"
    class="hidden mt-2"
    >
    <form
        method="POST"
        action="{{ route($messageUpdateRouteName, $message) }}"
    >
        @csrf
        @method('PATCH')

        <textarea
            name="message"
            rows="4"
            class="w-full border rounded p-2"
        >{{ old('message', $message->message) }}</textarea>

        @error('message')
            <p class="text-red-500 text-sm mt-1">
                {{ $message }}
            </p>
        @enderror

        <div class="mt-2 flex gap-2">

            <button
                type="submit"
                class="bg-blue-600 text-white px-3 py-1 rounded"
            >
                Save
            </button>

            <button
                type="button"
                class="cancel-edit border px-3 py-1 rounded"
                data-id="{{ $message->id }}"
            >
                Cancel
            </button>

        </div>

    </form>
</div>
@endif
    @if(!$message->deleted_at)

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

@endif
@if(
    !$message->deleted_at &&
    auth()->id() === $message->sender_id &&
    $ticket->status !== 'CLOSED'
)
    <button
        type="button"
        class="edit-btn text-sm text-yellow-600 ml-3"
        data-id="{{ $message->id }}"
    >
        Edit
    </button>
@endif
@if(
    !$message->deleted_at &&
    auth()->id() === $message->sender_id &&
    $ticket->status !== 'CLOSED'
)

<form
    method="POST"
    action="{{ route($messageDeleteRouteName, $message) }}"
    class="inline"
    onsubmit="return confirm('Delete this message?')"
>

    @csrf
    @method('DELETE')

    <button
        type="submit"
        class="text-sm text-red-600 ml-3"
    >
        Delete
    </button>

</form>

@endif
</div>