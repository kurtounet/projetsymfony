<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class ChangePasswordController extends AbstractController
{
    #[Route('/change/password/{id}', name: 'app_change_password')]
    public function changePassword(
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,

    ): Response {

        $user = $userRepository->find($request->get('id'));
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newPassword = $form->get('password')->getData();
            $user->setPassword($newPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre nouveau mots de passe a bien été enregisté');

            return $this->redirectToRoute(
                'app_login',
                ['user' => $user]
            );
        }

        return $this->render('change_password/changePassword.html.twig', [
            'changePasswordForm' => $form,
        ]);

    }

}
