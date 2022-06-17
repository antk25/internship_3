<?php

namespace App\DataFixtures;

use App\Domain\Booking\Entity\FilmSession;
use App\Domain\Booking\Entity\ValueObject\Film;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

final class HobbitFilmSessionWithNoEmptySeatsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $filmSession = [
            'film' => 'Хоббит',
            'filmDuration' => 220,
            'dateTimeStart' => '22.06.2022 15:30',
            'numberOfSeats' => 0,
        ];

        $filmSession = new FilmSession(
            Uuid::v4(),
            new Film(
                $filmSession['film'],
                \DateInterval::createFromDateString($filmSession['filmDuration'] . 'minutes'),
            ),
            date_create_immutable($filmSession['dateTimeStart']),
            $filmSession['numberOfSeats'],
        );

        $manager->persist($filmSession);

        $manager->flush();
    }
}
