<?php

namespace App\DataFixtures;

use App\Domain\Booking\Entity\FilmSession;
use App\Domain\Booking\Entity\ValueObject\Film;
use App\Domain\Booking\TransferObject\FilmSessionDto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

final class VenomFilmSessionFixtures extends Fixture
{
    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $filmSession = [
            'film' => 'Веном',
            'filmLength' => 110,
            'dateTimeStart' => '22.06.2022 20:15',
            'numberOfSeats' => 10,
        ];

        $filmSessionDto = new FilmSessionDto();
        $filmSessionDto = $filmSessionDto->createFromArray($filmSession);

        $filmSession = new FilmSession(
            Uuid::v4(),
            new Film($filmSessionDto->filmName, \DateInterval::createFromDateString($filmSessionDto->filmLength . 'minutes')),
            date_create_immutable($filmSessionDto->dateTimeStartFilmSession),
            $filmSessionDto->ticketsCount,
        );

        $manager->persist($filmSession);

        $manager->flush();
    }
}
