<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Priority;
use App\Http\Requests\StoreTicketRequest;
use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\TicketEvent;
use App\Models\TicketAttachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
    ->where('status', '!=', 'CLOSED')
    ->latest()
    ->paginate(10);

    return view(
        'tickets.index',
        [
            'tickets' => $tickets,
            'isClosed' => false,
        ]
    );
}
public function closed()
{
    $tickets = Ticket::with([
        'category',
        'priority',
        'currentDepartment'
    ])
    ->where('created_by', Auth::id())
    ->where('status', 'CLOSED')
    ->latest()
    ->paginate(10);

    return view(
        'tickets.index',
        [
            'tickets' => $tickets,
            'isClosed' => true,
        ]
    );
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

        $priority = Priority::findOrFail(
            $request->priority_id
        );

        $now = now();

        $responseDueAt = $now
            ->copy()
            ->addMinutes(
                $priority->sla_response_minutes
            );

        $resolutionDueAt = $now
            ->copy()
            ->addMinutes(
                $priority->sla_resolution_minutes
            );

        $ticket = Ticket::create([

            'title' => $request->title,

            'category_id' => $request->category_id,

            'priority_id' => $request->priority_id,

            'response_sla_minutes'
                => $priority->sla_response_minutes,

            'resolution_sla_minutes'
                => $priority->sla_resolution_minutes,

            'response_due_at'
                => $responseDueAt,

            'resolution_due_at'
                => $resolutionDueAt,

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

        TicketEvent::create([

            'ticket_id' => $ticket->id,

            'performed_by' => Auth::id(),

            'event_type' => 'CREATED',

            'description' => Auth::user()->name .
                ' created this ticket.',

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
        'events.performedBy',
    ]);

$messages = $ticket->messages()
    ->with([
        'sender.role',
        'replyTo.sender.role',
        'attachments',
    ])
    ->oldest()
    ->paginate(30);
    $messageStoreRoute = route(
    'user.tickets.messages.store',
    $ticket
);
$messageUpdateRouteName =
    'user.tickets.messages.update';

$messageDeleteRouteName =
    'user.tickets.messages.delete';
$attachmentDownloadRouteName =
    'user.attachments.download';

$canReply = true;

    return view(
    'tickets.show',
    compact(
        'ticket',
        'messages',
        'messageStoreRoute',
        'canReply',
        'messageUpdateRouteName',
        'messageDeleteRouteName',
        'attachmentDownloadRouteName'
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
        'attachments' => [
        'nullable',
        'array',
    ],

    'attachments.*' => [
        'file',
        'max:10240',
        'mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,txt,zip',
    ]
]);
if (!empty($validated['parent_message_id'])) {

    $parentMessage = TicketMessage::where('id', $validated['parent_message_id'])
        ->where('ticket_id', $ticket->id)
        ->first();

    abort_if(!$parentMessage, 403);

}

$message = TicketMessage::create([
    'ticket_id' => $ticket->id,
    'sender_id' => Auth::id(),
    'parent_message_id' => $validated['parent_message_id'] ?? null,
    'message' => $validated['message'],
]);
if ($request->hasFile('attachments')) {

    foreach ($request->file('attachments') as $file) {

        $storedName = uniqid('', true) . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs(
            'ticket-attachments',
            $storedName,
            'public'
        );

        TicketAttachment::create([

            'ticket_id' => $ticket->id,

            'message_id' => $message->id,

            'uploaded_by' => Auth::id(),

            'file_name' => $storedName,

            'original_name' => $file->getClientOriginalName(),

            'file_path' => $path,

            'mime_type' => $file->getMimeType(),

            'file_size' => $file->getSize(),

        ]);

    }

}
        return back()->with(
            'success',
            'Message sent.'
        );
    }
    public function downloadAttachment(
    TicketAttachment $attachment
)
{
    $ticket = $attachment->ticket;

    abort_if(
        $ticket->created_by !== Auth::id(),
        403
    );

    if (!Storage::disk('public')->exists($attachment->file_path)) {
        abort(404);
    }

/**
 * @var FilesystemManager $storage
 */
$storage = Storage::disk('public');
    return Storage::disk('public')->download(
        $attachment->file_path,
        $attachment->original_name
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
public function reopen(Ticket $ticket)
{
    abort_if(
        $ticket->created_by !== Auth::id(),
        403
    );

    abort_if(
        $ticket->status !== 'RESOLVED',
        403
    );

    $ticket->update([

        'status' => 'IN_PROGRESS',

    ]);

    TicketEvent::create([

        'ticket_id' => $ticket->id,

        'performed_by' => Auth::id(),

        'event_type' => 'REOPENED',

        'description' => Auth::user()->name .
            ' reopened this ticket.',

    ]);

    return back()->with(
        'success',
        'Ticket has been reopened.'
    );
}
public function close(Ticket $ticket)
{
    abort_if(
        $ticket->created_by !== Auth::id(),
        403
    );

    abort_if(
        $ticket->status !== 'RESOLVED',
        403
    );

    $ticket->update([

        'status' => 'CLOSED',

        'closed_at' => now(),

    ]);

    TicketEvent::create([

        'ticket_id' => $ticket->id,

        'performed_by' => Auth::id(),

        'event_type' => 'CLOSED',

        'description' => Auth::user()->name .
            ' closed this ticket.',

    ]);

    return back()->with(
        'success',
        'Ticket has been closed.'
    );
}
}