<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Entity\ValueObject\Client;
use App\Domain\Booking\Entity\ValueObject\Film;
use App\Domain\Booking\Repository\DoctrineFilmSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: DoctrineFilmSessionRepository::class)]
#[ORM\Table(name: 'film_sessions')]
final class FilmSession
{
    #[ORM\Column(type: 'uuid')]
    #[ORM\Id]
    private Uuid $id;

    #[ORM\Embedded(class: Film::class, columnPrefix: 'film_')]
    private readonly Film $film;

    #[ORM\Column(name: 'date_time_start', type: 'datetime_immutable')]
    private readonly \DateTimeInterface $dateTimeStartFilmSession;

    #[ORM\Column(name: 'tickets_count', type: 'integer')]
    private int $ticketsCount;

    #[ORM\OneToMany(mappedBy: 'filmSession', targetEntity: Ticket::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $tickets;

    /**
     * @param mixed $ticketsCount
     */
    public function __construct(
        Uuid $id,
        Film $film,
        \DateTimeInterface $dateTimeStartFilmSession,
        int $ticketsCount,
    ) {
        $this->id = $id;
        $this->film = $film;
        $this->dateTimeStartFilmSession = $dateTimeStartFilmSession;
        $this->ticketsCount = $ticketsCount;
        $this->tickets = new ArrayCollection();
    }

    /**
     * @throws \Exception
     */
    public function bookTicket(Client $client): FilmSession
    {
        if ($this->checkTicketsAvail()) {
            throw new \Exception('No more tickets');
        }

        $ticketId = Uuid::v4();

        $ticket = new Ticket($ticketId, $client, $this);

        $this->tickets->add($ticket);

        $this->ticketsCount--;

        return $this;
    }

    public function getCountOfTicketsAvailable(): int
    {
        return $this->ticketsCount;
    }

    public function getDateTimeStartFilmSession(): \DateTimeInterface
    {
        return $this->dateTimeStartFilmSession;
    }

    public function getFilmTitle(): string
    {
        return $this->film->getTitle();
    }

    public function getFilmDuration(): \DateInterval
    {
        return $this->film->getDuration();
    }

    public function getFilmSessionId(): string
    {
        return $this->id;
    }

    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function calcTimeEndFilmSession(): \DateTimeInterface
    {
        $timeStart = $this->dateTimeStartFilmSession;

        return $timeStart->add($this->film->getDuration());
    }

    private function checkTicketsAvail(): bool
    {
        return $this->ticketsCount <= 0;
    }
}
