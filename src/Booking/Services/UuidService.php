<?php

namespace App\Booking\Services;

use Symfony\Component\Uid\Uuid;

class UuidService
{
    public static function generate(): string
    {
        return Uuid::v4();
    }
}
