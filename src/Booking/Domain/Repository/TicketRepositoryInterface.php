<?php

namespace App\Booking\Domain\Repository;

use App\Booking\Domain\Entity\Ticket;

interface TicketRepositoryInterface
{
    public function getById(string $id): Ticket;

    public function add(Ticket $ticket): void;
}
