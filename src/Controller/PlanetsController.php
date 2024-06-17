<?php

namespace App\Controller;

use App\Repository\PlanetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlanetsController extends AbstractController
{
    #[Route('/planets', name: 'app_planets')]
    public function list(PlanetRepository $planetRepository): Response
    {
        $planets = $planetRepository->findAll();
        return $this->render('planets/listPlanets.html.twig', [
            'planets' => $planets,
        ]);
    }
    #[Route('/planets/{id}', name: 'app_planet')]
    public function planet(int $id, PlanetRepository $planetRepository): Response
    {
        $planet = $planetRepository->findById($id);
        return $this->render('planets/Planet.html.twig', [
            'planet' => $planet,
        ]);
    }
}
