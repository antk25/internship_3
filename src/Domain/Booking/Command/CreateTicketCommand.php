<?php

namespace App\Domain\Booking\Command;

use App\Domain\Booking\Entity\FilmSession;

final class CreateTicketCommand
{
    public string $name;
    public int $phone;

    public function __construct(public readonly FilmSession $filmSession)
    {
    }
}
