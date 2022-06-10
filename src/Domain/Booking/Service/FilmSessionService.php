<?php

namespace App\Domain\Booking\Service;

use App\Domain\Booking\Entity\FilmSession;
use App\Domain\Booking\Entity\ValueObject\Film;
use App\Domain\Booking\TransferObject\FilmSessionDto;
use Symfony\Component\Uid\Uuid;

final class FilmSessionService
{
    private FilmSessionDto $filmSessionDto;

    /**
     * @throws \Exception
     */
    public function createFilmSession(FilmSessionDto $filmSessionDto): FilmSession
    {
        return new FilmSession(
            Uuid::v4(),
            new Film($filmSessionDto->filmName, \DateInterval::createFromDateString($filmSessionDto->filmLength . 'minutes')),
            date_create_immutable($filmSessionDto->dateTimeStartFilmSession),
            $filmSessionDto->ticketsCount,
        );
    }
}
