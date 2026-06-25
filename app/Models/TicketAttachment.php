<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketAttachment extends Model
{
    protected $fillable = [
        'ticket_id',
        'message_id',
        'uploaded_by',
        'file_name',
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
    ];


    // Ticket pemilik attachment
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }


    // Pesan tempat file dikirim
    public function message(): BelongsTo
    {
        return $this->belongsTo(
            TicketMessage::class,
            'message_id'
        );
    }


    // User yang upload file
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'uploaded_by'
        );
    }
}