<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TwigController extends AbstractController
{
    /**
     * @Route("/exercice-twig", name="exercice_twig")
     */
    public function exerciceTwig()
    {
        $user = [
            'prenom' => 'Victor',
            'nom' => 'Weiss',
        ];

        $age = 27;
        $ville = 'Strasbourg';

        return $this->render('twig/exercice_twig.html.twig', [
            'user' => $user,
            'age' => $age,
            'ville' => $ville
        ]);
    }

    /**
     * @Route("/exercice-twig-noms", name="exercice_twig_noms")
     */
    public function exerciceTwigNoms() {
        
        $personnes = array(
            array( 'nom' => 'Dupont', 	'prenom' => 'Germaine', 	'statut' => 'Grand-mère', 	'naissance' => new \DateTime('1934-05-04') ),
            array( 'nom' => 'Muller', 	'prenom' => 'Jean-Paul', 	'statut' => 'Tonton', 		'naissance' => new \DateTime('1958-02-07') ),
            array( 'nom' => 'Dupont', 	'prenom' => 'Grégoire', 	'statut' => 'Grand-père', 	'naissance' => new \DateTime('1932-04-14') ),
            array( 'nom' => 'Dupont', 	'prenom' => 'Gérard', 		'statut' => 'Père', 		'naissance' => new \DateTime('1961-07-13') ),
            array( 'nom' => 'Dupont', 	'prenom' => 'Manon', 		'statut' => 'Fille', 		'naissance' => new \DateTime('1995-03-18') ),
            array( 'nom' => 'Meyer', 	'prenom' => 'Ginette', 		'statut' => 'Grand-mère', 	'naissance' => new \DateTime('1936-09-12') ),
            array( 'nom' => 'Koch', 	'prenom' => 'Freddy', 		'statut' => 'Ami', 			'naissance' => new \DateTime('1981-10-28') ),
            array( 'nom' => 'Meyer', 	'prenom' => 'Benoît', 		'statut' => 'Grand-père', 	'naissance' => new \DateTime('1936-12-01') ),
            array( 'nom' => 'Dupont', 	'prenom' => 'Julien', 		'statut' => 'Fils', 		'naissance' => new \DateTime('1990-08-23') ),
            array( 'nom' => 'Muller', 	'prenom' => 'Bernadette', 	'statut' => 'Tatie', 		'naissance' => new \DateTime('1968-09-11') ),
            array( 'nom' => 'Dupont', 	'prenom' => 'Marie', 		'statut' => 'Mère', 		'naissance' => new \DateTime('1964-01-24') ),
        );

        return $this->render('twig/exercice_twig_noms.html.twig');
    }


}