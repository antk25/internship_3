<?php

namespace App\Domain\Booking\Command\Handler;

use App\Domain\Booking\Command\CreateTicketCommand;
use App\Domain\Booking\Entity\ValueObject\Client;
use App\Domain\Booking\Repository\FilmSessionRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class CreateTicketHandler
{
    public function __construct(private readonly FilmSessionRepositoryInterface $filmSessionRepository)
    {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(CreateTicketCommand $createTicketCommand): void
    {
        $client = new Client($createTicketCommand->name, $createTicketCommand->phone);

        $filmSession = $createTicketCommand->filmSession->bookTicket($client);

        $this->filmSessionRepository->save($filmSession);
    }
}
