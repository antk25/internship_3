<?php

namespace App\Domain\Booking\Entity;

use App\Domain\Booking\Entity\ValueObject\Client;
use App\Domain\Booking\Repository\DoctrineTicketRepository;
use App\Domain\Services\UuidService;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctrineTicketRepository::class)]
#[ORM\Table(name: 'tickets')]
final class Ticket
{
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\Id]
    private string $id;

    #[ORM\Embedded(class: Client::class, columnPrefix: 'client_')]
    private Client $client;

    #[ORM\ManyToOne(targetEntity: FilmSession::class, inversedBy: 'tickets')]
    #[ORM\JoinColumn(name: 'film_session_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private FilmSession $filmSession;

    public function __construct(
        Client $client,
        FilmSession $filmSession,
    ) {
        $this->id = UuidService::generate();
        $this->client = $client;
        $this->filmSession = $filmSession;
    }

    public function getTicketId(): string
    {
        return $this->id;
    }
}
