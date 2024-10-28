<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketAssign extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'technician_id',
        'if_priority',
        'assigned_by',
    ];

    public function technician()
    {
        return  $this->belongsTo(User::class, 'technician_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function schedules()
    {
        return $this->hasOne(Schedule::class, 'ticket_assign_id');
    }
}
