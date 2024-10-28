<?php

namespace App\Events\Logs;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Models\Ticket;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CloseTicketEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket;
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }
}
