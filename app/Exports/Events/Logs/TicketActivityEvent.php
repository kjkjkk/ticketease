<?php

namespace App\Events\Logs;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Ticket;

class TicketActivityEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket;
    public $activity;
    public function __construct(Ticket $ticket, $activity)
    {
        $this->ticket = $ticket;
        $this->activity = $activity;
    }
}
