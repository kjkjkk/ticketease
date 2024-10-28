<?php

namespace App\Events\Technician;

use App\Enum\Notification;
use App\Models\TicketAssign;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifyTechnicianAssignEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticketAssign;
    public $message;

    public function __construct(TicketAssign $ticketAssign)
    {
        $this->ticketAssign = $ticketAssign;
        $this->message = Notification::TECHNICIAN_ASSIGN->message($ticketAssign->ticket->ticketNature->ticket_nature_name);
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('ticket-assign.' . $this->ticketAssign->technician_id);
    }
    public function broadcastAs()
    {
        return 'assign-technician';
    }

    public function broadcastWith()
    {
        return ['message' => $this->message];
    }
}
