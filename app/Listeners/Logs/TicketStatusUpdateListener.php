<?php

namespace App\Listeners\Logs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\Logs\TicketStatusUpdateEvent;
use App\Models\Audit;
use App\Models\StatusReason;
use App\Enum\AuditActivity;
use App\Models\TicketComplete;

class TicketStatusUpdateListener
{
    public function handle(TicketStatusUpdateEvent $event): void
    {
        $ticket = $event->ticket;

        Audit::create([
            'ticket_id' => $ticket->id,
            'activity' => $event->activity,
            'previous_status_id' => $ticket->status_id,
            'new_status_id' => $event->new_status,
        ]);

        if ($event->new_status == AuditActivity::FOR_WASTE->id()) {
            StatusReason::create(
                [
                    'ticket_id' => $ticket->id,
                ]
            );
            TicketComplete::create(
                [
                    'ticket_assign_id' => $ticket->ticketAssign->id,
                ]
            );
        }

        if ($event->new_status == AuditActivity::TO_CITC->id()) {
            StatusReason::create(
                [
                    'ticket_id' => $ticket->id,
                ]
            );
        }
    }
}
