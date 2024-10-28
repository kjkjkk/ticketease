<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Ticket;

class NotifyRequestorStatusUpdate implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;
    public $ticket;
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('ticket-status.' . $this->ticket->requestor_id);
    }
    public function broadcastAs()
    {
        return 'status-updated';
    }
    public function broadcastWith()
    {
        return ['ticket' => $this->ticket];
    }
}
