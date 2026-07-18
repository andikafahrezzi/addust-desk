@extends('layouts.app')

@section('title', 'Admin Dashboard · AddustDesk')
@section('page-title', 'Admin Dashboard')
@section('page-subtitle', 'Welcome back, ' . auth()->user()->name)

@section('page-actions')
    <form action="{{ route('admin.dashboard') }}" method="GET">
        <select
            name="period"
            onchange="this.form.submit()"
            class="border border-border rounded-lg pl-3 pr-8 py-2 text-sm text-slate-700 bg-white focus:outline-none focus:ring-2 focus:ring-accent-tint focus:border-accent"
        >
            <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>Today</option>
            <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>This Week</option>
            <option value="month" {{ request('period', 'month') == 'month' ? 'selected' : '' }}>This Month</option>
            <option value="year" {{ request('period') == 'year' ? 'selected' : '' }}>This Year</option>
        </select>
    </form>
@endsection

@section('content')

    <div class="space-y-6">

        {{-- KPI Cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">

            <div class="bg-white border border-border rounded-xl p-4">
                <div class="w-9 h-9 rounded-lg bg-accent-tint text-accent flex items-center justify-center">
                    <x-icon name="ticket"  />
                </div>
                <p class="text-xs text-slate-500 mt-3">Total Ticket</p>
                <p class="text-2xl font-semibold text-slate-900 mt-0.5">{{ $totalTickets }}</p>
            </div>

            <div class="bg-white border border-border rounded-xl p-4">
                <div class="w-9 h-9 rounded-lg bg-status-open/10 text-status-open flex items-center justify-center">
                    <x-icon name="inbox"  />
                </div>
                <p class="text-xs text-slate-500 mt-3">Open</p>
                <p class="text-2xl font-semibold text-slate-900 mt-0.5">{{ $openTickets }}</p>
            </div>

            <div class="bg-white border border-border rounded-xl p-4">
                <div class="w-9 h-9 rounded-lg bg-status-progress/10 text-status-progress flex items-center justify-center">
                    <x-icon name="clock"  />
                </div>
                <p class="text-xs text-slate-500 mt-3">In Progress</p>
                <p class="text-2xl font-semibold text-slate-900 mt-0.5">{{ $inProgressTickets }}</p>
            </div>

            <div class="bg-white border border-border rounded-xl p-4">
                <div class="w-9 h-9 rounded-lg bg-status-resolved/10 text-status-resolved flex items-center justify-center">
                    <x-icon name="check"  />
                </div>
                <p class="text-xs text-slate-500 mt-3">Resolved</p>
                <p class="text-2xl font-semibold text-slate-900 mt-0.5">{{ $resolvedTickets }}</p>
            </div>

            <div class="bg-white border border-border rounded-xl p-4">
                <div class="w-9 h-9 rounded-lg bg-status-closed/10 text-status-closed flex items-center justify-center">
                    <x-icon name="archive"  />
                </div>
                <p class="text-xs text-slate-500 mt-3">Closed</p>
                <p class="text-2xl font-semibold text-slate-900 mt-0.5">{{ $closedTickets }}</p>
            </div>

        </div>

        {{-- SLA Summary --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div class="bg-white border border-border rounded-xl p-5">
                <h2 class="text-sm font-semibold text-slate-900">Response SLA</h2>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <p class="text-xs text-slate-400 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-status-resolved"></span>
                            On Time
                        </p>
                        <p class="text-2xl font-semibold text-slate-900 mt-1">{{ $responseOnTime }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-status-reopened"></span>
                            Breached
                        </p>
                        <p class="text-2xl font-semibold text-slate-900 mt-1">{{ $responseBreached }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-border rounded-xl p-5">
                <h2 class="text-sm font-semibold text-slate-900">Resolution SLA</h2>

                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div>
                        <p class="text-xs text-slate-400 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-status-resolved"></span>
                            On Time
                        </p>
                        <p class="text-2xl font-semibold text-slate-900 mt-1">{{ $resolutionOnTime }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-status-reopened"></span>
                            Breached
                        </p>
                        <p class="text-2xl font-semibold text-slate-900 mt-1">{{ $resolutionBreached }}</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Charts: Status & Priority --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="bg-white border border-border rounded-xl p-6">
                <h2 class="text-sm font-semibold text-slate-900 mb-5">Ticket by Status</h2>
                <div class="max-w-sm mx-auto">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>

            <div class="bg-white border border-border rounded-xl p-6">
                <h2 class="text-sm font-semibold text-slate-900 mb-5">Ticket by Priority</h2>
                <canvas id="priorityChart"></canvas>
            </div>

        </div>

        {{-- Chart: Category --}}
        <div class="bg-white border border-border rounded-xl p-6">
            <h2 class="text-sm font-semibold text-slate-900 mb-5">Ticket by Category</h2>
            <canvas id="categoryChart"></canvas>
        </div>

        {{-- Chart: Monthly Trend --}}
        <div class="bg-white border border-border rounded-xl p-6">
            <h2 class="text-sm font-semibold text-slate-900 mb-5">Monthly Ticket Trend</h2>
            <canvas id="monthlyChart"></canvas>
        </div>

    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Design tokens (kept in sync with tailwind.config.js)
    const palette = {
        accent: '#3D6B99',
        accentTint: '#EAF1F7',
        open: '#3D6B99',
        progress: '#C08A2E',
        resolved: '#4F9A78',
        closed: '#94A3A8',
        reopened: '#C1495A',
        border: '#E7E4DD',
        textMuted: '#6B7280',
    };

    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = palette.textMuted;
    Chart.defaults.borderColor = palette.border;

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
                ],
                backgroundColor: [palette.open, palette.progress, palette.resolved, palette.closed],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { usePointStyle: true, pointStyle: 'circle', padding: 16 }
                }
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
                data: @json($priorityStatistics->pluck('total')),
                backgroundColor: palette.accent,
                borderRadius: 6,
                maxBarThickness: 36,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, ticks: { precision: 0 } }
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
                data: @json($categoryStatistics->pluck('total')),
                backgroundColor: palette.accent,
                borderRadius: 6,
                maxBarThickness: 36,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, ticks: { precision: 0 } }
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
                borderColor: palette.accent,
                backgroundColor: palette.accentTint,
                pointBackgroundColor: palette.accent,
                pointRadius: 3,
                tension: 0.3,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, ticks: { precision: 0 } }
            }
        }
    });

});
</script>
@endpush