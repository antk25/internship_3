<?php

namespace App\Booking\Domain\Command;

use App\Booking\Domain\Entity\FilmSession;
use App\Booking\Domain\Entity\Ticket;
use App\Booking\Domain\Repository\TicketRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

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
        if ($createTicketCommand->filmSession->checkTicketsAvail()) {
            throw new \Exception('No more tickets');
        }

        $ticket = $this->bookTicket($createTicketCommand);

        $this->ticketRepository->add($ticket);

        $this->updateCountTickets($createTicketCommand);
    }

    private function bookTicket(CreateTicketCommand $createTicketCommand): Ticket
    {
        return new Ticket($createTicketCommand->client, $createTicketCommand->filmSession);
    }

    private function updateCountTickets(CreateTicketCommand $createTicketCommand): void
    {
        $entityManager = $this->registry->getManager();

        $product = $entityManager->getRepository(FilmSession::class)->find($createTicketCommand->filmSession->getId());

        $product->setCountTickets();

        $entityManager->flush();
    }
}
