<?php

namespace App\Booking\Domain\Service;

use App\Booking\Domain\Entity\FilmSession;
use App\Booking\Domain\Entity\ValueObject\Film;
use App\Booking\Domain\TransferObject\FilmSessionDto;

final class FilmSessionService
{
    private FilmSessionDto $filmSessionDto;

    /**
     * @throws \Exception
     */
    public function createFilmSession(FilmSessionDto $filmSessionDto): FilmSession
    {
        return new FilmSession(
            new Film($filmSessionDto->filmName, $filmSessionDto->filmLength),
            date_create_immutable($filmSessionDto->dateTimeStartFilmSession),
            $filmSessionDto->ticketsCount,
        );
    }
}
