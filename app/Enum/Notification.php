<?php

namespace App\Enum;

enum Notification
{
        // For admin
    case NEW_TICKET;

        // For technicians
    case TECHNICIAN_ASSIGN;
    case TECHNICIAN_REASSIGN;
    case REASSIGN_ACCEPT;
    case REASSIGN_REJECT;
    case OPEN_TICKET;

        // For requestors
    case REQUESTOR_ASSIGN;
    case TO_WASTE;
    case TO_CITC;
    case CLOSED;

    public function message(string $extraInfo = ''): string
    {
        return match ($this) {
            // extraInfo => requestor name
            self::NEW_TICKET => "A new ticket has been submitted by " . $extraInfo,
            // extraInfo => ticket nature
            self::TECHNICIAN_ASSIGN => "A " . $extraInfo . " ticket has been assigned to you.",
            // extraInfo => from technician name
            self::TECHNICIAN_REASSIGN => "Tech. " . $extraInfo . " requested to reassign a ticket to you.",
            // extraInfo => to technician
            self::REASSIGN_ACCEPT => "Tech. " . $extraInfo . " accepted your reassign request.",
            self::REASSIGN_REJECT => "Tech. " . $extraInfo . " rejected your reassign request.",

            self::REQUESTOR_ASSIGN => "Your " . $extraInfo . " ticket has been assigned.",
            self::TO_WASTE => "The ticket has been marked as waste",
            self::TO_CITC => "The ticket has been transferred to CITC",
            self::CLOSED => "The ticket has been closed",
        };
    }
}
