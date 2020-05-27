<?php

namespace App\Controller;

use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function accueil()
    {
        return $this->render('base/accueil.html.twig', [

        ]);
    }

    public function header($ROUTE_NAME)
    {
        // REQUETE SQL

        return $this->render('_partials/header.html.twig', [
            'ROUTE_NAME' => $ROUTE_NAME,
        ]);
    }

    /**
     * @Route("/a-propos", name="apropos")
     */
    public function apropos()
    {
        return $this->render('base/apropos.html.twig', [

        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, EmailService $emailService)
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $message = $request->request->get('message');
            $emailService->sendEmail($email, $message);
            dd($email, $message);
        }

        return $this->render('base/contact.html.twig', [

        ]);
    }
}














