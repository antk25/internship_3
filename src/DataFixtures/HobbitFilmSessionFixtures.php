<?php

namespace App\DataFixtures;

use App\Domain\Booking\Factory\CreateFilmSessionDtoFactory;
use App\Domain\Booking\Service\FilmSessionService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class HobbitFilmSessionFixtures extends Fixture
{
    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $filmSession = [
            'film' => 'Хоббит',
            'filmLength' => 220,
            'dateTimeStart' => '22.06.2022 15:30',
            'numberOfSeats' => 15,
        ];

        $dtoFilmSessionFactory = new CreateFilmSessionDtoFactory();
        $filmSessionService = new FilmSessionService();

        $dtoFilmSession = $dtoFilmSessionFactory->createFromArray($filmSession);

        $filmSession = $filmSessionService->createFilmSession($dtoFilmSession);

        $manager->persist($filmSession);

        $manager->flush();
    }
}
