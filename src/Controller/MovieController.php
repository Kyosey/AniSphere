<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/movie', name: 'movie_list')]
    public function list(
        MovieRepository $movieRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $query = $movieRepository->createQueryBuilder('a')
            ->orderBy('a.releaseYear', 'DESC')
            ->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // page actuelle
            6 // items par page
        );

        return $this->render('movie/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/movie/new', name: 'movie_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $movie = new Movie();
        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movie->setImage('https://picsum.photos/seed/' . uniqid() . '/600/400');
            
            $entityManager->persist($movie);
            $entityManager->flush();

            $this->addFlash('success', 'Film ajouté avec succès !');
            
            return $this->redirectToRoute('movie_new');
        }

        return $this->render('movie/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/movie/{id}', name: 'movie_show')]
    public function show(Movie $movie): Response
    {
        if (!$movie) {
            throw new NotFoundHttpException('Ce film n\'existe pas.');
        }

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
        ]);
    }

    #[Route('/movie/{id}/edit', name: 'movie_edit')]
    public function edit(Movie $movie, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MovieType::class, $movie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Le film a été mis à jour avec succès !');

            return $this->redirectToRoute('movie_show', ['id' => $movie->getId()]);
        }

        return $this->render('movie/edit.html.twig', [
            'form' => $form->createView(),
            'movie' => $movie
        ]);
    }
}
