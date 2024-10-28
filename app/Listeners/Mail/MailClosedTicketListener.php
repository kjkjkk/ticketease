<?php

namespace App\Listeners\Mail;

use App\Enum\AuditActivity;
use App\Events\Logs\CloseTicketEvent;
use App\Mail\CompleteTicket;
use App\Models\TicketComplete;
use Illuminate\Support\Facades\Mail;

class MailClosedTicketListener
{

    public function handle(CloseTicketEvent $event): void
    {
        $ticket = $event->ticket;
        TicketComplete::create([
            'ticket_assign_id' => $ticket->ticketAssign->id,
        ]);

        Mail::to($ticket->requestor->email)->send(new CompleteTicket($ticket));
    }
}
