<?php

namespace App\Listeners\Mail;

use App\Events\Logs\ForWasteTicketEvent;
use App\Events\Logs\CloseTicketEvent;
use App\Mail\ForWasteTicket;
use App\Models\TicketComplete;
use Illuminate\Support\Facades\Mail;

class MailForWasteTicketListener
{
    public function handle(ForWasteTicketEvent $event): void
    {
        $ticket = $event->ticket;
        TicketComplete::create([
            'ticket_assign_id' => $ticket->ticketAssign->id,
        ]);

        Mail::to($ticket->requestor->email)->send(new ForWasteTicket($ticket));
    }
}
