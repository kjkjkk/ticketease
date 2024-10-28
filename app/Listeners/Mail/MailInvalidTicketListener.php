<?php

namespace App\Listeners\Mail;

use App\Events\Logs\InvalidTicketEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\StatusReason;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvalidTicket;

class MailInvalidTicketListener
{

    public function handle(InvalidTicketEvent $event): void
    {
        $ticket = $event->ticket;

        StatusReason::create([
            'ticket_id' => $ticket->id,
            'reason' => $event->reason,
        ]);

        Mail::to($ticket->requestor->email)->send(new InvalidTicket($ticket, $event->reason));
    }
}
