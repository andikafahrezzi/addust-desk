@php
    $role = auth()->user()->role->name;

    $roleBadge = match($role) {
        'ADMIN' => 'bg-slate-900 text-white',
        'AGENT' => 'bg-accent-tint text-accent-hover',
        default => 'bg-slate-100 text-slate-600',
    };
@endphp

<aside class="w-64 shrink-0 bg-white border-r border-border flex flex-col">

    {{-- Logo --}}
    <div class="h-16 flex items-center gap-2 px-5 border-b border-border">
        <div class="w-7 h-7 rounded-md bg-accent text-white text-xs font-bold flex items-center justify-center">
            AD
        </div>
        <span class="font-semibold tracking-tight text-slate-900">AddustDesk</span>
    </div>

    {{-- User --}}
    <div class="px-5 py-4 border-b border-border">
        <p class="text-sm font-medium text-slate-900 truncate">
            {{ auth()->user()->name }}
        </p>
        <span class="inline-block mt-1.5 px-2 py-0.5 rounded-full text-xs font-medium {{ $roleBadge }}">
            {{ ucfirst(strtolower($role)) }}
        </span>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1">

        @if ($role === 'USER')

            <x-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard')" icon="home">
                Dashboard
            </x-nav-link>

            <x-nav-link :href="route('user.tickets.create')" :active="request()->routeIs('user.tickets.create')" icon="plus">
                Create Ticket
            </x-nav-link>

            <x-nav-link :href="route('user.tickets.index')" :active="request()->routeIs('user.tickets.index') || request()->routeIs('user.tickets.show')" icon="ticket">
                My Tickets
            </x-nav-link>

            <x-nav-link :href="route('user.tickets.closed')" :active="request()->routeIs('user.tickets.closed')" icon="archive">
                Closed Tickets
            </x-nav-link>

            <div class="pt-4 mt-4 border-t border-border">
                <x-nav-link icon="book" soon>
                    Knowledge Base
                </x-nav-link>
            </div>

        @endif

        @if ($role === 'AGENT')

            <x-nav-link :href="route('agent.dashboard')" :active="request()->routeIs('agent.dashboard')" icon="home">
                Dashboard
            </x-nav-link>

            <x-nav-link :href="route('agent.tickets.index')" :active="request()->routeIs('agent.tickets.index') || request()->routeIs('agent.tickets.show')" icon="inbox">
                Tickets
            </x-nav-link>

            <x-nav-link :href="route('agent.tickets.closed')" :active="request()->routeIs('agent.tickets.closed')" icon="archive">
                Closed Tickets
            </x-nav-link>

            <div class="pt-4 mt-4 border-t border-border space-y-1">
                <x-nav-link icon="chart" soon>
                    Reports
                </x-nav-link>
                <x-nav-link icon="book" soon>
                    Knowledge Base
                </x-nav-link>
            </div>

        @endif

        @if ($role === 'ADMIN')

            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" icon="home">
                Dashboard
            </x-nav-link>

            <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" icon="users">
                Users
            </x-nav-link>

            <x-nav-link :href="route('admin.departments.index')" :active="request()->routeIs('admin.departments.*')" icon="building">
                Departments
            </x-nav-link>

            <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')" icon="tag">
                Categories
            </x-nav-link>

            <x-nav-link :href="route('admin.priorities.index')" :active="request()->routeIs('admin.priorities.*')" icon="flag">
                Priorities
            </x-nav-link>

            <div class="pt-4 mt-4 border-t border-border space-y-1">
                <x-nav-link icon="chart" soon>
                    Reports
                </x-nav-link>
                <x-nav-link icon="book" soon>
                    Knowledge Base
                </x-nav-link>
            </div>

        @endif

    </nav>

    {{-- Logout --}}
    <div class="p-3 border-t border-border">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition-colors">
                <x-icon name="logout" />
                <span>Logout</span>
            </button>
        </form>
    </div>

</aside>