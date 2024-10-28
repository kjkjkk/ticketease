<?php

namespace App\Enum;

enum AuditActivity: string
{
    case UNASSIGNED = "unassigned";
    case ASSIGNED = "assigned";
    case IN_PROGRESS = "in_progress";
    case REPAIRED = "repaired";
    case FOR_WASTE = "for_waste";
    case TO_CITC = "to_citc";
    case FOR_RELEASE = "for_release";
    case INVALID = "invalid";
    case CLOSED = "closed";

    // Method to get the corresponding activity statement
    public function activity(): string
    {
        return match ($this) {
            self::UNASSIGNED => "The ticket has not been assigned yet.",
            self::ASSIGNED => "The ticket has been assigned.",
            self::IN_PROGRESS => "The ticket is currently in progress.",
            self::REPAIRED => "The ticket status has been updated to Repaired.",
            self::FOR_WASTE => "The ticket has been marked as For Waste.",
            self::TO_CITC => "The ticket status has been updated to To CITC.",
            self::FOR_RELEASE => "The ticket status has been updated to For Release.",
            self::INVALID => "The ticket has been marked as Invalid.",
            self::CLOSED => "The ticket has been makeded as Closed.",
        };
    }

    public function id(): int
    {
        return match ($this) {
            self::UNASSIGNED => 1,
            self::ASSIGNED => 2,
            self::IN_PROGRESS => 3,
            self::REPAIRED => 4,
            self::FOR_WASTE => 5,
            self::TO_CITC => 6,
            self::FOR_RELEASE => 7,
            self::INVALID => 9,
            self::CLOSED => 10,
        };
    }

    public static function fromId(int $id): ?AuditActivity
    {
        return match ($id) {
            1 => self::UNASSIGNED,
            2 => self::ASSIGNED,
            3 => self::IN_PROGRESS,
            4 => self::REPAIRED,
            5 => self::FOR_WASTE,
            6 => self::TO_CITC,
            7 => self::FOR_RELEASE,
            9 => self::INVALID,
            10 => self::CLOSED,
            default => null, // Handle invalid ID
        };
    }
}
