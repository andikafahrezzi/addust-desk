<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }


    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    // Ticket yang dibuat oleh user
public function createdTickets(): HasMany
{
    return $this->hasMany(Ticket::class, 'created_by');
}


// Ticket yang sedang ditangani agent
public function handlingTickets(): HasMany
{
    return $this->hasMany(Ticket::class, 'current_handler_id');
}


// Ticket yang telah diselesaikan agent
public function resolvedTickets(): HasMany
{
    return $this->hasMany(Ticket::class, 'resolved_by');
}
public function sentMessages(): HasMany
{
    return $this->hasMany(
        TicketMessage::class,
        'sender_id'
    );
}

public function uploadedAttachments(): HasMany
{
    return $this->hasMany(
        TicketAttachment::class,
        'uploaded_by'
    );
}

public function performedEvents(): HasMany
{
    return $this->hasMany(
        TicketEvent::class,
        'performed_by'
    );
}

public function receivedAssignments(): HasMany
{
    return $this->hasMany(
        TicketAssignment::class,
        'assigned_to'
    );
}

public function givenAssignments(): HasMany
{
    return $this->hasMany(
        TicketAssignment::class,
        'assigned_by'
    );
}

public function auditLogs(): HasMany
{
    return $this->hasMany(
        AuditLog::class
    );
}
}
