<?php

namespace App\Domain\Booking\TransferObject;

use phpDocumentor\Reflection\Type;

final class FilmSessionDto
{
    public string $filmTitle;
    public int $filmDuration;
    public string $dateTimeStartFilmSession;
    public int $ticketsCount;

    /**
     * @param iterable<Type> $data
     */
    public function createFromArray(array $data): self
    {
        $dto = new self();

        $dto->filmTitle = $data['film'];
        $dto->filmDuration = $data['filmDuration'];
        $dto->dateTimeStartFilmSession = $data['dateTimeStart'];
        $dto->ticketsCount = $data['numberOfSeats'];

        return $dto;
    }
}
