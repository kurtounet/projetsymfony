<?php

namespace App\Service;

use App\Entity\NewsletterEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailRestePasswordNotification
{
    public function __construct(
        private MailerInterface $mailer,
        private string $adminEmail
    ) {
    }

    public function sendConfirmationEmail(
        string $userEmail
    ): void {
        $email = (new Email())
            ->from($this->adminEmail)
            ->to($userEmail)
            ->subject('Réinitialisation du mot de passe')
            ->text('Voici le lien pour définir un nouveau mot de passe : blabla');

        $this->mailer->send($email);
    }
}
