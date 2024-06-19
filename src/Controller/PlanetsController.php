<?php

namespace App\Controller;

use App\Entity\Planet;
use App\Repository\PlanetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlanetsController extends AbstractController
{
    #[Route('/planets', name: 'app_planets')]
    public function list(PlanetRepository $planetRepository): Response
    {
        $path = $this->getParameter('path_images_planets');
        $planets = $planetRepository->findAll();
        return $this->render('planets/listPlanets.html.twig', [
            'planets' => $planets,
            'path' => $path
        ]);
    }
    #[Route('/planets/{id}', name: 'app_planet')]
    public function planet(Planet $planet): Response
    {
        return $this->render('planets/planet.html.twig', [
            'planet' => $planet,
        ]);
    }
}
