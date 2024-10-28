<?php

namespace App\Listeners\Admin;

use App\Events\Admin\NotifyAdminNewTicket;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotificationNewTicketListener
{
    public function handle(NotifyAdminNewTicket $event): void
    {
        $ticket = $event->ticket;
        $admins = User::where('role', '=', "Admin")->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => "New ticket",
                'message' => "A " . $ticket->ticketNature->ticket_nature_name . " is submitted by " . $ticket->requestor->lastname,
                'icon' => "SUBMIT",
            ]);
        }
    }
}
