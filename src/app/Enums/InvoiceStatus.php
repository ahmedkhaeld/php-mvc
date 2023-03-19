<?php

declare(strict_types=1);

namespace App\Enums;

class InvoiceStatus
{
    public const PENDING = 0;
    public const PAID = 1;
    public const VOID = 2;
    public const CANCELLED = 3;

    public static function all(): array
    {
        return [
            self::PENDING ,
            self::PAID ,
            self::VOID ,
            self::CANCELLED,
        ];
    }

}