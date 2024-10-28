<?php

namespace App\Listeners\Technician;

use App\Events\Technician\NotifyTechnicianReassignEvent;
use App\Models\Notification;

class NotificationReassignTicketListener
{
    public function handle(NotifyTechnicianReassignEvent $event): void
    {
        $ticketReassign = $event->ticketReassign;

        if ($event->action === "REQUEST") {
            $action = " requested to reassign ticket";
            $user_id = $ticketReassign->toTechnician->id;
            $tech = $ticketReassign->fromTechnician->lastname;
            $title = "Ticket Reassign";
            $icon = "REASSIGN";
        } elseif ($event->action === "ACCEPT") {
            $action = " accepted your reassign request";
            $user_id = $ticketReassign->fromTechnician->id;
            $tech = $ticketReassign->toTechnician->lastname;
            $title = "Reassign Accepted";
            $icon = "ACCEPT";
        } elseif ($event->action === "REJECT") {
            $action = " rejected your reassign request";
            $user_id = $ticketReassign->fromTechnician->id;
            $tech = $ticketReassign->toTechnician->lastname;
            $title = "Reassign Rejected";
            $icon = "REJECT";
        } else {
            return;
        }

        Notification::create([
            'user_id' => $user_id,
            'title' => $title,
            'message' => "Tech. " . $tech . $action,
            'icon' => $icon,
        ]);
    }
}
