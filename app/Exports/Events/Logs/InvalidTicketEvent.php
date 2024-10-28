<?php

namespace App\Events\Logs;

use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvalidTicketEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket;
    public $reason;
    public function __construct(Ticket $ticket, string $reason)
    {
        $this->ticket = $ticket;
        $this->reason = $reason;
        //dd($reason);
    }
}
