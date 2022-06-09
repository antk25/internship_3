<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Entity\Ticket;

interface TicketRepositoryInterface
{
    public function findById(string $id): ?Ticket;

    public function save(Ticket $ticket): void;
}
