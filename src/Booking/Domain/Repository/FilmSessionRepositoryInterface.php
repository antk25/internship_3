<?php

namespace App\Booking\Domain\Repository;

use App\Booking\Domain\Entity\FilmSession;

interface FilmSessionRepositoryInterface
{
    public function getById(string $id): FilmSession;

    public function update(FilmSession $filmSession): void;
}
