<?php

namespace App\DataFixtures;

use App\Domain\Booking\Factory\CreateFilmSessionDtoFactory;
use App\Domain\Booking\Service\FilmSessionService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class FilmSessionFixtures extends Fixture
{
    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $filmSession1 = [
            'film' => 'Веном',
            'filmLength' => 110,
            'dateTimeStart' => '22.06.2022 20:15',
            'numberOfSeats' => 10,
        ];

        $filmSession2 = [
            'film' => 'Хоббит',
            'filmLength' => 220,
            'dateTimeStart' => '22.06.2022 15:30',
            'numberOfSeats' => 15,
        ];

        $filmSession3 = [
            'film' => 'Аватар',
            'filmLength' => 180,
            'dateTimeStart' => '23.06.2022 10:00',
            'numberOfSeats' => 25,
        ];

        $dtoFilmSessionFactory = new CreateFilmSessionDtoFactory();
        $filmSessionService = new FilmSessionService();

        $dtoFilmSession1 = $dtoFilmSessionFactory->createFromArray($filmSession1);
        $dtoFilmSession2 = $dtoFilmSessionFactory->createFromArray($filmSession2);
        $dtoFilmSession3 = $dtoFilmSessionFactory->createFromArray($filmSession3);

        $filmSession1 = $filmSessionService->createFilmSession($dtoFilmSession1);
        $filmSession2 = $filmSessionService->createFilmSession($dtoFilmSession2);
        $filmSession3 = $filmSessionService->createFilmSession($dtoFilmSession3);

        $manager->persist($filmSession1);
        $manager->persist($filmSession2);
        $manager->persist($filmSession3);

        $manager->flush();
    }
}
