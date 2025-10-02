<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MovieController extends AbstractController
{


    public function __construct(
        private MovieRepository $movieRepository,
        private EntityManagerInterface $entityManager
    ) {}


    #[Route('/base', name: 'app_movie_base')]
    public function base(): Response
    {
        $movies = $this->movieRepository->findAll();

        return $this->render('movie/base.html.twig', [
            'movies' => $movies
        ]);
    }


    #[Route('/movie', name: 'app_movie')]
    public function index(): Response
    {
        $movies = $this->movieRepository->findAll();



        return $this->render('movie/index.html.twig', [
            'movies' => $movies
        ]);
    }

    #[Route('/movie/{id}', name: 'app_movie_show')]
    public function show(int $id): Response
    {

        $movie = $this->movieRepository->find($id);


        if (!$movie) {
            throw $this->createNotFoundException('Фильм с ID ' . $id . ' не найден');
        }

        return $this->render('movie/show.html.twig', [
            'movie' => $movie
        ]);
    }

    #[Route('/base/random', name: 'app_movie_random')]
    public function random(): Response
    {
        $movies = $this->movieRepository->findAll();


        $randomKey = array_rand($movies);
        $randomMovie = $movies[$randomKey];
        $id = $randomMovie->getId(); // Получаем ID через геттер



        if (!$randomMovie) {
            throw $this->createNotFoundException('Фильм не найден');
        }

        return $this->render('movie/random.html.twig', [
            'movie' => $randomMovie,
            'id' => $id
        ]);
    }
}
