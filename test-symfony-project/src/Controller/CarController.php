<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CarController extends AbstractController
{

  public function __construct(
    private CarRepository $carRepository,
    private EntityManagerInterface $entityManager
  ) {}

  #[Route('/car', name: 'app_car')]
  public function index(): Response
  {

    $allcars = $this->carRepository->findAll();

    $carsafter2015 = $this->carRepository->createQueryBuilder('c')
      ->where('c.year > :value')
      ->setParameter('value', 2015)
      ->orderBy('c.id', 'ASC')
      ->getQuery()
      ->getResult();

    return $this->render('car/index.html.twig', [
      'cars' => $allcars,
      'carsafter2015' => $carsafter2015

    ]);
  }
}
