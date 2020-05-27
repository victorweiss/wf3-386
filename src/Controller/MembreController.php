<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MembreController extends AbstractController
{
    /**
     * @Route("/espace-membre", name="membre_accueil")
     */
    public function membre_accueil()
    {
        return $this->render('membre/membre_accueil.html.twig', [

        ]);
    }
}
