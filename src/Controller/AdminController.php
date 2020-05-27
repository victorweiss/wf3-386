<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/administration", name="admin_accueil")
     */
    public function admin_accueil()
    {
        return $this->render('admin/admin_accueil.html.twig', [

        ]);
    }
}
