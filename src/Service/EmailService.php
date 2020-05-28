<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class EmailService {

    private $mailer;

    // Injection de service
    // On injecte MailerInterface dans notre classe EmailService
    // pour qu'il soit accessible dans toutes les méthodes de la classe
    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    public function sendEmail($email, $message) {
        $email = (new TemplatedEmail())
            ->from('victor.weiss.be@gmail.com')
            ->to('demo.wf3.victor@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            // ->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('[CONTACT DU SITE]')
            ->htmlTemplate('emails/contact.email.twig')
            ->context([
                'mail' => $email,
                'message' => $message,
            ])
        ;

        try {
            $this->mailer->send($email);
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

}