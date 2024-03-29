<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Entity\ValueObject\Client;
use App\Domain\Booking\Repository\DoctrineTicketRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: DoctrineTicketRepository::class)]
#[ORM\Table(name: 'tickets')]
final class Ticket
{
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\Id]
    private Uuid $id;

    #[ORM\Embedded(class: Client::class, columnPrefix: 'client_')]
    private Client $client;

    #[ORM\ManyToOne(targetEntity: FilmSession::class, inversedBy: 'tickets')]
    #[ORM\JoinColumn(name: 'film_session_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private FilmSession $filmSession;

    public function __construct(
        Uuid $id,
        Client $client,
        FilmSession $filmSession,
    ) {
        $this->id = $id;
        $this->client = $client;
        $this->filmSession = $filmSession;
    }

    public function getTicketId(): string
    {
        return $this->id;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getFilmSession(): FilmSession
    {
        return $this->filmSession;
    }
}
