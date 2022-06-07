<?php

namespace App\Booking\Domain\Command;

use App\Booking\Domain\Entity\FilmSession;
use App\Booking\Domain\Entity\ValueObject\Client;

final class CreateTicketCommand
{
    public function __construct(
        public readonly FilmSession $filmSession,
        public readonly Client $client,
    ) {
    }
}
