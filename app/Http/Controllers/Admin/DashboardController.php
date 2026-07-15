<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Priority;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get(
            'period',
            'month'
        );
        switch ($period) {

            case 'today':

                $startDate = now()->startOfDay();

                $endDate = now()->endOfDay();

                break;

            case 'week':

                $startDate = now()->startOfWeek();

                $endDate = now()->endOfWeek();

                break;

            case 'year':

                $startDate = now()->startOfYear();

                $endDate = now()->endOfYear();

                break;

            case 'month':

            default:

                $startDate = now()->startOfMonth();

                $endDate = now()->endOfMonth();

                break;

        }
        /*
        |--------------------------------------------------------------------------
        | Ticket Statistics
        |--------------------------------------------------------------------------
        */

        $totalTickets = Ticket::whereBetween(
            'created_at',
            [
                $startDate,
                $endDate
            ]
        )->count();

        $openTickets = Ticket::whereBetween(
            'created_at',
            [
                $startDate,
                $endDate
            ]
        )
        ->where(
            'status',
            'OPEN'
        )
        ->count();

        $inProgressTickets = Ticket::whereBetween(
            'created_at',
            [
                $startDate,
                $endDate
            ]
        )
        ->where(
            'status',
            'IN_PROGRESS'
        )
        ->count();

        $resolvedTickets = Ticket::whereBetween(
            'created_at',
            [
                $startDate,
                $endDate
            ]
        )
        ->where(
            'status',
            'RESOLVED'
        )
        ->count();

        $closedTickets = Ticket::whereBetween(
            'created_at',
            [
                $startDate,
                $endDate
            ]
        )
        ->where(
            'status',
            'CLOSED'
        )
        ->count();

        /*
        |--------------------------------------------------------------------------
        | SLA Statistics
        |--------------------------------------------------------------------------
        */

        $responseOnTime = 0;
        $responseBreached = 0;

        $resolutionOnTime = 0;
        $resolutionBreached = 0;

        $tickets = Ticket::with('events')
        ->whereBetween(
            'created_at',
            [
                $startDate,
                $endDate
            ]
        )
        ->get();

        foreach ($tickets as $ticket) {

            $responseStatus = $ticket->isResponseSlaMet();

            if ($responseStatus === true) {

                $responseOnTime++;

            } elseif ($responseStatus === false) {

                $responseBreached++;

            }

            $resolutionStatus = $ticket->isResolutionSlaMet();

            if ($resolutionStatus === true) {

                $resolutionOnTime++;

            } elseif ($resolutionStatus === false) {

                $resolutionBreached++;

            }
        }
        $statusStatistics = [
                'OPEN' => $openTickets,
                'IN_PROGRESS' => $inProgressTickets,
                'RESOLVED' => $resolvedTickets,
                'CLOSED' => $closedTickets,
        ];
        $priorityStatistics = Priority::withCount('tickets')
            ->orderBy('id')
            ->get();

            $priorityStatistics = Ticket::selectRaw('
            priorities.name,
            COUNT(*) as total
        ')
        ->join(
            'priorities',
            'tickets.priority_id',
            '=',
            'priorities.id'
        )
        ->groupBy(
            'priorities.id',
            'priorities.name'
        )
        ->orderBy(
            'priorities.id'
        )
        ->get();
        $categoryStatistics = Ticket::selectRaw('
        categories.name,
        COUNT(*) as total
    ')
    ->join(
        'categories',
        'tickets.category_id',
        '=',
        'categories.id'
    )
    ->groupBy(
        'categories.id',
        'categories.name'
    )
    ->orderByDesc('total')
    ->get();

    $monthlyStatistics = Ticket::select(
        DB::raw('MONTH(created_at) as month'),
        DB::raw('COUNT(*) as total')
    )
    ->whereYear(
        'created_at',
        now()->year
    )
    ->groupBy(
        DB::raw('MONTH(created_at)')
    )
    ->orderBy(
        DB::raw('MONTH(created_at)')
    )
    ->get();

        return view(
            'admin.dashboard',
            compact(
                'totalTickets',
                'openTickets',
                'inProgressTickets',
                'resolvedTickets',
                'closedTickets',
                'responseOnTime',
                'responseBreached',
                'resolutionOnTime',
                'resolutionBreached',
                'statusStatistics',
                'priorityStatistics',
                'categoryStatistics',
                'monthlyStatistics'
            )
        );
    }
}