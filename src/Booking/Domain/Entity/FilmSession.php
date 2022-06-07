<?php

namespace App\Booking\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

final class FilmSession
{
    #[ORM\Column(type: 'uuid')]
    #[ORM\Id]
    private Uuid $id;

    private readonly Film $film;

    #[ORM\Column(name: 'date_time_start', type: 'datetime_immutable')]
    private readonly \DateTimeInterface $dateTimeStartFilmSession;

    #[ORM\Column(name: 'tickets_count', type: 'integer')]
    private int $ticketsCount;

    #[ORM\Column(name: 'date_time_end', type: 'datetime_immutable')]
    private \DateTimeInterface $timeEndFilmSession;

    /**
     * @throws \Exception
     */
    public function __construct(
        Film $film,
        \DateTimeInterface $dateTimeStartFilmSession,
        $ticketsCount,
    ) {
        $this->id = Uuid::v4();
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
