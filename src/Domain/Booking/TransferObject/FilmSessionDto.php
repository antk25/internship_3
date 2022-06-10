<?php

namespace App\Domain\Booking\TransferObject;

use phpDocumentor\Reflection\Type;

final class FilmSessionDto
{
    public string $filmName;
    public int $filmLength;
    public string $dateTimeStartFilmSession;
    public int $ticketsCount;

    /**
     * @param iterable<Type> $data
     */
    public function createFromArray(array $data): self
    {
        $dto = new self();

        $dto->filmName = $data['film'];
        $dto->filmLength = $data['filmLength'];
        $dto->dateTimeStartFilmSession = $data['dateTimeStart'];
        $dto->ticketsCount = $data['numberOfSeats'];

        return $dto;
    }
}
