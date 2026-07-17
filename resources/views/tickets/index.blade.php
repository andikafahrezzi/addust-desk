@extends('layouts.app')

@section('title', ($isClosed ? 'Closed Tickets' : 'My Tickets') . ' · AddustDesk')
@section('page-title', $isClosed ? 'Closed Tickets' : 'My Tickets')
@section('page-subtitle', $isClosed
    ? 'Arsip tiket yang sudah selesai diverifikasi.'
    : 'Pantau status tiket yang sedang kamu ajukan.')

@unless($isClosed)
    @section('page-actions')
        <a href="{{ route('user.tickets.create') }}"
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-accent text-white text-sm font-medium hover:bg-accent-hover transition-colors">
            <x-icon name="plus" />
            New Ticket
        </a>
    @endsection
@endunless

@section('content')

    @if($tickets->count())

        <div class="bg-white border border-border rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-border bg-slate-50/60">
                        <th class="text-left font-medium text-xs uppercase tracking-wide text-slate-500 px-4 py-3">Ticket</th>
                        <th class="text-left font-medium text-xs uppercase tracking-wide text-slate-500 px-4 py-3">Title</th>
                        <th class="text-left font-medium text-xs uppercase tracking-wide text-slate-500 px-4 py-3">Category</th>
                        <th class="text-left font-medium text-xs uppercase tracking-wide text-slate-500 px-4 py-3">Priority</th>
                        <th class="text-left font-medium text-xs uppercase tracking-wide text-slate-500 px-4 py-3">Status</th>
                        <th class="text-left font-medium text-xs uppercase tracking-wide text-slate-500 px-4 py-3">Department</th>
                        <th class="text-left font-medium text-xs uppercase tracking-wide text-slate-500 px-4 py-3">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach($tickets as $ticket)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-4 py-3">
                                <a href="{{ route('user.tickets.show', $ticket) }}"
                                   class="font-medium text-accent hover:text-accent-hover hover:underline">
                                    {{ $ticket->ticket_number }}
                                </a>
                            </td>
                            <td class="px-4 py-3 text-slate-700 max-w-xs truncate">
                                {{ $ticket->title }}
                            </td>
                            <td class="px-4 py-3 text-slate-500">
                                {{ $ticket->category->name }}
                            </td>
                            <td class="px-4 py-3 text-slate-500">
                                {{ $ticket->priority->name }}
                            </td>
                            <td class="px-4 py-3">
                                <x-status-badge :status="$ticket->status" />
                            </td>
                            <td class="px-4 py-3 text-slate-500">
                                {{ $ticket->currentDepartment->name }}
                            </td>
                            <td class="px-4 py-3 text-slate-400 text-xs whitespace-nowrap">
                                {{ $ticket->created_at->format('d M Y H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $tickets->links() }}
        </div>

    @else

        <div class="bg-white border border-border rounded-xl py-16 px-6 flex flex-col items-center text-center">
            <div class="w-11 h-11 rounded-full bg-accent-tint text-accent flex items-center justify-center mb-3">
                <x-icon name="{{ $isClosed ? 'archive' : 'ticket' }}" />
            </div>

            @if($isClosed)
                <p class="text-sm font-medium text-slate-900">Belum ada tiket yang ditutup</p>
                <p class="text-sm text-slate-500 mt-1">Tiket yang sudah kamu verifikasi selesai akan muncul di sini.</p>
            @else
                <p class="text-sm font-medium text-slate-900">Belum ada tiket</p>
                <p class="text-sm text-slate-500 mt-1">Punya kendala IT? Buat tiket pertamamu sekarang.</p>
                <a href="{{ route('user.tickets.create') }}"
                   class="mt-4 inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-accent text-white text-sm font-medium hover:bg-accent-hover transition-colors">
                    <x-icon name="plus" />
                    New Ticket
                </a>
            @endif
        </div>

    @endif

@endsection