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

class ForWasteTicketEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket;
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }
}
