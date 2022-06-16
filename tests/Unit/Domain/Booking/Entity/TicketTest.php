<?php

namespace App\Tests\Unit\Domain\Booking\Entity;

use App\Domain\Booking\Entity\FilmSession;
use App\Domain\Booking\Entity\Ticket;
use App\Domain\Booking\Entity\ValueObject\Client;
use App\Domain\Booking\Entity\ValueObject\Film;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\UuidV4;

final class TicketTest extends TestCase
{
    public function testCreateTicket(): void
    {
        $ticketId = UuidV4::v4();
        $client = new Client('Олег', '89524562389');
        $film = new Film('Аватар', \DateInterval::createFromDateString('180 minutes'));
        $filmSession = new FilmSession(UuidV4::v4(), $film, date_create_immutable('23.06.2022 10:10'), 0);
        $ticket = new Ticket($ticketId, $client, $filmSession);

        $this->assertInstanceOf(Ticket::class, $ticket);
    }

    public function testGetTicketId(): void
    {
        $ticketId = UuidV4::v4();
        $client = new Client('Олег', '89524562389');
        $film = new Film('Аватар', \DateInterval::createFromDateString('180 minutes'));
        $filmSession = new FilmSession(UuidV4::v4(), $film, date_create_immutable('23.06.2022 10:10'), 0);
        $ticket = new Ticket($ticketId, $client, $filmSession);

        $this->assertEquals($ticketId, $ticket->getTicketId());
    }
}
