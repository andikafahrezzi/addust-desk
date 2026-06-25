<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_number',
        'title',
        'category_id',
        'priority_id',
        'status',
        'created_by',
        'current_department_id',
        'current_handler_id',
        'resolved_by',
        'resolved_at',
        'closed_at',
    ];


    // User yang membuat tiket
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    // Agent yang sedang menangani tiket
    public function currentHandler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'current_handler_id');
    }


    // Agent yang menyelesaikan tiket
    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }


    // Kategori tiket
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    // Prioritas tiket
    public function priority(): BelongsTo
    {
        return $this->belongsTo(Priority::class);
    }


    // Department yang sedang bertanggung jawab
    public function currentDepartment(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'current_department_id');
    }


    // Percakapan dalam tiket
    public function messages(): HasMany
    {
        return $this->hasMany(TicketMessage::class);
    }


    // Timeline aktivitas tiket
    public function events(): HasMany
    {
        return $this->hasMany(TicketEvent::class);
    }


    // Riwayat ownership tiket
    public function assignments(): HasMany
    {
        return $this->hasMany(TicketAssignment::class);
    }


    // File yang menempel pada tiket
    public function attachments(): HasMany
    {
        return $this->hasMany(TicketAttachment::class);
    }
}