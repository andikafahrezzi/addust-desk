@extends('layouts.app')

@section('content')

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Admin Dashboard</h1>
            <p class="mt-1 text-gray-500">Welcome back, {{ auth()->user()->name }}</p>
        </div>

        <form action="{{ route('admin.dashboard') }}" method="GET">
            <select
                name="period"
                onchange="this.form.submit()"
                class="border rounded-lg px-3 py-2 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-300"
            >
                <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Today</option>
                <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>This Week</option>
                <option value="month" {{ request('period', 'month') == 'month' ? 'selected' : '' }}>This Month</option>
                <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>This Year</option>
            </select>
        </form>
    </div>

    {{-- Ticket Summary Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mt-6">

        <div class="p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
            <h2 class="text-sm text-gray-500">Total Ticket</h2>
            <p class="text-3xl font-bold mt-1">{{ $totalTickets }}</p>
        </div>

        <div class="p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
            <h2 class="text-sm text-gray-500">Open</h2>
            <p class="text-3xl font-bold mt-1">{{ $openTickets }}</p>
        </div>

        <div class="p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
            <h2 class="text-sm text-gray-500">In Progress</h2>
            <p class="text-3xl font-bold mt-1">{{ $inProgressTickets }}</p>
        </div>

        <div class="p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
            <h2 class="text-sm text-gray-500">Resolved</h2>
            <p class="text-3xl font-bold mt-1">{{ $resolvedTickets }}</p>
        </div>

        <div class="p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
            <h2 class="text-sm text-gray-500">Closed</h2>
            <p class="text-3xl font-bold mt-1">{{ $closedTickets }}</p>
        </div>

    </div>

    {{-- SLA Summary --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">

        <div class="p-4 bg-white rounded-xl shadow-sm">
            <h2 class="font-bold">Response SLA</h2>

            <div class="mt-3 space-y-1">
                <p>On Time : <span class="font-bold">{{ $responseOnTime }}</span></p>
                <p>Breached : <span class="font-bold">{{ $responseBreached }}</span></p>
            </div>
        </div>

        <div class="p-4 bg-white rounded-xl shadow-sm">
            <h2 class="font-bold">Resolution SLA</h2>

            <div class="mt-3 space-y-1">
                <p>On Time : <span class="font-bold">{{ $resolutionOnTime }}</span></p>
                <p>Breached : <span class="font-bold">{{ $resolutionBreached }}</span></p>
            </div>
        </div>

    </div>

    {{-- Charts: Status & Priority --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold mb-4">Ticket by Status</h2>
            <div class="max-w-sm mx-auto">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold mb-4">Ticket by Priority</h2>
            <canvas id="priorityChart"></canvas>
        </div>

    </div>

    {{-- Chart: Category --}}
    <div class="mt-6 bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold mb-4">Ticket by Category</h2>
        <div class="w-full mx-auto">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>

    {{-- Chart: Monthly Trend --}}
    <div class="mt-6 bg-white rounded-xl shadow-sm p-6">
        <h2 class="text-lg font-semibold mb-4">Monthly Ticket Trend</h2>
        <canvas id="monthlyChart"></canvas>
    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Ticket by Status (doughnut)
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Open', 'In Progress', 'Resolved', 'Closed'],
            datasets: [{
                data: [
                    {{ $statusStatistics['OPEN'] }},
                    {{ $statusStatistics['IN_PROGRESS'] }},
                    {{ $statusStatistics['RESOLVED'] }},
                    {{ $statusStatistics['CLOSED'] }}
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Ticket by Priority (bar)
    new Chart(document.getElementById('priorityChart'), {
        type: 'bar',
        data: {
            labels: @json($priorityStatistics->pluck('name')),
            datasets: [{
                label: 'Tickets',
                data: @json($priorityStatistics->pluck('total'))
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Ticket by Category (bar)
    new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels: @json($categoryStatistics->pluck('name')),
            datasets: [{
                label: 'Tickets',
                data: @json($categoryStatistics->pluck('total'))
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Monthly Ticket Trend (line)
    const monthNames = [
        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
    ];

    const monthlyData = new Array(12).fill(0);

    @foreach ($monthlyStatistics as $item)
        monthlyData[{{ $item->month - 1 }}] = {{ $item->total }};
    @endforeach

    new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: monthNames,
            datasets: [{
                label: 'Tickets',
                data: monthlyData,
                tension: 0.3,
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });

});
</script>
@endpush