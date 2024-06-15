<?php

namespace App\Controller;

use App\Entity\NewsletterEmail;
use App\Form\NewsletterType;
use App\Service\EmailNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class NewsletterController extends AbstractController
{
    #[Route('/newsletter', name: 'app_newsletter_subscribe')]
    public function subscribe(
        Request $request,
        EntityManagerInterface $em,
        EmailNotification $emailNotification
    ): Response {

        $newsletterEmail = new NewsletterEmail();
        $form = $this->createForm(NewsletterType::class, $newsletterEmail);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($newsletterEmail);
            $em->flush();

            $emailNotification->sendConfirmationEmail($newsletterEmail);

            return $this->redirectToRoute('app_newsletter_thanks');
        }

        return $this->render('newsletter/index.html.twig', [
            'newsletterForm' => $form,
        ]);
    }
    #[Route('/newsletter/thanks', name: 'app_newsletter_thanks')]
    public function thanks(): Response
    {
        return $this->render('newsletter/newsletter_thanks.html.twig');
    }
}
