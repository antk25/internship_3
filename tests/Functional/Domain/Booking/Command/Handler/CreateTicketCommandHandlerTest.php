<?php

namespace App\Tests\Functional\Domain\Booking\Command\Handler;

use App\DataFixtures\AvatarFilmSessionWithFiveEmptySeatsFixtures;
use App\DataFixtures\HobbitFilmSessionWithNoEmptySeatsFixtures;
use App\Domain\Booking\Command\BookTicketCommand;
use App\Domain\Booking\Repository\DoctrineFilmSessionRepository;
use App\Tests\Functional\AbstractFunctionalTestCase;
use Symfony\Component\Messenger\MessageBusInterface;

final class CreateTicketCommandHandlerTest extends AbstractFunctionalTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->repository = self::getContainer()->get(DoctrineFilmSessionRepository::class);
        $this->messageBus = self::getContainer()->get(MessageBusInterface::class);
    }

    /**
     * @throws \Throwable
     */
    public function testTicketBookSuccessfully(): void
    {
        $this->databaseTool->loadFixtures([AvatarFilmSessionWithFiveEmptySeatsFixtures::class], true);

        $filmSession = $this->repository->findOneBy(['film.title' => 'Аватар']);

        $bookTicketCommand = new BookTicketCommand($filmSession);
        $bookTicketCommand->name = 'Федор';
        $bookTicketCommand->phone = '89563245689';

        $this->messageBus->dispatch($bookTicketCommand);

        $this->assertEquals(4, $filmSession->getCountOfTicketsAvailable());
    }

    /**
     * @throws \Throwable
     */
    public function testTicketBookWhenNoSeatsAvailable(): void
    {
        $this->databaseTool->loadFixtures([HobbitFilmSessionWithNoEmptySeatsFixtures::class], true);

        $filmSession = $this->repository->findOneBy(['film.title' => 'Хоббит']);

        $bookTicketCommand = new BookTicketCommand($filmSession);
        $bookTicketCommand->name = 'Федор';
        $bookTicketCommand->phone = '89563245689';

        $this->expectException(\Throwable::class);
        $this->expectExceptionMessage('No more tickets');

        $this->messageBus->dispatch($bookTicketCommand);
    }
}
