<?php

namespace App\Booking\Infrastructure\Repository;

use App\Booking\Domain\Repository\TicketRepositoryInterface;
use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TicketRepository extends ServiceEntityRepository implements TicketRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    public function add(Ticket $ticket): void
    {
        $this->_em->persist($ticket);
        $this->_em->flush();
    }

    public function getById(string $id): Ticket
    {
        return $this->find($id);
    }
}
