<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\ContactNotification;
use App\Service\EmailNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(
        Request $request,
        EntityManagerInterface $em,
        ContactNotification $econtactNotification
    ): Response {

        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setcreatedAt(new \DateTime());
            $em->persist($contact);
            $em->flush();

            $econtactNotification->sendConfirmationEmail($contact);
            //$this->addFlash('success', 'Votre message a bien été envoyé !');

            return $this->redirectToRoute('app_contact_thanks');
        }

        return $this->render(
            'contact/contactForm.html.twig',
            ['Contact_form' => $form]
        );
    }
    #[Route('/contact/thanks', name: 'app_contact_thanks')]
    public function contactThanks(): Response
    {

        return $this->render('contact/thanks.html.twig');
    }
}