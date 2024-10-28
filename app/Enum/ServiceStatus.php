<?php

namespace App\Enum;

enum ServiceStatus
{
    const COMPLETE = 'Complete';
    const INCOMPLETE = 'Incomplete';
    const PENDING_FOR_SPARES = 'Pending for spares';
    const UNDER_OBSERVATION = 'Under observation';
    const WORKING_SOLUTION_PROVIDED = 'Working solution provided';

    public static function values(): array
    {
        return [
            self::COMPLETE,
            self::INCOMPLETE,
            self::PENDING_FOR_SPARES,
            self::UNDER_OBSERVATION,
            self::WORKING_SOLUTION_PROVIDED,
        ];
    }
}
