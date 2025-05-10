<?php

namespace App\Controller;

use App\Repository\AnimeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(AnimeRepository $animeRepository): Response
    {
        // Récupérer les derniers animes (limité à 6 par exemple)
        $latestAnimes = $animeRepository->findBy([], ['releaseYear' => 'DESC'], 6);

        return $this->render('home/index.html.twig', [
            'animes' => $latestAnimes
        ]);
    }
}
