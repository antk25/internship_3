<?php

namespace App\Booking\Domain\Entity;

use App\Booking\Domain\Entity\ValueObject\Client;
use App\Booking\Services\UuidService;
use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
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
