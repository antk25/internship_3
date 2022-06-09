<?php

namespace App\Repository;

use App\Booking\Domain\Entity\FilmSession;
use App\Booking\Domain\Repository\FilmSessionRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class FilmSessionRepository extends ServiceEntityRepository implements FilmSessionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FilmSession::class);
    }

    public function findById(string $id): FilmSession
    {
        return $this->find($id);
    }

    public function save(FilmSession $filmSession): void
    {
        $this->_em->persist($filmSession);
        $this->_em->flush();
    }
}
