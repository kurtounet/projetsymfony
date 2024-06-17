<?php

namespace App\Service;

use App\Entity\Contact;
use App\Entity\NewsletterEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactNotification
{
    public function __construct(
        private MailerInterface $mailer,
        private string $adminEmail
    ) {
    }

    public function sendConfirmationEmail(
        Contact $newMessage
    ): void {
        $email = (new Email())
            ->from($this->adminEmail)
            ->to($newMessage->getEmail())
            ->subject('Votre message')
            ->text('Merci pour votre message.');

        $this->mailer->send($email);
    }
}
