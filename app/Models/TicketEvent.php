<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketEvent extends Model
{
    protected $fillable = [
        'ticket_id',
        'performed_by',
        'event_type',
        'description',
    ];


    // Ticket yang memiliki event
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }


    // User yang melakukan aksi
    public function performer(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'performed_by'
        );
    }
        public function performedBy(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'performed_by'
        );
    }
}