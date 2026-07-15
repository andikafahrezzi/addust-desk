<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Ticket Statistics
        |--------------------------------------------------------------------------
        */

        $totalTickets = Ticket::count();

        $openTickets = Ticket::where(
            'status',
            'OPEN'
        )->count();

        $inProgressTickets = Ticket::where(
            'status',
            'IN_PROGRESS'
        )->count();

        $resolvedTickets = Ticket::where(
            'status',
            'RESOLVED'
        )->count();

        $closedTickets = Ticket::where(
            'status',
            'CLOSED'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | SLA Statistics
        |--------------------------------------------------------------------------
        */

        $responseOnTime = 0;
        $responseBreached = 0;

        $resolutionOnTime = 0;
        $resolutionBreached = 0;

        $tickets = Ticket::with('events')->get();

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
                'resolutionBreached'
            )
        );
    }
}