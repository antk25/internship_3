<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineTicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    public function save(Ticket $ticket): void
    {
        $this->_em->persist($ticket);
        $this->_em->flush();
    }
}
