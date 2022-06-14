<?php

namespace App\DataFixtures;

use App\Domain\Booking\Entity\FilmSession;
use App\Domain\Booking\Entity\ValueObject\Film;
use App\Domain\Booking\TransferObject\FilmSessionDto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

final class HobbitFilmSessionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $filmSession = [
            'film' => 'Хоббит',
            'filmDuration' => 220,
            'dateTimeStart' => '22.06.2022 15:30',
            'numberOfSeats' => 2,
        ];

        $filmSessionDto = new FilmSessionDto();
        $filmSessionDto = $filmSessionDto->createFromArray($filmSession);

        $filmSession = new FilmSession(
            Uuid::v4(),
            new Film(
                $filmSessionDto->filmTitle,
                \DateInterval::createFromDateString($filmSessionDto->filmDuration . 'minutes'),
            ),
            date_create_immutable($filmSessionDto->dateTimeStartFilmSession),
            $filmSessionDto->ticketsCount,
        );

        $manager->persist($filmSession);

        $manager->flush();
    }
}
