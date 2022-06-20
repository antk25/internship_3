<?php

namespace App\DataFixtures;

use App\Domain\Booking\Entity\FilmSession;
use App\Domain\Booking\Entity\ValueObject\Film;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

final class AvatarFilmSessionWithFiveFreeSeatsFixtures extends Fixture
{
    public const AVATAR_FILM_SESSION_WITH_FIVE_FREE_SEATS = 'avatarFilmSessionWithFiveFreeSeats';
    public const FILM_DURATION_IN_MINUTES = 180;
    public const FILM_SESSION_AVAILABLE_TICKETS = 5;
    public const FILM_SESSION_DATE_TIME_START = '23.06.2022 10:00';

    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $film = new Film('Аватар', new \DateInterval(sprintf('PT%dM', self::FILM_DURATION_IN_MINUTES)));

        $filmSession = new FilmSession(
            Uuid::v4(),
            $film,
            new \DateTimeImmutable(self::FILM_SESSION_DATE_TIME_START),
            self::FILM_SESSION_AVAILABLE_TICKETS,
        );

        $manager->persist($filmSession);

        $manager->flush();

        $this->addReference(self::AVATAR_FILM_SESSION_WITH_FIVE_FREE_SEATS, $filmSession);
    }
}
