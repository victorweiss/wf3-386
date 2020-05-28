<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService {

    private $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    public function sendEmail($email, $message) {
        $email = (new Email())
            ->from($email)
            ->to('demo.wf3.victor@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            // ->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('[CONTACT DU SITE]')
            ->html('<p>Nouveau message du site : '. $message .'</p>');

        $this->mailer->send($email);
    }

}