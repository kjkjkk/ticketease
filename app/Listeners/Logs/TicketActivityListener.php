<?php

namespace App\Listeners\Logs;

use App\Events\Logs\TicketActivityEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Audit;

class TicketActivityListener
{
    public function handle(TicketActivityEvent $event): void
    {
        $ticket = $event->ticket;
        Audit::create([
            'ticket_id' => $ticket->id,
            'activity' => $event->activity,
            'previous_status_id' => $ticket->status_id,
            'new_status_id' => $ticket->status_id,
        ]);
    }
}
