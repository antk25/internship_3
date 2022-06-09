<?php

namespace App\Booking\Domain\Repository;

use App\Booking\Domain\Entity\Ticket;

interface TicketRepositoryInterface
{
    public function findById(string $id): ?Ticket;

    public function save(Ticket $ticket): void;
}
