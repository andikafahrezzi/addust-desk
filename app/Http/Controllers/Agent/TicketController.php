<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\TicketMessage;
use App\Models\TicketAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
public function index(): View
{
    $tickets = Ticket::query()
        ->with([
            'category',
            'priority',
            'creator',
            'currentHandler',
        ])
        ->where(
            'current_department_id',
            Auth::user()->department_id
        )
        ->latest()
        ->paginate(20);

    return view(
        'agent.tickets.index',
        compact('tickets')
    );
}
public function claim(Ticket $ticket)
{
    abort_if(
        $ticket->current_department_id !== Auth::user()->department_id,
        403
    );

    DB::transaction(function () use ($ticket) {

        $ticket->refresh();

        if (
            $ticket->current_handler_id !== null ||
            $ticket->status !== 'OPEN'
        ) {
            abort(403, 'Ticket has already been claimed.');
        }

        $ticket->update([

            'current_handler_id' => Auth::id(),

            'status' => 'IN_PROGRESS',

        ]);

    });

    return back()->with(
        'success',
        'Ticket claimed successfully.'
    );
}
public function show(Ticket $ticket): View
{
    abort_if(
        $ticket->current_department_id !== Auth::user()->department_id,
        403
    );

    $ticket->load([
        'category',
        'priority',
        'currentDepartment',
        'currentHandler',
        'creator',
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
    'agent.tickets.messages.store',
    $ticket
);

$canReply = (
    $ticket->current_handler_id === Auth::id()
);
$messageUpdateRouteName =
    'agent.tickets.messages.update';

$messageDeleteRouteName =
    'agent.tickets.messages.delete';
$attachmentDownloadRouteName =
    'agent.attachments.download';

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
public function storeMessage(
    Request $request,
    Ticket $ticket
)
{
    abort_if(
        $ticket->current_department_id !== Auth::user()->department_id,
        403
    );

    abort_if(
        $ticket->current_handler_id !== Auth::id(),
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
        ],

    ]);

    if (!empty($validated['parent_message_id'])) {

        $parentMessage = TicketMessage::where(
                'id',
                $validated['parent_message_id']
            )
            ->where(
                'ticket_id',
                $ticket->id
            )
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

            $storedName = uniqid() . '_' . $file->getClientOriginalName();

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
public function updateMessage(
    Request $request,
    TicketMessage $message
)
{
    $ticket = $message->ticket;

    abort_if(
        $ticket->current_department_id !== Auth::user()->department_id,
        403
    );

    abort_if(
        $ticket->current_handler_id !== Auth::id(),
        403
    );

    abort_if(
        $message->sender_id !== Auth::id(),
        403
    );

    abort_if(
        $message->deleted_at,
        403
    );

    abort_if(
        $ticket->status === 'CLOSED',
        403
    );

    $validated = $request->validate([
        'message' => 'required|string|max:5000',
    ]);

    $message->update([
        'message' => $validated['message'],
        'edited_at' => Carbon::now(),
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
    $ticket = $message->ticket;

    abort_if(
        $ticket->current_department_id !== Auth::user()->department_id,
        403
    );

    abort_if(
        $ticket->current_handler_id !== Auth::id(),
        403
    );

    abort_if(
        $message->sender_id !== Auth::id(),
        403
    );

    abort_if(
        $ticket->status === 'CLOSED',
        403
    );

    $message->update([
        'deleted_at' => now(),
        'deleted_by' => Auth::id(),
    ]);

    return back()->with(
        'success',
        'Message deleted.'
    );
}
public function downloadAttachment(
    TicketAttachment $attachment
)
{
    $ticket = $attachment->ticket;

    abort_if(
        $ticket->current_department_id !== Auth::user()->department_id,
        403
    );

    abort_if(
        !Storage::disk('public')->exists($attachment->file_path),
        404
    );
    
    abort_if(
    $attachment->message &&
    $attachment->message->deleted_at,
    404
);

    return Storage::disk('public')->download(
        $attachment->file_path,
        $attachment->original_name
    );
}
}