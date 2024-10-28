<?php

namespace App\Events\Technician;

use App\Enum\Notification;
use App\Models\ReassignTicket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifyTechnicianReassignEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticketReassign;
    public $message;
    public $action;
    public $receiver;

    public function __construct(ReassignTicket $ticketReassign, $message, $action)
    {
        $this->ticketReassign = $ticketReassign;
        $this->message = $message;
        $this->action = $action;
        if ($action === "REQUEST") {
            $this->receiver = $ticketReassign->toTechnician->id;
        } elseif ($action === "REJECT" || $action === "ACCEPT") {
            $this->receiver = $ticketReassign->fromTechnician->id;
        } else {
            return;
        }
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('ticket-reassign.' . $this->receiver);  // toTechnician ID
    }

    public function broadcastAs()
    {
        return 'reassign-technician';
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
        ];
    }
}
