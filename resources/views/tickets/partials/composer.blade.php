@if(
    $canReply &&
    !in_array($ticket->status, ['RESOLVED', 'CLOSED'])
)

    <div class="bg-white border border-border rounded-xl p-6">

        <form
            method="POST"
            action="{{ $messageStoreRoute }}"
            enctype="multipart/form-data"
        >
            @csrf

            <input type="hidden" name="parent_message_id" id="parent_message_id">

            {{-- Reply preview --}}
            <div id="reply-preview" class="hidden border-l-[3px] border-accent bg-accent-tint rounded-lg p-3 mb-4">
                <div class="flex justify-between items-start gap-3">
                    <div class="min-w-0">
                        <p id="reply-author" class="text-sm font-semibold text-accent-hover"></p>
                        <p id="reply-message" class="text-sm text-slate-600 truncate"></p>
                    </div>
                    <button type="button" id="cancel-reply" class="text-slate-400 hover:text-rose-600 shrink-0">
                        <x-icon name="close" class="w-4 h-4" />
                    </button>
                </div>
            </div>

            <textarea
                name="message"
                rows="4"
                class="w-full border border-border rounded-lg p-3 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-accent-tint focus:border-accent resize-none"
                placeholder="Tulis balasan..."
            >{{ old('message') }}</textarea>

            @error('message')
                <p class="text-rose-600 text-xs mt-1.5">{{ $message }}</p>
            @enderror

            <div class="mt-4">
                <label class="block text-xs font-medium text-slate-500 mb-1.5">
                    Attachment
                </label>

                <input
                    type="file"
                    name="attachments[]"
                    multiple
                    class="w-full text-sm text-slate-600 border border-border rounded-lg px-3 py-2
                           file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0
                           file:bg-accent-tint file:text-accent-hover file:text-xs file:font-medium
                           hover:file:bg-accent/20 cursor-pointer"
                >

                <p class="text-xs text-slate-400 mt-1.5">
                    JPG, PNG, PDF, DOC, DOCX, XLS, XLSX, TXT, ZIP (maks 10 MB/file)
                </p>

                @error('attachments.*')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4 flex justify-end">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-accent text-white text-sm font-medium hover:bg-accent-hover transition-colors">
                    Send
                    <x-icon name="send" class="w-4 h-4" />
                </button>
            </div>

        </form>

    </div>

@else

    <div class="bg-slate-50 border border-border rounded-xl p-4 flex items-center gap-2 text-sm text-slate-500">
        <x-icon name="archive" class="w-4 h-4" />
        Tiket ini sudah ditutup, tidak bisa menambah balasan baru.
    </div>

@endif

@push('scripts')
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
    ?.addEventListener('click', function () {

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
@endpush