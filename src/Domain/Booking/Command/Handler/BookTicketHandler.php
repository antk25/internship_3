<?php

namespace App\Domain\Booking\Command\Handler;

use App\Domain\Booking\Command\BookTicketCommand;
use App\Domain\Booking\Entity\ValueObject\Client;
use App\Domain\Booking\Repository\FilmSessionRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class BookTicketHandler
{
    public function __construct(private readonly FilmSessionRepositoryInterface $filmSessionRepository)
    {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(BookTicketCommand $bookTicketCommand): void
    {
        $client = new Client($bookTicketCommand->name, $bookTicketCommand->phone);

        $filmSession = $bookTicketCommand->filmSession->bookTicket($client);

        $this->filmSessionRepository->save($filmSession);
    }
}
