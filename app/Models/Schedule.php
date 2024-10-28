<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_assign_id',
        'comments',
        'start_time',
        'end_time',
    ];

    protected $dates = ['start_time', 'end_time'];

    public function ticketAssign()
    {
        return $this->belongsTo(TicketAssign::class, 'ticket_assign_id');
    }

    protected static function booted()
    {
        static::created(function ($schedule) {
            $ticketAssign = TicketAssign::find($schedule->ticket_assign_id);
            if ($ticketAssign) {
                $ticketAssign->update(['if_scheduled' => 1]);
            }
        });
    }
}
