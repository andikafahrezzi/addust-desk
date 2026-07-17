@php
    use Illuminate\Support\Str;

    $isAgentSender = in_array($message->sender->role->name, ['AGENT', 'ADMIN']);
    $isOwn = auth()->id() === $message->sender_id;
    $canManage = !$message->deleted_at && $isOwn && $ticket->status !== 'CLOSED';
@endphp

<div class="rounded-lg border border-border p-4 {{ $isAgentSender ? 'bg-accent-tint/40 border-l-[3px] border-l-accent' : 'bg-white' }}">

    {{-- Reply reference --}}
    @if($message->replyTo)
        <div class="border-l-[3px] border-slate-300 bg-slate-50 rounded-md px-3 py-2 mb-3">
            <p class="text-xs font-semibold text-slate-600">
                ↩ {{ $message->replyTo->sender->name }}
            </p>

            @if($message->replyTo->deleted_at)
                <p class="text-xs italic text-slate-400 mt-0.5">
                    Pesan ini sudah dihapus.
                </p>
            @else
                <p class="text-xs text-slate-500 mt-0.5 truncate">
                    {{ Str::limit($message->replyTo->message, 80) }}
                </p>
            @endif
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center justify-between gap-3">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold shrink-0 {{ $isAgentSender ? 'bg-accent text-white' : 'bg-slate-200 text-slate-600' }}">
                {{ strtoupper(substr($message->sender->name, 0, 1)) }}
            </div>
            <div>
                <p class="text-sm font-medium text-slate-900 leading-tight">
                    {{ $message->sender->name }}
                </p>
                <p class="text-xs text-slate-400">
                    {{ ucfirst(strtolower($message->sender->role->name)) }}
                </p>
            </div>
        </div>

        <span class="text-xs text-slate-400 whitespace-nowrap">
            {{ $message->created_at->format('d M Y H:i') }}
        </span>
    </div>

    {{-- Body --}}
    <div id="message-display-{{ $message->id }}" class="text-sm text-slate-700 mt-3 pl-[42px] whitespace-pre-line">
        @if($message->deleted_at)
            <span class="italic text-slate-400">Pesan ini sudah dihapus.</span>
        @else
            {{ $message->message }}
        @endif
    </div>

    {{-- Edit form --}}
    @if(!$message->deleted_at)
        <div id="message-edit-{{ $message->id }}" class="hidden mt-3 pl-[42px]">
            <form method="POST" action="{{ route($messageUpdateRouteName, $message) }}">
                @csrf
                @method('PATCH')

                <textarea
                    name="message"
                    rows="3"
                    class="w-full border border-border rounded-lg p-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-accent-tint focus:border-accent resize-none"
                >{{ old('message', $message->message) }}</textarea>

                @error('message')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror

                <div class="mt-2 flex gap-2">
                    <button type="submit"
                        class="px-3 py-1.5 rounded-lg bg-accent text-white text-xs font-medium hover:bg-accent-hover transition">
                        Save
                    </button>
                    <button type="button"
                        class="cancel-edit px-3 py-1.5 rounded-lg border border-border text-slate-600 text-xs font-medium hover:bg-slate-50 transition"
                        data-id="{{ $message->id }}">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- Attachments --}}
    @if($message->attachments->isNotEmpty())
        <div class="mt-3 pl-[42px] space-y-1.5">
            @foreach($message->attachments as $attachment)
                <a href="{{ route($attachmentDownloadRouteName, $attachment) }}"
                   class="inline-flex items-center gap-2 border border-border rounded-lg px-3 py-1.5 text-xs text-accent hover:text-accent-hover hover:bg-accent-tint transition">
                    <x-icon name="paperclip" class="w-3.5 h-3.5" />
                    {{ $attachment->original_name }}
                </a>
            @endforeach
        </div>
    @endif

    {{-- Actions --}}
    @if(!$message->deleted_at)
        <div class="mt-3 pl-[42px] flex items-center gap-4">
            <button type="button"
                class="reply-btn inline-flex items-center gap-1 text-xs font-medium text-accent hover:text-accent-hover transition"
                data-id="{{ $message->id }}"
                data-author="{{ $message->sender->name }}"
                data-message="{{ Str::limit($message->message, 80) }}">
                <x-icon name="reply" class="w-3.5 h-3.5" />
                Reply
            </button>

            @if($canManage)
                <button type="button"
                    class="edit-btn inline-flex items-center gap-1 text-xs font-medium text-slate-500 hover:text-slate-700 transition"
                    data-id="{{ $message->id }}">
                    <x-icon name="pencil" class="w-3.5 h-3.5" />
                    Edit
                </button>

                <form method="POST" action="{{ route($messageDeleteRouteName, $message) }}"
                      onsubmit="return confirm('Delete this message?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-1 text-xs font-medium text-rose-600 hover:text-rose-700 transition">
                        <x-icon name="trash" class="w-3.5 h-3.5" />
                        Delete
                    </button>
                </form>
            @endif
        </div>
    @endif

</div>