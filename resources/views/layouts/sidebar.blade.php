@php
    $role = auth()->user()->role->name;
@endphp

<ul class="space-y-2">

@if($role === 'USER')

    <li>
        <a href="{{ route('user.dashboard') }}">
            Dashboard
        </a>
    </li>

    <li>
        <a href="{{ route('user.tickets.create') }}">
            Create Ticket
        </a>
    </li>

    <li>
        <a href="{{ route('user.tickets.index') }}">
            My Tickets
        </a>
    </li>

    <li>
        <a href="{{ route('user.tickets.closed') }}">
            Closed Tickets
        </a>
    </li>

@endif


    {{-- AGENT --}}
    @if($role === 'AGENT')

        <li>
            <a href="{{ route('agent.dashboard') }}">
                Dashboard
            </a>
        </li>

        <li>
            <a href="#">
                Available Queue
            </a>
        </li>

        <li>
            <a href="#">
                Assigned To Me
            </a>
        </li>

        <li>
            <a href="#">
                Resolved Tickets
            </a>
        </li>

    @endif


    {{-- ADMIN --}}
    @if($role === 'ADMIN')

        <li>
            <a href="{{ route('admin.dashboard') }}">
                Dashboard
            </a>
        </li>

        <li>
            <a href="#">
                Users
            </a>
        </li>

        <li>
            <a href="#">
                Departments
            </a>
        </li>

        <li>
            <a href="#">
                Categories
            </a>
        </li>

        <li>
            <a href="#">
                Priorities
            </a>
        </li>

        <li>
            <a href="#">
                Reports
            </a>
        </li>

    @endif

</ul>

<hr class="my-4">

<form method="POST" action="{{ route('logout') }}">
    @csrf

    <button type="submit">
        Logout
    </button>
</form>