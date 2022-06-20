<?php

namespace App\Tests\Functional\Domain\Booking\Command\Handler;

use App\DataFixtures\AvatarFilmSessionWithFiveFreeSeatsFixtures;
use App\DataFixtures\HobbitFilmSessionWithNoFreeSeatsFixtures;
use App\Domain\Booking\Command\BookTicketCommand;
use App\Domain\Booking\Repository\FilmSessionRepositoryInterface;
use App\Tests\Functional\FunctionalTestCase;
use Symfony\Component\Messenger\MessageBusInterface;

final class CreateTicketCommandHandlerTest extends FunctionalTestCase
{
    private MessageBusInterface $messageBus;
    private FilmSessionRepositoryInterface $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = self::getContainer()->get(FilmSessionRepositoryInterface::class);
        $this->messageBus = self::getContainer()->get(MessageBusInterface::class);
    }

    /**
     * @throws \Throwable
     */
    public function testBookingTicketWhenAvailableSeatsShouldBeSuccessful(): void
    {
        $fixture = $this->loadFixtures([AvatarFilmSessionWithFiveFreeSeatsFixtures::class]);
        $referenceRepository = $fixture->getReferenceRepository();
        $filmSession = $referenceRepository->getReference(AvatarFilmSessionWithFiveFreeSeatsFixtures::AVATAR_FILM_SESSION_WITH_FIVE_FREE_SEATS);

        $exitingFilmSession = $this->repository->findOneBy(['film.title' => $filmSession->getFilmTitle()]);
        $bookTicketCommand = new BookTicketCommand($exitingFilmSession);
        $bookTicketCommand->name = 'Федор';
        $bookTicketCommand->phone = '89563245689';
        $this->messageBus->dispatch($bookTicketCommand);

        $this->assertEquals($filmSession->getCountOfTicketsAvailable(), $exitingFilmSession->getCountOfTicketsAvailable());
    }

    /**
     * @throws \Throwable
     */
    public function testBookingTicketWithoutSeatsShouldGiveException(): void
    {
        $fixture = $this->loadFixtures([HobbitFilmSessionWithNoFreeSeatsFixtures::class]);
        $referenceRepository = $fixture->getReferenceRepository();
        $filmSession = $referenceRepository->getReference(HobbitFilmSessionWithNoFreeSeatsFixtures::HOBBIT_FILM_SESSION_WITH_NO_FREE_SEATS);

        $exitingFilmSession = $this->repository->findOneBy(['film.title' => $filmSession->getFilmTitle()]);
        $bookTicketCommand = new BookTicketCommand($exitingFilmSession);
        $bookTicketCommand->name = 'Федор';
        $bookTicketCommand->phone = '89563245689';

        $this->expectException(\Throwable::class);
        $this->expectExceptionMessage('No more tickets');
        $this->messageBus->dispatch($bookTicketCommand);
    }
}
