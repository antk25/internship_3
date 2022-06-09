<?php

namespace App\Controller;

use App\Domain\Booking\Command\CreateTicketCommand;
use App\Domain\Booking\Entity\FilmSession;
use App\Domain\Booking\Entity\ValueObject\Client;
use App\Domain\Booking\Form\NewClientType;
use App\Domain\Booking\Repository\FilmSessionRepositoryInterface;
use App\Domain\Booking\TransferObject\NewClientDto;
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

    /**
     * @throws \Exception
     */
    #[Route('/film-sessions/{id}', name: 'film_session')]
    public function show(
        Request $request,
        FilmSession $filmSession,
        MessageBusInterface $messageBus,
    ): Response {
        $clientDto = new NewClientDto();

        $form = $this->createForm(NewClientType::class, $clientDto);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client = new Client($clientDto->name, $clientDto->phone);
            $messageBus->dispatch(new CreateTicketCommand($filmSession, $client));

            return $this->redirectToRoute('film_sessions');
        }

        return $this->render('film_session/show.html.twig', [
            'filmSession' => $filmSession,
            'form' => $form->createView(),
        ]);
    }
}
