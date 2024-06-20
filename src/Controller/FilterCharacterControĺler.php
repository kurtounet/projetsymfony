// src/Controller/CharacterController.php

namespace App\Controller;

use App\Form\CharacterFilterType;
use App\Repository\CharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CharacterController extends AbstractController
{
    /**
     * @Route("/characters", name="character_list")
     */
    public function list(Request $request, CharacterRepository $repository)
    {
        $form = $this->createForm(CharacterFilterType::class);
        $form->handleRequest($request);
        $characters = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $filters = $form->getData();
            $characters = $repository->findCharactersByFilters($filters);
        }

        return $this->render('character/list.html.twig', [
            'form' => $form->createView(),
            'characters' => $characters
        ]);
    }
}