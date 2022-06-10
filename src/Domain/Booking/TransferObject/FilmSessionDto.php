<?php

namespace App\Domain\Booking\TransferObject;

final class FilmSessionDto
{
    public string $filmName;
    public int $filmLength;
    public string $dateTimeStartFilmSession;
    public int $ticketsCount;
}
