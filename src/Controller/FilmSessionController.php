<?php

namespace App\Controller;

use App\Booking\Domain\Command\CreateTicketCommand;
use App\Booking\Domain\Entity\FilmSession;
use App\Booking\Domain\Entity\ValueObject\Client;
use App\Booking\Domain\Repository\FilmSessionRepositoryInterface;
use App\Booking\Domain\TransferObject\NewClientDto;
use App\Form\NewClientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

final class FilmSessionController extends AbstractController
{
    #[Route('/film-sessions', name: 'film_sessions')]
    public function index(FilmSessionRepositoryInterface $filmSessionRepository): Response
    {
        return $this->render('film_session/index.html.twig', [
            'filmSessions' => $filmSessionRepository->findAll(),
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/film-sessions/{id}', name: 'film_session')]
    public function show(
        Request $request,
        FilmSessionRepositoryInterface $filmSessionRepository,
        string $id,
        MessageBusInterface $bus,
    ): Response {
        $clientDto = new NewClientDto();

        $form = $this->createForm(NewClientType::class, $clientDto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client = new Client($clientDto->name, $clientDto->phone);
            $bus->dispatch(new CreateTicketCommand($filmSession, $client));

            return $this->redirectToRoute('film_sessions');
        }

        return $this->render('film_session/show.html.twig', [
            'filmSession' => $filmSession,
            'form' => $form->createView(),
        ]);
    }
}
