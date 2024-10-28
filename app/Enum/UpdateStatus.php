<?php

namespace App\Enum;

enum UpdateStatus
{
    case IN_PROGRESS;
    case REPAIRED;
        // case TO_CITC;
    case FOR_RELEASE;

    public function value(): string
    {
        return match ($this) {
            self::IN_PROGRESS => "In Progress",
            self::REPAIRED => "Repaired",
            //self::TO_CITC => "To CITC",
            self::FOR_RELEASE => "For Release",
        };
    }

    public function id(): int
    {
        return match ($this) {
            self::IN_PROGRESS => 3,
            self::REPAIRED => 4,
            //self::TO_CITC => 6,
            self::FOR_RELEASE => 7,
        };
    }
}
