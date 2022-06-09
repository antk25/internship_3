<?php

namespace App\Domain\Booking\Factory;

use App\Domain\Booking\TransferObject\FilmSessionDto;

final class CreateFilmSessionDtoFactory
{
    /**
     * @param array<mixed> $data
     */
    public function createFromArray(array $data): FilmSessionDto
    {
        $dto = new FilmSessionDto();

        $dto->filmName = $data['film'];
        $dto->filmLength = $data['filmLength'];
        $dto->dateTimeStartFilmSession = $data['dateTimeStart'];
        $dto->ticketsCount = $data['numberOfSeats'];

        return $dto;
    }
}
