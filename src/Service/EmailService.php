<?php

namespace App\Service;

use App\Entity\Contact;
use App\Entity\ContactPro;
use App\Entity\User;
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

    private function sendEmail($data) {

        $to = $data['to'] ?? $this->MY_EMAIL;
        if ($this->APP_ENV == 'dev') { $to = $this->MY_EMAIL; } // Redirection DEV

        $email = (new TemplatedEmail())
            ->from($data['from'] ?? 'demo.wf3.victor@gmail.com')
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

    public function contact(Contact $contact) {
        return $this->sendEmail([
            'subject' => "[CONTACT DU SITE]",
            'template' => 'emails/contact.email.twig',
            'context' => [
                'contact' => $contact
            ],
        ]);
    }

    public function contact_pro(ContactPro $contactPro) {
        return $this->sendEmail([
            'subject' => $contactPro->getSujet(),
            'template' => 'emails/contact_pro.email.twig',
            'context' => [
                'contactPro' => $contactPro
            ]
        ]);
    }

    public function registrationConfirmEmail(User $user) {
        return $this->sendEmail([
            'to' => $user->getEmail(),
            'subject' => "Confirmez votre email",
            'template' => 'emails/registration_confirm_email.email.twig',
            'context' => [
                'user' => $user
            ]
        ]);
    }


}