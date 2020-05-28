<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class EmailService {

    private $mailer;
    private $MY_EMAIL;
    private $APP_ENV;

    // Injection de service
    // On injecte MailerInterface dans notre classe EmailService
    // pour qu'il soit accessible dans toutes les méthodes de la classe
    public function __construct(
        $MY_EMAIL,
        $APP_ENV,
        MailerInterface $mailer
    ) {
        $this->MY_EMAIL = $MY_EMAIL;
        $this->APP_ENV = $APP_ENV;
        $this->mailer = $mailer;
    }

    public function sendEmail($data) {

        $to = $data['to'] ?? $this->MY_EMAIL;
        if ($this->APP_ENV == 'dev') { $to = $this->MY_EMAIL; } // Redirection DEV

        $email = (new TemplatedEmail())
            ->from($data['from'] ?? $this->MY_EMAIL)
            ->to($to)
            ->subject($data['subject'])
            ->htmlTemplate($data['template'])
            ->context($data['context'])
        ;
        // dd($email);

        try {
            $this->mailer->send($email);
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function contact($email, $message) {
        return $this->sendEmail([
            'subject' => "[CONTACT DU SITE]",
            'template' => 'emails/contact.email.twig',
            'context' => [ 'mail' => $email, 'message' => $message ],
        ]);
    }

    public function contact_pro($data) {
        return $this->sendEmail([
            'subject' => $data['sujet'],
            'template' => 'emails/contact_pro.email.twig',
            'context' => $data,
        ]);
    }


}