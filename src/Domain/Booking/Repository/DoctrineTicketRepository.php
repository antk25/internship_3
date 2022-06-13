<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineTicketRepository extends ServiceEntityRepository implements TicketRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    public function findById(string $id): Ticket
    {
        return $this->find($id);
    }

    public function save(Ticket $ticket): void
    {
        $this->_em->persist($ticket);
        $this->_em->flush();
    }
}
