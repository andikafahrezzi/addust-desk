@extends('layouts.app')

@section('title', 'Priorities · AddustDesk')
@section('page-title', 'Priorities')
@section('page-subtitle', 'Kelola level prioritas dan target SLA tiket.')

@section('page-actions')
    <a href="{{ route('admin.priorities.create') }}"
       class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-accent text-white text-sm font-medium hover:bg-accent-hover transition-colors">
        <x-icon name="plus" />
        Create Priority
    </a>
@endsection

@section('content')

    @if($priorities->count())

        <div class="bg-white border border-border rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-border bg-slate-50/60">
                        <th class="text-left font-medium text-xs uppercase tracking-wide text-slate-500 px-4 py-3">Name</th>
                        <th class="text-left font-medium text-xs uppercase tracking-wide text-slate-500 px-4 py-3">SLA Response</th>
                        <th class="text-left font-medium text-xs uppercase tracking-wide text-slate-500 px-4 py-3">SLA Resolution</th>
                        <th class="text-left font-medium text-xs uppercase tracking-wide text-slate-500 px-4 py-3">Created</th>
                        <th class="text-center font-medium text-xs uppercase tracking-wide text-slate-500 px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach($priorities as $priority)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-4 py-3 font-medium text-slate-900">
                                {{ $priority->name }}
                            </td>
                            <td class="px-4 py-3 text-slate-500">
                                <span class="inline-flex items-center gap-1.5">
                                    <x-icon name="clock" class="w-3.5 h-3.5 text-slate-400" />
                                    {{ $priority->sla_response_minutes }} min
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-500">
                                <span class="inline-flex items-center gap-1.5">
                                    <x-icon name="clock" class="w-3.5 h-3.5 text-slate-400" />
                                    {{ $priority->sla_resolution_minutes }} min
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-500">
                                {{ $priority->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-3">

                                    <a href="{{ route('admin.priorities.edit', $priority) }}"
                                       class="inline-flex items-center gap-1 text-xs font-medium text-accent hover:text-accent-hover transition">
                                        <x-icon name="pencil" class="w-3.5 h-3.5" />
                                        Edit
                                    </a>

                                    <span class="w-px h-4 bg-border"></span>

                                    <form method="POST" action="{{ route('admin.priorities.destroy', $priority) }}"
                                          onsubmit="return confirm('Delete this priority?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 text-xs font-medium text-rose-600 hover:text-rose-700 transition">
                                            <x-icon name="trash" class="w-3.5 h-3.5" />
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $priorities->links() }}
        </div>

    @else

        <div class="bg-white border border-border rounded-xl py-16 px-6 flex flex-col items-center text-center">
            <div class="w-11 h-11 rounded-full bg-accent-tint text-accent flex items-center justify-center mb-3">
                <x-icon name="flag" />
            </div>
            <p class="text-sm font-medium text-slate-900">Belum ada priority</p>
            <p class="text-sm text-slate-500 mt-1">Priority menentukan target SLA response & resolution tiket.</p>
            <a href="{{ route('admin.priorities.create') }}"
               class="mt-4 inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-accent text-white text-sm font-medium hover:bg-accent-hover transition-colors">
                <x-icon name="plus" />
                Create Priority
            </a>
        </div>

    @endif

@endsection