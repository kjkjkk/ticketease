<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'requestor_id',
        'ticket_nature_id',
        'district_id',
        'department',
        'device_id',
        'brand',
        'model',
        'property_no',
        'serial_no',
        'details',
    ];

    public function ticketNature()
    {
        return $this->belongsTo(TicketNature::class, 'ticket_nature_id');
    }

    public function requestor()
    {
        return $this->belongsTo(User::class, 'requestor_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function ticketAssign()
    {
        return $this->hasOne(TicketAssign::class, 'ticket_id');
    }

    public function hasPendingReassignRequest()
    {
        return $this->reassignTickets()->whereNull('if_accepted')->exists();
    }

    public function reassignTickets()
    {
        return $this->hasMany(ReassignTicket::class, 'ticket_id');
    }

    public function mostRecentPendingReassignRequest()
    {
        return $this->reassignTickets()
            ->whereNull('if_accepted')  // Pending requests where if_accepted is null
            ->latest()                  // Get the most recent one based on the timestamp
            ->first();                  // Fetch a single record
    }

    public static function generateTicketNumber(): string
    {
        $year = now()->format('y'); // Get the last two digits of the current year
        $count = Ticket::whereYear('created_at', now()->year)->count() + 1;
        return $year . str_pad($count, 4, '0', STR_PAD_LEFT); // Format as 240001, 240002, etc.
    }
}
