<?php

namespace App\Booking\Domain\Repository;

use App\Booking\Domain\Entity\FilmSession;

interface FilmSessionRepositoryInterface
{
    public function findById(string $id): ?FilmSession;

    public function save(FilmSession $filmSession): void;
}
