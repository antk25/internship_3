<?php

namespace App\Domain\Booking\Command\Handler;

use App\Domain\Booking\Command\CreateTicketCommand;
use App\Domain\Booking\Entity\FilmSession;
use App\Domain\Booking\Entity\Ticket;
use App\Domain\Booking\Repository\TicketRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Uid\Uuid;

#[AsMessageHandler]
final class CreateTicketHandler
{
    public function __construct(
        private readonly TicketRepositoryInterface $ticketRepository,
        private readonly ManagerRegistry $registry,
    ) {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(CreateTicketCommand $createTicketCommand): void
    {
        $client = new Client($createTicketCommand->name, $createTicketCommand->phone);

        $ticket = $this->bookTicket($createTicketCommand);

        $this->ticketRepository->save($ticket);

        $this->updateCountTickets($createTicketCommand);
    }

    private function bookTicket(CreateTicketCommand $createTicketCommand): Ticket
    {
        return new Ticket(Uuid::v4(), $createTicketCommand->client, $createTicketCommand->filmSession);
    }

    private function updateCountTickets(CreateTicketCommand $createTicketCommand): void
    {
        $entityManager = $this->registry->getManager();

        $product = $entityManager->getRepository(FilmSession::class)->find($createTicketCommand->filmSession->getFilmSessionId());

        $product->setCountTickets();

        $entityManager->flush();
    }
}
