<?php

namespace App\Controller;

use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Service\EmailRestePasswordNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/reset-password', name: 'app_reset_password')]
    public function forgottenPassword(
        Request $request,
        UserRepository $userRepository,
        EmailRestePasswordNotification $emailRestePasswordNotification
    ): Response {

        $resetPasswordForm = $this->createForm(ResetPasswordType::class);
        $resetPasswordForm->handleRequest($request);

        if ($resetPasswordForm->isSubmitted() && $resetPasswordForm->isValid()) {

            $email = $resetPasswordForm->get('email')->getData();

            $user = $userRepository->findOneBy(['email' => $email]);
            if ($user) {
                $emailRestePasswordNotification->sendConfirmationEmail($email);
                return $this->render(
                    'security/resetPasswordSendEmail.html.twig',
                    ['id' => $user->getId()]
                );
            }
            $this->addFlash('error', 'Cet email n\'existe pas');
        }
        // return $this->redirectToRoute('app_login');

        return $this->render('security/resetPassword.html.twig', [
            'resetPasswordForm' => $resetPasswordForm
        ]);
    }
}
