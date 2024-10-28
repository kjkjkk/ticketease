<?php

namespace App\Events\Admin;

use App\Enum\Notification;
use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifyAdminNewTicket implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $ticket;
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->message = Notification::NEW_TICKET->message($ticket->requestor->firstname);
    }
    public function broadcastOn()
    {
        return ['ticket-channel'];
    }
    public function broadcastAs()
    {
        return 'form-submitted';
    }

    public function broadcastWith()
    {
        return ['message' => $this->message];
    }
}
