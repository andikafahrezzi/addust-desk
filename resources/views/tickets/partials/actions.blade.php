{{-- AGENT: Resolve --}}
@if(
    auth()->user()->role->name === 'AGENT' &&
    $ticket->status === 'IN_PROGRESS' &&
    $ticket->current_handler_id === auth()->id()
)

    <div class="bg-white border border-border rounded-xl p-4 flex items-center justify-between gap-4 flex-wrap">
        <div>
            <p class="text-sm font-medium text-slate-900">Selesaikan tiket ini?</p>
            <p class="text-xs text-slate-500 mt-0.5">Tandai resolved setelah solusi diberikan ke user.</p>
        </div>

        <form
            method="POST"
            action="{{ route('agent.tickets.resolve', $ticket) }}"
            onsubmit="return confirm('Resolve this ticket?')"
        >
            @csrf
            @method('PATCH')

            <button type="submit"
                class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-status-resolved text-white text-sm font-medium hover:opacity-90 transition">
                <x-icon name="check" class="w-4 h-4" />
                Resolve Ticket
            </button>
        </form>
    </div>

@endif

{{-- AGENT: Escalate --}}
@if(
    auth()->user()->role->name === 'AGENT' &&
    auth()->id() === $ticket->current_handler_id &&
    !in_array($ticket->status, ['RESOLVED', 'CLOSED'])
)

    <div class="bg-white border border-border rounded-xl p-4">
        <h3 class="text-sm font-semibold text-slate-900 mb-3">Escalate Ticket</h3>

        <form
            method="POST"
            action="{{ route('agent.tickets.escalate', $ticket) }}"
            class="flex flex-col sm:flex-row sm:items-end gap-3"
            onsubmit="return confirm('Escalate this ticket?')"
        >
            @csrf
            @method('PATCH')

            <div class="flex-1">
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Department</label>
                <select name="department_id"
                    class="w-full border border-border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent-tint focus:border-accent"
                    required>
                    <option value="">-- Select Department --</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
                @error('department_id')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="inline-flex items-center justify-center gap-2 px-3.5 py-2 rounded-lg bg-status-progress text-white text-sm font-medium hover:opacity-90 transition shrink-0">
                <x-icon name="flag" class="w-4 h-4" />
                Escalate
            </button>
        </form>
    </div>

@endif

{{-- AGENT: Reassign --}}
@if(
    auth()->user()->role->name === 'AGENT' &&
    auth()->id() === $ticket->current_handler_id &&
    !in_array($ticket->status, ['RESOLVED', 'CLOSED'])
)

    <div class="bg-white border border-border rounded-xl p-4">
        <h3 class="text-sm font-semibold text-slate-900 mb-3">Reassign Ticket</h3>

        <form
            method="POST"
            action="{{ route('agent.tickets.reassign', $ticket) }}"
            class="flex flex-col sm:flex-row sm:items-end gap-3"
            onsubmit="return confirm('Reassign this ticket?')"
        >
            @csrf
            @method('PATCH')

            <div class="flex-1">
                <label class="block text-xs font-medium text-slate-500 mb-1.5">Assign To</label>
                <select name="agent_id"
                    class="w-full border border-border rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent-tint focus:border-accent"
                    required>
                    <option value="">-- Select Agent --</option>
                    @foreach($agents as $agent)
                        <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                    @endforeach
                </select>
                @error('agent_id')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="inline-flex items-center justify-center gap-2 px-3.5 py-2 rounded-lg bg-accent text-white text-sm font-medium hover:bg-accent-hover transition shrink-0">
                <x-icon name="users" class="w-4 h-4" />
                Reassign
            </button>
        </form>
    </div>

@endif

{{-- USER: Reopen / Close --}}
@if(
    auth()->user()->role->name === 'USER' &&
    $ticket->status === 'RESOLVED'
)

    <div class="bg-white border border-border rounded-xl p-4">
        <p class="text-sm font-medium text-slate-900 mb-3">Apakah solusi ini sudah sesuai?</p>

        <div class="flex flex-col sm:flex-row gap-3">

            <form
                method="POST"
                action="{{ route('user.tickets.reopen', $ticket) }}"
                onsubmit="return confirm('Reopen this ticket?')"
                class="flex-1"
            >
                @csrf
                @method('PATCH')

                <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-3.5 py-2 rounded-lg border border-status-reopened text-status-reopened text-sm font-medium hover:bg-status-reopened/10 transition">
                    <x-icon name="inbox" class="w-4 h-4" />
                    Belum, Reopen Ticket
                </button>
            </form>

            <form
                method="POST"
                action="{{ route('user.tickets.close', $ticket) }}"
                onsubmit="return confirm('Close this ticket? This action cannot be undone.')"
                class="flex-1"
            >
                @csrf
                @method('PATCH')

                <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-3.5 py-2 rounded-lg bg-status-resolved text-white text-sm font-medium hover:opacity-90 transition">
                    <x-icon name="check" class="w-4 h-4" />
                    Sudah, Close Ticket
                </button>
            </form>

        </div>
    </div>

@endif