<?php

namespace App\Domain\Booking\Repository;

use App\Domain\Booking\Entity\FilmSession;

interface FilmSessionRepositoryInterface
{
    public function save(FilmSession $filmSession): void;
}
