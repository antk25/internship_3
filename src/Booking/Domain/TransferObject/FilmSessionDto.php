<?php

namespace App\Booking\Domain\TransferObject;

final class FilmSessionDto
{
    public string $filmName;
    public string $filmLength;
    public string $dateTimeStartFilmSession;
    public int $ticketsCount;
}
