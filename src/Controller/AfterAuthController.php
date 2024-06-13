<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AfterAuthController extends AbstractController
{
    #[Route('/after/auth', name: 'app_after_auth')]
    public function index(): Response
    {
        return $this->render('after_auth/index.html.twig', [
            'controller_name' => 'AfterAuthController',
        ]);
    }
}
