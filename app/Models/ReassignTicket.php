<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReassignTicket extends Model
{
    use HasFactory;
    protected $fillable = [
        'ticket_id',
        'from_technician',
        'to_technician',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function fromTechnician()
    {
        return $this->belongsTo(User::class, 'from_technician');
    }

    public function toTechnician()
    {
        return $this->belongsTo(User::class, 'to_technician');
    }
}
