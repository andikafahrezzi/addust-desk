<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
    $tickets = Ticket::with([
            'category',
            'priority',
            'currentDepartment'
        ])
        ->where('created_by', Auth::id())
        ->latest()
        ->paginate(10);

    return view('tickets.index', compact('tickets'));
}
public function create()
{
    $categories = Category::orderBy('name')->get();

    $priorities = Priority::orderBy('id')->get();

    return view('tickets.create', compact(
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
public function show(Ticket $ticket)
{
    abort_if(
        $ticket->created_by !== Auth::id(),
        403
    );

    $ticket->load([
        'category',
        'priority',
        'currentDepartment',
        'currentHandler',
    ]);

$messages = $ticket->messages()
    ->with([
        'sender.role',
        'replyTo.sender.role',
    ])
    ->oldest()
    ->paginate(30);

    return view(
        'tickets.show',
        compact(
            'ticket',
            'messages'
        )
    );
}
public function storeMessage(Request $request, Ticket $ticket)
{
    abort_if(
        $ticket->created_by !== Auth::id(),
        403
    );

    if (in_array($ticket->status, [
        'RESOLVED',
        'CLOSED'
    ])) {
        abort(403);
    }

$validated = $request->validate([
    'message' => 'required|string|max:5000',

    'parent_message_id' => [
        'nullable',
        'exists:ticket_messages,id',
    ],
]);
if (!empty($validated['parent_message_id'])) {

    $parentMessage = TicketMessage::where('id', $validated['parent_message_id'])
        ->where('ticket_id', $ticket->id)
        ->first();

    abort_if(!$parentMessage, 403);

}

TicketMessage::create([
    'ticket_id' => $ticket->id,
    'sender_id' => Auth::id(),
    'parent_message_id' => $validated['parent_message_id'],
    'message' => $validated['message'],
]);
        return back()->with(
            'success',
            'Message sent.'
        );
    }
   public function updateMessage(
    Request $request,
    TicketMessage $message
)
{
    abort_if(
        $message->sender_id !== Auth::id(),
        403
    );

    abort_if(
        $message->ticket->status === 'CLOSED',
        403
    );

    $validated = $request->validate([
        'message' => [
            'required',
            'string',
            'max:5000',
        ],
    ]);

    $message->update([
        'message' => $validated['message'],
        'edited_at' => now(),
    ]);

    return back()->with(
        'success',
        'Message updated.'
    );
}
public function deleteMessage(
    TicketMessage $message
)
{
    abort_if(
        $message->sender_id !== Auth::id(),
        403
    );

    abort_if(
        $message->ticket->status === 'CLOSED',
        403
    );
$message->update([
    'message' => '[deleted]',
    'deleted_at' => now(),
    'deleted_by' => Auth::id(),
]);
  

    return back()->with(
        'success',
        'Message deleted.'
    );
}
}