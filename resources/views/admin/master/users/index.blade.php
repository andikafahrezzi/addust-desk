@extends('layouts.app')

@section('title', 'Users · AddustDesk')
@section('page-title', 'Users')
@section('page-subtitle', 'Kelola akun User, Agent, dan Admin.')

@section('page-actions')
    <a href="{{ route('admin.users.create') }}"
       class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-accent text-white text-sm font-medium hover:bg-accent-hover transition-colors">
        <x-icon name="plus" />
        Create User
    </a>
@endsection

@section('content')

    @if($users->count())

        <div class="bg-white border border-border rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-border bg-slate-50/60">
                        <th class="text-left font-medium text-xs uppercase tracking-wide text-slate-500 px-4 py-3">Name</th>
                        <th class="text-left font-medium text-xs uppercase tracking-wide text-slate-500 px-4 py-3">Email</th>
                        <th class="text-left font-medium text-xs uppercase tracking-wide text-slate-500 px-4 py-3">Role</th>
                        <th class="text-left font-medium text-xs uppercase tracking-wide text-slate-500 px-4 py-3">Department</th>
                        <th class="text-center font-medium text-xs uppercase tracking-wide text-slate-500 px-4 py-3">Status</th>
                        <th class="text-center font-medium text-xs uppercase tracking-wide text-slate-500 px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach($users as $user)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-4 py-3 font-medium text-slate-900">
                                {{ $user->name }}
                            </td>
                            <td class="px-4 py-3 text-slate-500">
                                {{ $user->email }}
                            </td>
                            <td class="px-4 py-3 text-slate-500">
                                {{ $user->role->name }}
                            </td>
                            <td class="px-4 py-3 text-slate-500">
                                {{ $user->department?->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($user->is_active)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-status-resolved/10 text-status-resolved">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-3">

                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="inline-flex items-center gap-1 text-xs font-medium text-accent hover:text-accent-hover transition">
                                        <x-icon name="pencil" class="w-3.5 h-3.5" />
                                        Edit
                                    </a>

                                    <span class="w-px h-4 bg-border"></span>

                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 text-xs font-medium transition {{ $user->is_active ? 'text-status-reopened hover:text-rose-700' : 'text-status-resolved hover:opacity-80' }}">
                                            <x-icon name="{{ $user->is_active ? 'archive' : 'check' }}" class="w-3.5 h-3.5" />
                                            {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>

                                    <span class="w-px h-4 bg-border"></span>

                                    <form method="POST" action="{{ route('admin.users.reset-password', $user) }}"
                                          onsubmit="return confirm('Reset this user password?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 text-xs font-medium text-slate-500 hover:text-slate-700 transition">
                                            <x-icon name="key" class="w-3.5 h-3.5" />
                                            Reset Password
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
            {{ $users->links() }}
        </div>

    @else

        <div class="bg-white border border-border rounded-xl py-16 px-6 flex flex-col items-center text-center">
            <div class="w-11 h-11 rounded-full bg-accent-tint text-accent flex items-center justify-center mb-3">
                <x-icon name="users" />
            </div>
            <p class="text-sm font-medium text-slate-900">Belum ada user</p>
            <p class="text-sm text-slate-500 mt-1">Tambahkan akun User, Agent, atau Admin pertama.</p>
            <a href="{{ route('admin.users.create') }}"
               class="mt-4 inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-accent text-white text-sm font-medium hover:bg-accent-hover transition-colors">
                <x-icon name="plus" />
                Create User
            </a>
        </div>

    @endif

@endsection