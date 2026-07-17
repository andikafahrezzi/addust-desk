<div class="bg-white border border-border rounded-xl p-6">

    <div class="flex items-start justify-between gap-4 flex-wrap">
        <div>
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wide mb-1">
                Ticket
            </p>
            <h2 class="text-xl font-semibold text-slate-900">
                {{ $ticket->title }}
            </h2>
        </div>

        <x-status-badge :status="$ticket->status" />
    </div>

    <dl class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6 pt-6 border-t border-border">

        <div>
            <dt class="text-xs text-slate-400">Category</dt>
            <dd class="text-sm text-slate-700 mt-0.5">{{ $ticket->category->name }}</dd>
        </div>

        <div>
            <dt class="text-xs text-slate-400">Priority</dt>
            <dd class="text-sm text-slate-700 mt-0.5">{{ $ticket->priority->name }}</dd>
        </div>

        <div>
            <dt class="text-xs text-slate-400">Department</dt>
            <dd class="text-sm text-slate-700 mt-0.5">{{ $ticket->currentDepartment->name }}</dd>
        </div>

        <div>
            <dt class="text-xs text-slate-400">Created</dt>
            <dd class="text-sm text-slate-700 mt-0.5">{{ $ticket->created_at->format('d M Y H:i') }}</dd>
        </div>

    </dl>

    @if($ticket->status === 'CLOSED')
        <div class="mt-5 flex items-center gap-2 text-xs text-slate-500 bg-slate-50 border border-border rounded-lg px-3 py-2">
            <x-icon name="archive" class="w-4 h-4" />
            Tiket ini sudah ditutup dan bersifat arsip (read-only).
        </div>
    @endif

</div>