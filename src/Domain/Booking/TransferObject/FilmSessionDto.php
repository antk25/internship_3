<?php

namespace App\Domain\Booking\TransferObject;

final class FilmSessionDto
{
    public string $filmName;
    public string $filmLength;
    public string $dateTimeStartFilmSession;
    public int $ticketsCount;
}
