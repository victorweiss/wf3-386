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

        // Si on a POSTé le formulaire
        if ($request->isMethod('POST')) {

            // On récupère les 2 input du formulaire
            $email = $request->request->get('email');
            $message = $request->request->get('message');

            // On envoie l'email
            $send = $emailService->contact($email, $message);

            // Si il a été envoyé, ou non, on affiche success / danger
            if ($send === true) {
                $this->addFlash('success', "Nous avons bien reçu votre message.");
            }else{
                $this->addFlash('danger', "Une erreur est survenue.");
            }

            // On redirige après le traitement du form.
            return $this->redirectToRoute('contact');
        }

        return $this->render('base/contact.html.twig', [

        ]);
    }

    /**
     * @Route("/contact-pro", name="contact_pro")
     */
    public function contact_pro(Request $request, EmailService $emailService) {

        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            $send = $emailService->contact_pro($data);
            if ($send === true) {
                $this->addFlash('success', "Merci, nous avons reçu votre message.");
            }else{
                $this->addFlash('danger', "Une erreur est vurvenue");
            }
            return $this->redirectToRoute('contact_pro');
        }

        return $this->render('base/contact_pro.html.twig');
    }
}














