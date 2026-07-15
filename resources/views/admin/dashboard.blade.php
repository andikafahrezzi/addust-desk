@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold">
    Admin Dashboard
</h1>

<p class="mt-2">
    Welcome {{ auth()->user()->name }}
</p>


<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-6">

    <div class="p-4 bg-white rounded shadow">
        <h2 class="text-sm text-gray-500">
            Total Ticket
        </h2>

        <p class="text-3xl font-bold">
            {{ $totalTickets }}
        </p>
    </div>


    <div class="p-4 bg-white rounded shadow">
        <h2 class="text-sm text-gray-500">
            Open
        </h2>

        <p class="text-3xl font-bold">
            {{ $openTickets }}
        </p>
    </div>


    <div class="p-4 bg-white rounded shadow">
        <h2 class="text-sm text-gray-500">
            In Progress
        </h2>

        <p class="text-3xl font-bold">
            {{ $inProgressTickets }}
        </p>
    </div>


    <div class="p-4 bg-white rounded shadow">
        <h2 class="text-sm text-gray-500">
            Resolved
        </h2>

        <p class="text-3xl font-bold">
            {{ $resolvedTickets }}
        </p>
    </div>


    <div class="p-4 bg-white rounded shadow">
        <h2 class="text-sm text-gray-500">
            Closed
        </h2>

        <p class="text-3xl font-bold">
            {{ $closedTickets }}
        </p>
    </div>

</div>


<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">


    <div class="p-4 bg-white rounded shadow">

        <h2 class="font-bold">
            Response SLA
        </h2>

        <div class="mt-3">

            <p>
                On Time :
                <span class="font-bold">
                    {{ $responseOnTime }}
                </span>
            </p>


            <p>
                Breached :
                <span class="font-bold">
                    {{ $responseBreached }}
                </span>
            </p>

        </div>

    </div>



    <div class="p-4 bg-white rounded shadow">

        <h2 class="font-bold">
            Resolution SLA
        </h2>

        <div class="mt-3">

            <p>
                On Time :
                <span class="font-bold">
                    {{ $resolutionOnTime }}
                </span>
            </p>


            <p>
                Breached :
                <span class="font-bold">
                    {{ $resolutionBreached }}
                </span>
            </p>

        </div>

    </div>


</div>


@endsection