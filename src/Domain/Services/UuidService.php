<?php

namespace App\Domain\Services;

use Symfony\Component\Uid\Uuid;

final class UuidService
{
    public static function generate(): string
    {
        return Uuid::v4();
    }
}
