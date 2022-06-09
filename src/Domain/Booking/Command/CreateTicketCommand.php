<?php

namespace App\Domain\Booking\Command;

use App\Domain\Booking\Entity\FilmSession;
use App\Domain\Booking\Entity\ValueObject\Client;

final class CreateTicketCommand
{
    public function __construct(
        public readonly FilmSession $filmSession,
        public readonly Client $client,
    ) {
    }
}
