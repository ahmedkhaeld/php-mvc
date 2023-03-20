<?php

declare(strict_types=1);

namespace App\Enums;

enum InvoiceStatus: int
{
    case PENDING = 0;
    case PAID = 1;
    case VOID = 2;
    case CANCELLED = 3;

    //this method will return the status as string
    public function toString(): string
    {
        return match ($this) {
            self::PAID => 'Paid',
            self::VOID => 'Void',
            self::CANCELLED => 'Cancelled',
            default => 'Pending',
        };
    }

    public function color():Color
    {
        return match ($this) {
            self::PAID => Color::Green,
            self::VOID => Color::Red,
            self::CANCELLED => Color::Gray,
            default => Color::Orange,
        };
    }

    public function fromColor(Color $color):InvoiceStatus
    {
        return match ($color) {
            self::PAID =>self::PAID,
            self::VOID => self::VOID,
            self::CANCELLED => self::CANCELLED,
            default => self::PENDING
        };
    }


}
