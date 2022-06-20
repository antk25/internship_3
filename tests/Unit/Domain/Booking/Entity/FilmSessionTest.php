<?php

namespace App\Tests\Unit\Domain\Booking\Entity;

use App\Domain\Booking\Entity\FilmSession;
use App\Domain\Booking\Entity\ValueObject\Client;
use App\Domain\Booking\Entity\ValueObject\Film;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class FilmSessionTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testGetFilmTitle(): void
    {
        $expectedFilmTitle = 'Аватар';
        $filmSession = $this->createFilmSession(
            Uuid::v4(),
            $expectedFilmTitle,
            self::createFilmDuration(),
            self::createFilmSessionStartDateTime(),
        );

        $this->assertEquals($expectedFilmTitle, $filmSession->getFilmTitle());
    }

    /**
     * @throws \Exception
     */
    public function testGetFilmStartAt(): void
    {
        $expectedFilmSessionStartAt = self::createFilmSessionStartDateTime();
        $filmSession = $this->createFilmSession(
            Uuid::v4(),
            'Аватар',
            self::createFilmDuration(),
            $expectedFilmSessionStartAt,
        );

        $this->assertEquals($expectedFilmSessionStartAt, $filmSession->getFilmStartAt());
    }

    /**
     * @throws \Exception
     */
    public function testCountOfTicketsAvailable(): void
    {
        $expectedCountOfTicketsAvailable = 1;
        $filmSession = $this->createFilmSession(
            Uuid::v4(),
            'Аватар',
            self::createFilmDuration(),
            self::createFilmSessionStartDateTime(),
            $expectedCountOfTicketsAvailable,
        );

        $this->assertEquals($expectedCountOfTicketsAvailable, $filmSession->getCountOfTicketsAvailable());
    }

    /**
     * @throws \Exception
     */
    public function testGetFilmDuration(): void
    {
        $expectedFilmDuration = self::createFilmDuration();

        $filmSession = $this->createFilmSession(
            Uuid::v4(),
            'Аватар',
            $expectedFilmDuration,
            self::createFilmSessionStartDateTime(),
        );

        $this->assertEquals($expectedFilmDuration, $filmSession->getFilmDuration());
    }

    /**
     * @throws \Exception
     */
    public function testGetFilmSessionId(): void
    {
        $expectedFilmSessionId = Uuid::v4();

        $filmSession = $this->createFilmSession(
            $expectedFilmSessionId,
            'Аватар',
            self::createFilmDuration(),
            self::createFilmSessionStartDateTime(),
        );
        $this->assertEquals($expectedFilmSessionId, $filmSession->getFilmSessionId());
    }

    /**
     * @throws \Exception
     */
    public function testGetFilmEndAt(): void
    {
        $filmSessionStartAt = self::createFilmSessionStartDateTime();
        $filmDuration = self::createFilmDuration();

        $filmSession = $this->createFilmSession(
            Uuid::v4(),
            'Аватар',
            $filmDuration,
            $filmSessionStartAt,
        );

        $expected = $filmSessionStartAt->add($filmDuration);

        $this->assertEquals($expected, $filmSession->getFilmEndAt());
    }

    /**
     * @throws \Exception
     */
    public function testIfBookingIsSuccessfulTicketShouldIntoCollection(): void
    {
        $filmSession = $this->createFilmSession(
            Uuid::v4(),
            'Аватар',
            self::createFilmDuration(),
            self::createFilmSessionStartDateTime(),
        );

        $client = new Client('Олег', '89524562389');

        $filmSession->bookTicket($client);

        $this->assertCount(1, $filmSession->getTickets());
    }

    /**
     * @throws \Exception
     */
    public function testIfBookingIsSuccessfulNumberOfAvailableSeatsShouldDecreaseByOne(): void
    {
        $countOfTicketsAvailable = 3;

        $filmSession = $this->createFilmSession(
            Uuid::v4(),
            'Аватар',
            self::createFilmDuration(),
            self::createFilmSessionStartDateTime(),
            $countOfTicketsAvailable,
        );

        $client = new Client('Олег', '89524562389');

        $filmSession->bookTicket($client);

        $this->assertEquals($countOfTicketsAvailable - 1, $filmSession->getCountOfTicketsAvailable());
    }

    /**
     * @throws \Exception
     */
    public function testBookingTicketWithoutSeatsShouldGiveException(): void
    {
        $countOfTicketsAvailable = 1;

        $filmSession = $this->createFilmSession(
            Uuid::v4(),
            'Аватар',
            self::createFilmDuration(),
            self::createFilmSessionStartDateTime(),
            $countOfTicketsAvailable,
        );

        $client = new Client('Олег', '89524562389');
        $clientWhenTicketsOut = new Client('Олег', '89524562389');

        $filmSession->bookTicket($client);

        $this->expectException(\Throwable::class);
        $this->expectExceptionMessage('No more tickets');

        $filmSession->bookTicket($clientWhenTicketsOut);
    }

    /**
     * @throws \Exception
     */
    private function createFilmSession(
        Uuid $filmSessionId,
        string $filmTitle,
        \DateInterval $filmDuration,
        \DateTimeImmutable $filmSessionStartAt,
        int $countOfTicketsAvailable = 5,
    ): FilmSession {
        $film = new Film($filmTitle, $filmDuration);

        return new FilmSession($filmSessionId, $film, $filmSessionStartAt, $countOfTicketsAvailable);
    }

    /**
     * @throws \Exception
     */
    private static function createFilmDuration(): \DateInterval
    {
        return new \DateInterval(sprintf('PT%dM', 180));
    }

    /**
     * @throws \Exception
     */
    private static function createFilmSessionStartDateTime(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('26.06.2022 10:10');
    }
}
