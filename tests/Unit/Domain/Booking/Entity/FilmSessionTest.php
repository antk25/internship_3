<?php

namespace App\Tests\Unit\Domain\Booking\Entity;

use App\Domain\Booking\Entity\FilmSession;
use App\Domain\Booking\Entity\ValueObject\Client;
use App\Domain\Booking\Entity\ValueObject\Film;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class FilmSessionTest extends TestCase
{
    private string $filmTitle;
    private \DateInterval $filmDuration;
    private FilmSession $filmSession;
    private Uuid $filmSessionId;
    private \DateTimeInterface $filmSessionStartAt;

    public function setUp(): void
    {
        $this->filmTitle = 'Аватар';
        $this->filmDuration = \DateInterval::createFromDateString('180 minutes');
        $this->film = new Film($this->filmTitle, $this->filmDuration);

        $this->filmSessionId = Uuid::v4();
        $this->filmSessionStartAt = date_create_immutable('23.06.2022 10:10');
        $this->filmSession = new FilmSession($this->filmSessionId, $this->film, $this->filmSessionStartAt, 1);
    }

    public function testGetFilmTitle(): void
    {
        $this->assertEquals($this->filmTitle, $this->filmSession->getFilmTitle());
    }

    public function testGetFilmStartAt(): void
    {
        $this->assertEquals($this->filmSessionStartAt, $this->filmSession->getFilmStartAt());
    }

    public function testCountOfTicketsAvailable(): void
    {
        $this->assertEquals(1, $this->filmSession->getCountOfTicketsAvailable());
    }

    public function testGetFilmDuration(): void
    {
        $this->assertEquals($this->filmDuration, $this->filmSession->getFilmDuration());
    }

    public function testGetFilmSessionId(): void
    {
        $this->assertEquals($this->filmSessionId, $this->filmSession->getFilmSessionId());
    }

    public function testGetFilmEndAt(): void
    {
        $expected = $this->filmSessionStartAt->add($this->filmDuration);

        $this->assertEquals($expected, $this->filmSession->getFilmEndAt());
    }

    /**
     * @throws \Exception
     */
    public function testBookTicketIncreaseNumberOfBookedTickets(): void
    {
        $client = new Client('Олег', '89524562389');

        $this->filmSession->bookTicket($client);

        $this->assertCount(1, $this->filmSession->getTickets());

        $this->assertEquals(0, $this->filmSession->getCountOfTicketsAvailable());
    }

    /**
     * @throws \Exception
     */
    public function testBookTicketDecreaseNumberOfSeatsAvailable(): void
    {
        $client = new Client('Олег', '89524562389');

        $this->filmSession->bookTicket($client);

        $this->assertEquals(0, $this->filmSession->getCountOfTicketsAvailable());
    }

    /**
     * @throws \Exception
     */
    public function testBookTicketWhenNoSeatsThrowOutException(): void
    {
        $client1 = new Client('Олег', '89524562389');
        $client2 = new Client('Олег', '89524562389');

        $this->filmSession->bookTicket($client1);

        $this->expectException(\Throwable::class);
        $this->expectExceptionMessage('No more tickets');

        $this->filmSession->bookTicket($client2);
    }
}
