<?php

namespace App\Controller;

use App\Repository\FilmSessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilmSessionController extends AbstractController
{
    /**
     * @throws \Exception
     */
    #[Route('/films', name: 'app_film_session')]
    public function index(FilmSessionRepository $filmSessionRepository): Response
    {

        return $this->render('film_session/index.html.twig', [
            'filmSessions' => $filmSessionRepository->findAll(),
        ]);
    }
}
