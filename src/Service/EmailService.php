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

    public function sendEmail($data) {
        $email = (new TemplatedEmail())
            ->from($data['from'] ?? 'demo.wf3.victor@gmail.com')
            ->to($data['to'] ?? 'demo.wf3.victor@gmail.com')
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