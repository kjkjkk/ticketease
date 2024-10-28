<?php

namespace App\Enum;

enum Months: string
{
    case JANUARY = 'January';
    case FEBRUARY = 'February';
    case MARCH = 'March';
    case APRIL = 'April';
    case MAY = 'May';
    case JUNE = 'June';
    case JULY = 'July';
    case AUGUST = 'August';
    case SEPTEMBER = 'September';
    case OCTOBER = 'October';
    case NOVEMBER = 'November';
    case DECEMBER = 'December';

    public function value(): string
    {
        return match ($this) {
            self::JANUARY => "January",
            self::FEBRUARY => "February",
            self::MARCH => "March",
            self::APRIL => "April",
            self::MAY => "May",
            self::JUNE => "June",
            self::JULY => "July",
            self::AUGUST => "August",
            self::SEPTEMBER => "September",
            self::OCTOBER => "October",
            self::NOVEMBER => "November",
            self::DECEMBER => "December",
        };
    }

    // Function to return all months
    public static function all(): array
    {
        return array_map(fn($month) => $month->value(), self::cases());
    }
}
