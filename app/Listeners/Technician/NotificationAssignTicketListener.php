<?php

namespace App\Listeners\Technician;

use App\Events\NotifyTechnicianAssignTicket;
use App\Events\Technician\NotifyTechnicianAssignEvent;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotificationAssignTicketListener
{
    public function handle(NotifyTechnicianAssignEvent $event): void
    {
        $ticketAssign = $event->ticketAssign;
        Notification::create([
            'user_id' => $ticketAssign->technician_id,
            'title' => "Ticket Assigned",
            'message' => "A " . $ticketAssign->ticket->ticketNature->ticket_nature_name . " has been assigned to you.",
            'icon' => "ASSIGN",
        ]);
    }
}
