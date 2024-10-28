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

class TicketStatusUpdateEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket;
    public $new_status;
    public $activity;
    public function __construct(Ticket $ticket, int $new_status, string $activity)
    {
        $this->ticket = $ticket;
        $this->new_status = $new_status;
        $this->activity = $activity;
    }
}
