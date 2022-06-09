<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Entity\FilmSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineFilmSessionRepository extends ServiceEntityRepository implements FilmSessionRepositoryInterface
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
