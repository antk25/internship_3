<?php

namespace App\Tests\Unit\Domain\Booking\Entity;

use App\Domain\Booking\Entity\FilmSession;
use App\Domain\Booking\Entity\ValueObject\Client;
use App\Domain\Booking\Entity\ValueObject\Film;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\UuidV4;

final class FilmSessionTest extends TestCase
{
    private FilmSession $filmSession;
    private UuidV4 $filmSessionId;
    private \DateTimeInterface $filmSessionStartAt;

    public function setUp(): void
    {
        $this->film = new Film('Аватар', \DateInterval::createFromDateString('180 minutes'));
        $this->filmSessionId = UuidV4::v4();
        $this->filmSessionStartAt = date_create_immutable('23.06.2022 10:10');
        $this->filmSession = new FilmSession($this->filmSessionId, $this->film, $this->filmSessionStartAt, 1);
    }

    public function testGetFilmTitle(): void
    {
        $this->assertEquals('Аватар', $this->filmSession->getFilmTitle());
    }

    public function testGetFilmStartAt(): void
    {
        $this->assertEquals(date_create_immutable('23.06.2022 10:10'), $this->filmSession->getFilmStartAt());
    }

    public function testCountOfTicketsAvailable(): void
    {
        $this->assertEquals(1, $this->filmSession->getCountOfTicketsAvailable());
    }

    public function testGetFilmDuration(): void
    {
        $this->assertEquals(\DateInterval::createFromDateString('180 minutes'), $this->filmSession->getFilmDuration());
    }

    public function testGetFilmSessionId(): void
    {
        $this->assertEquals($this->filmSessionId, $this->filmSession->getFilmSessionId());
    }

    public function testGetFilmEndAt(): void
    {
        $expected = $this->filmSessionStartAt->add(\DateInterval::createFromDateString('180 minutes'));

        $this->assertEquals($expected, $this->filmSession->getFilmEndAt());
    }

    public function testBookTicket(): void
    {
        $client = new Client('Олег', '89524562389');

        $this->filmSession->bookTicket($client);

        $this->assertCount(1, $this->filmSession->getTickets());

        $this->assertEquals(0, $this->filmSession->getCountOfTicketsAvailable());
    }

    public function testBookTicketWhenNoSeats(): void
    {
        $film = new Film('Аватар', \DateInterval::createFromDateString('180 minutes'));
        $filmSessionId = UuidV4::v4();
        $filmSessionStartAt = date_create_immutable('23.06.2022 10:10');
        $filmSession = new FilmSession($filmSessionId, $film, $filmSessionStartAt, 0);

        $client = new Client('Олег', '89524562389');

        $this->expectException(\Throwable::class);
        $this->expectExceptionMessage('No more tickets');
        $filmSession->bookTicket($client);
    }
}
