<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Form\AnimeType;
use App\Repository\AnimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimeController extends AbstractController
{

    #[Route('/anime', name: 'anime_list')]
    public function list(
        AnimeRepository $animeRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $query = $animeRepository->createQueryBuilder('a')
            ->orderBy('a.releaseYear', 'DESC')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // page actuelle
            6 // items par page
        );

        return $this->render('anime/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/anime/new')] 
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $anime = new Anime();
        $form = $this->createForm(AnimeType::class, $anime);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($anime);
            $entityManager->flush();

            $this->addFlash('success', 'Anime ajouté avec succès !');

            return $this->redirectToRoute('anime_new'); // Redirection ou vers une liste
        }

        return $this->render('anime/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
