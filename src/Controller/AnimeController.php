<?php

namespace App\Controller;

use App\Entity\Anime;
use App\Form\AnimeType;
use App\Repository\AnimeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

    #[Route('/anime/new', name: 'anime_new')] 
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $anime = new Anime();
        $form = $this->createForm(AnimeType::class, $anime);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $anime->setImage('https://picsum.photos/seed/' . uniqid() . '/600/400');

            $entityManager->persist($anime);
            $entityManager->flush();

            $this->addFlash('success', 'Anime ajouté avec succès !');

            return $this->redirectToRoute('anime_new'); // Redirection ou vers une liste
        }

        return $this->render('anime/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/anime/{id}', name: 'anime_show')]
    public function show(Anime $anime): Response
    {
        if (!$anime) {
            throw new NotFoundHttpException('Cet anime n\'existe pas.');
        }

        return $this->render('anime/show.html.twig', [
            'anime' => $anime,
        ]);
    }

    #[Route('/anime/{id}/edit', name: 'anime_edit')]
    public function edit(Anime $anime, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnimeType::class, $anime);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'L\'anime a été mis à jour avec succès !');

            return $this->redirectToRoute('anime_show', ['id' => $anime->getId()]);
        }

        return $this->render('anime/edit.html.twig', [
            'form' => $form->createView(),
            'anime' => $anime
        ]);
    }
}
