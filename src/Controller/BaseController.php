<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\ContactPro;
use App\Repository\ContactProRepository;
use App\Repository\ContactRepository;
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
    public function contact(
        Request $request,
        EmailService $emailService,
        ContactRepository $contactRepository
    ) {
        $em = $this->getDoctrine()->getManager();

        // Si on a POSTé le formulaire
        if ($request->isMethod('POST')) {

            // On récupère les 2 input du formulaire
            $email = $request->request->get('email');
            $message = $request->request->get('message');
            dd($this->getUser());
            $contact = (new Contact())
                ->setEmail($email)
                ->setMessage($message)
                ->setUser($this->getUser())
            ;

            $em->persist($contact);
            $em->flush();

            // On envoie l'email
            $send = $emailService->contact($contact);

            // Si il a été envoyé, ou non, on affiche success / danger
            if ($send === true) {
                $this->addFlash('success', "Nous avons bien reçu votre message.");
            }else{
                $this->addFlash('danger', "Une erreur est survenue.");
            }

            // On redirige après le traitement du form.
            return $this->redirectToRoute('contact');
        }


        // $contacts = $contactRepository->findAll();
        $contacts = $contactRepository->findBy(
            array('email' => 'victor@email.com'),
            array('createdAt' => 'DESC')
        );

        // Modifier un objet
        // $contact = $contactRepository->find(1);
        // $contact->setEmail('jean@email.com');
        // $em->flush();
        
        // Supprimer un objet
        $contact = $contactRepository->find(1);
        if ($contact) {
            $em->remove($contact);
            $em->flush();
        }

        return $this->render('base/contact.html.twig', [
            'contacts' => $contacts
        ]);
    }

    /**
     * @Route("/contact-pro", name="contact_pro")
     */
    public function contact_pro(Request $request, EmailService $emailService) {

        if ($request->isMethod('POST')) {
            $data = $request->request->all();
            
            $contactPro = (new ContactPro())
                ->setNom($data['nom'])
                ->setPrenom($data['prenom'])
                ->setSociete($data['societe'])
                ->setSujet($data['sujet'])
                ->setEmail($data['mail'])
                ->setMessage($data['message'])
                ->setCreatedAt( new \DateTime() );

            $em = $this->getDoctrine()->getManager();
            $em->persist($contactPro);
            $em->flush();

            $send = $emailService->contact_pro($contactPro);
            if ($send === true) {
                $this->addFlash('success', "Merci, nous avons reçu votre message.");
            }else{
                $this->addFlash('danger', "Une erreur est vurvenue");
            }
            return $this->redirectToRoute('contact_pro');
        }

        return $this->render('base/contact_pro.html.twig');
    }
    
    /**
     * @Route("contact-pro-search", name="contact_pro_search")
     */
    public function contactProSearch(ContactProRepository $contactProRepository) {
        // 2ème façon de récupérer le Repository
        // $em = $this->getDoctrine()->getManager();
        // $contactProRepository = $em->getRepository(ContactPro::class);

        // $prenom = 'Fred';
        // $contacts = $contactProRepository->findContactsByPrenom($prenom);

        $date = new \DateTime('2 days ago');
        dd($date);

        $search = [
            'date' => new \DateTime('2020-05-28'),
            // 'date' => null,
            'prenom' => null,
            'nom' => 'Weiss'
        ];
        $contacts = $contactProRepository->findContactsRecent($search);
        
        dd($contacts);

    }
}














