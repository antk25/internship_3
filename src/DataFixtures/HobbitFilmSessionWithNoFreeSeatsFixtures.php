<?php

namespace App\DataFixtures;

use App\Domain\Booking\Entity\FilmSession;
use App\Domain\Booking\Entity\ValueObject\Film;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

final class HobbitFilmSessionWithNoFreeSeatsFixtures extends Fixture
{
    public const HOBBIT_FILM_SESSION_WITH_NO_FREE_SEATS = 'hobbitFilmSessionWithNoFreeSeats';
    public const FILM_DURATION_IN_MINUTES = 220;
    public const FILM_SESSION_AVAILABLE_TICKETS = 0;
    public const FILM_SESSION_DATE_TIME_START = '22.06.2022 15:30';

    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $film = new Film('Хоббит', new \DateInterval(sprintf('PT%dM', self::FILM_DURATION_IN_MINUTES)));

        $filmSession = new FilmSession(
            Uuid::v4(),
            $film,
            new \DateTimeImmutable(self::FILM_SESSION_DATE_TIME_START),
            self::FILM_SESSION_AVAILABLE_TICKETS,
        );

        $manager->persist($filmSession);

        $manager->flush();

        $this->addReference(self::HOBBIT_FILM_SESSION_WITH_NO_FREE_SEATS, $filmSession);
    }
}
