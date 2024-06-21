<?php

namespace App\Controller;

use App\Entity\Character;
use App\Entity\User;
use App\Form\CharacterFilterType;
use App\Repository\CharacterRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Attribute\Context;


class HerosController extends AbstractController
{
    #[Route('/heros', name: 'app_heros')]
    public function heros(
        Request $request,
        CharacterRepository $characterRepository
    ): Response {

        $allCharacters = $characterRepository->findAll();

        $form = $this->createForm(CharacterFilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $allCharacters = $characterRepository->findCharactersByFilters($data);
            // dd($allCharacters);

        }

        return $this->render('heros/listheros.html.twig', [

            'heros' => $allCharacters,
            'form' => $form,




        ]);
    }

    #[Route('/heros/{id}', name: 'app_hero')]
    public function hero(Character $character, UserRepository $user): Response
    {
        $characterTransformations = json_decode($character->getTransformation()[0], true);
        $userPreferences = $user->findBy(['characterPref' => $character]);

        return $this->render('heros/hero.html.twig', [
            'hero' => $character,
            'transformations' => $characterTransformations,
            'planet' => $character->getPlanet(),
            'userPreferences' => $userPreferences
        ]);


    }
}
