@if(!in_array($ticket->status, ['RESOLVED', 'CLOSED']))

<form
    method="POST"
    action="{{ route('user.tickets.messages.store', $ticket) }}"
>

    @csrf
<input
    type="hidden"
    name="parent_message_id"
    id="parent_message_id">
<div
    id="reply-preview"
    class="hidden border-l-4 border-blue-500 bg-blue-50 rounded p-3 mb-3"
>

    <div class="flex justify-between items-center">

        <div>

            <div
                id="reply-author"
                class="font-semibold text-sm"
            ></div>

            <div
                id="reply-message"
                class="text-sm text-gray-600"
            ></div>

        </div>

        <button
            type="button"
            id="cancel-reply"
            class="text-gray-500 hover:text-red-600"
        >
            ✕
        </button>

    </div>

</div>

    <textarea
        name="message"
        rows="5"
        class="w-full border rounded p-3"
        placeholder="Type your message..."
    >{{ old('message') }}</textarea>

    @error('message')
        <p class="text-red-500 text-sm mt-1">
            {{ $message }}
        </p>
    @enderror

    <div class="mt-3">
        <button
            class="bg-blue-600 text-white px-4 py-2 rounded"
        >
            Send
        </button>
    </div>

</form>

@else

<div class="border rounded p-3 bg-gray-100">

    This ticket has been closed.

</div>

@endif
<script>

document.querySelectorAll('.reply-btn').forEach(button => {

    button.addEventListener('click', function () {

        document
            .getElementById('parent_message_id')
            .value = this.dataset.id;

        document
            .getElementById('reply-author')
            .innerText = this.dataset.author;

        document
            .getElementById('reply-message')
            .innerText = this.dataset.message;

        document
            .getElementById('reply-preview')
            .classList.remove('hidden');

        document
            .querySelector('textarea[name="message"]')
            .focus();

    });

});

document
    .getElementById('cancel-reply')
    .addEventListener('click', function () {

        document
            .getElementById('parent_message_id')
            .value = '';

        document
            .getElementById('reply-preview')
            .classList.add('hidden');

    });

    document.querySelectorAll('.edit-btn').forEach(button => {

    button.addEventListener('click', function () {

        const id = this.dataset.id;

        document
            .getElementById('message-display-' + id)
            .classList.add('hidden');

        document
            .getElementById('message-edit-' + id)
            .classList.remove('hidden');

    });

});

document.querySelectorAll('.cancel-edit').forEach(button => {

    button.addEventListener('click', function () {

        const id = this.dataset.id;

        document
            .getElementById('message-display-' + id)
            .classList.remove('hidden');

        document
            .getElementById('message-edit-' + id)
            .classList.add('hidden');

    });

});

</script>