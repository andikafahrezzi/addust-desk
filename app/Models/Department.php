<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function currentTickets()
{
    return $this->hasMany(
        Ticket::class,
        'current_department_id'
    );
}

public function assignments()
{
    return $this->hasMany(
        TicketAssignment::class
    );
}
}