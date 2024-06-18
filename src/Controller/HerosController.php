<?php

namespace App\Controller;

use App\Entity\Character;
use App\Repository\CharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Attribute\Context;

class HerosController extends AbstractController
{
    #[Route('/heros', name: 'app_heros')]
    public function heros(CharacterRepository $characterRepository): Response
    {
        $characters = $characterRepository->findAll();
        return $this->render('heros/listheros.html.twig', [
            'heros' => $characters,

        ]);
    }

    #[Route('/heros/{id}', name: 'app_hero')]
    public function hero(Character $character): Response
    {
        $characterTransformations = $character->getTransformation();

        return $this->render('heros/hero.html.twig', [
            'hero' => $character,
            'tranformations' => $characterTransformations,
            'planet' => $character->getPlanet(),



        ]);


    }
}
