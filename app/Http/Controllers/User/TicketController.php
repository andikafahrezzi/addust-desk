<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Priority;
use App\Http\Requests\StoreTicketRequest;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index()
{
    return "My Tickets";
}
public function create()
{
    $categories = Category::orderBy('name')->get();

    $priorities = Priority::orderBy('id')->get();

    return view('user.tickets.create', compact(
        'categories',
        'priorities'
    ));
}

   public function store(StoreTicketRequest $request)
{
    DB::transaction(function () use ($request) {

        $ticket = Ticket::create([

            'title' => $request->title,

            'category_id' => $request->category_id,

            'priority_id' => $request->priority_id,

            'status' => 'OPEN',

            'created_by' => Auth::id(),

            'current_department_id' => 1,

        ]);

        $ticket->update([

            'ticket_number' => sprintf(
                'TCK-%s-%06d',
                now()->year,
                $ticket->id
            ),

        ]);

        TicketMessage::create([

            'ticket_id' => $ticket->id,

            'sender_id' => Auth::id(),

            'message' => $request->description,

        ]);

    });

    return redirect()
        ->route('user.tickets.index')
        ->with(
            'success',
            'Ticket successfully created.'
        );
}
}