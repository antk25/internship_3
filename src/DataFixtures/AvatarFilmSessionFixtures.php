<?php

namespace App\DataFixtures;

use App\Domain\Booking\Factory\CreateFilmSessionDtoFactory;
use App\Domain\Booking\Service\FilmSessionService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class AvatarFilmSessionFixtures extends Fixture
{
    /**
     * @throws \Exception
     */
    public function load(ObjectManager $manager): void
    {
        $filmSession = [
            'film' => 'Аватар',
            'filmLength' => 180,
            'dateTimeStart' => '23.06.2022 10:00',
            'numberOfSeats' => 25,
        ];

        $dtoFilmSessionFactory = new CreateFilmSessionDtoFactory();
        $filmSessionService = new FilmSessionService();

        $dtoFilmSession = $dtoFilmSessionFactory->createFromArray($filmSession);

        $filmSession = $filmSessionService->createFilmSession($dtoFilmSession);

        $manager->persist($filmSession);

        $manager->flush();
    }
}
