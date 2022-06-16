<?php

namespace App\Tests\Functional\Domain\Booking\Command\Handler;

use App\DataFixtures\AvatarFilmSessionFixtures;
use App\DataFixtures\HobbitFilmSessionFixtures;
use App\Domain\Booking\Command\BookTicketCommand;
use App\Domain\Booking\Repository\DoctrineFilmSessionRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Messenger\MessageBusInterface;

final class CreateTicketCommandHandlerTest extends WebTestCase
{
    protected AbstractDatabaseTool $databaseTool;

    /**
     * @throws \Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();
        $this->repository = self::getContainer()->get(DoctrineFilmSessionRepository::class);
        $this->messageBus = self::getContainer()->get(MessageBusInterface::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->databaseTool);
    }

    /**
     * @throws \Throwable
     */
    public function testTicketBookWhenNoSeatsAvailable(): void
    {
        $this->databaseTool->loadFixtures([HobbitFilmSessionFixtures::class], true);

        $filmSession = $this->repository->findOneBy([]);

        $bookTicketCommand = new BookTicketCommand($filmSession);
        $bookTicketCommand->name = 'Федор';
        $bookTicketCommand->phone = '89563245689';

        $this->expectException(\Throwable::class);
        $this->expectExceptionMessage('No more tickets');

        $this->messageBus->dispatch($bookTicketCommand);
    }

    /**
     * @throws \Throwable
     */
    public function testTicketBookSuccessfully(): void
    {
        $this->databaseTool->loadFixtures([AvatarFilmSessionFixtures::class], true);

        $filmSession = $this->repository->findOneBy([]);

        $bookTicketCommand = new BookTicketCommand($filmSession);
        $bookTicketCommand->name = 'Федор';
        $bookTicketCommand->phone = '89563245689';

        $this->messageBus->dispatch($bookTicketCommand);

        $this->assertCount(1, $filmSession->getTickets());
    }
}
