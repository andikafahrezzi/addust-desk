<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketMessage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ticket_id',
        'sender_id',
        'message',
        'parent_message_id',
        'edited_at',
    ];


    // Ticket induk
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }


    // Pengirim pesan
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }


    // Pesan yang di-reply
    public function parentMessage(): BelongsTo
    {
        return $this->belongsTo(
            TicketMessage::class,
            'parent_message_id'
        );
    }

public function replyTo(): BelongsTo
{
    return $this->belongsTo(
        TicketMessage::class,
        'parent_message_id'
    );
}
    // Balasan dari pesan ini
    public function replies(): HasMany
    {
        return $this->hasMany(
            TicketMessage::class,
            'parent_message_id'
        );
    }


    // Attachment pada pesan
    public function attachments(): HasMany
    {
        return $this->hasMany(
            TicketAttachment::class,
            'message_id'
        );
    }
}