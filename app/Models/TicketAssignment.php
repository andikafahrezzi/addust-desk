<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketAssignment extends Model
{
    protected $fillable = [
        'ticket_id',
        'assigned_to',
        'department_id',
        'assigned_by',
        'assigned_at',
        'ended_at',
    ];


    // Ticket yang berpindah ownership
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }


    // Agent yang menerima ownership
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'assigned_to'
        );
    }


    // Department pemilik queue saat itu
    public function department(): BelongsTo
    {
        return $this->belongsTo(
            Department::class
        );
    }


    // User yang melakukan assign
    public function assigner(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'assigned_by'
        );
    }
}