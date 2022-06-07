<?php

namespace App\Booking\Domain\Entity;

use App\Booking\Domain\ValueObject\Film;
use App\Booking\Services\UuidService;
use Doctrine\ORM\Mapping as ORM;

final class FilmSession
{
    #[ORM\Column(type: 'uuid')]
    #[ORM\Id]
    private string $id;

    #[ORM\Embedded(class: Film::class)]
    private readonly Film $film;

    #[ORM\Column(name: 'date_time_start', type: 'datetime_immutable')]
    private readonly \DateTimeInterface $dateTimeStartFilmSession;

    #[ORM\Column(name: 'tickets_count', type: 'integer')]
    private int $ticketsCount;

    #[ORM\Column(name: 'date_time_end', type: 'datetime_immutable')]
    private \DateTimeInterface $timeEndFilmSession;

    /**
     * @param mixed $ticketsCount
     *
     * @throws \Exception
     */
    public function __construct(
        Film $film,
        \DateTimeInterface $dateTimeStartFilmSession,
        int $ticketsCount,
    ) {
        $this->id = UuidService::generate();
        $this->film = $film;
        $this->dateTimeStartFilmSession = $dateTimeStartFilmSession;
        $this->ticketsCount = $ticketsCount;
        $this->timeEndFilmSession = $this->calcTimeEndFilmSession();
    }

    /**
     * @throws \Exception
     */
    public function getDateTimeStartFilmSession(): \DateTimeInterface
    {
        return $this->dateTimeStartFilmSession;
    }

    public function getTimeEndFilmSession(): \DateTimeImmutable
    {
        return $this->timeEndFilmSession;
    }

    /**
     * @throws \Exception
     */
    private function calcTimeEndFilmSession(): \DateTimeImmutable
    {
        $timeStart = $this->dateTimeStartFilmSession;

        return $timeStart->add($this->film->getFilmLength());
    }
}
