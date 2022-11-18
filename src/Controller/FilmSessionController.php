<?php

namespace App\Controller;

use App\Domain\Booking\Command\BookTicketCommand;
use App\Domain\Booking\Entity\FilmSession;
use App\Domain\Booking\Form\BookTicketType;
use App\Domain\Booking\Repository\FilmSessionRepositoryInterface;
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
        $filmSessions = $filmSessionRepository->findAll();

        return $this->render('film_session/index.html.twig', [
            'filmSessions' => $filmSessions,
        ]);
    }

    #[Route('/film-sessions/{id}', name: 'film_session')]
    public function show(
        Request $request,
        FilmSession $filmSession,
        MessageBusInterface $messageBus,
    ): Response {
        $bookTicketCommand = new BookTicketCommand($filmSession);

        $form = $this->createForm(BookTicketType::class, $bookTicketCommand);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messageBus->dispatch($bookTicketCommand);

            return $this->redirectToRoute('film_sessions');
        }

        return $this->render('film_session/show.html.twig', [
            'filmSession' => $filmSession,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/clients', name: 'clients')]
    public function showClients(FilmSessionRepositoryInterface $filmSessionRepository): Response
    {
        $filmSessions = $filmSessionRepository->findAll();

        return $this->render('film_session/clients.html.twig', [
            'filmSessions' => $filmSessions,
        ]);
    }
}
