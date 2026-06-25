<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Priority extends Model
{
    protected $fillable = [
        'name',
        'sla_response_minutes',
        'sla_resolution_minutes'
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}