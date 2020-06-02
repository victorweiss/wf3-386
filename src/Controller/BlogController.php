<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog_list")
     */
    public function blog_list()
    {
        return $this->render('blog/blog_list.html.twig', [

        ]);
    }

    /**
     * @Route("/blog/mon-article", name="blog_single")
     */
    public function blog_single()
    {
        return $this->render('blog/blog_single.html.twig', [

        ]);
    }

    /**
     * @Route("/blog/nouvel-article", name="blog_new")
     */
    public function blog_new(Request $request) {

        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            $this->addFlash('success', "L'article a bien été créé.");
            return $this->redirectToRoute('blog_new');
        }


        return $this->render('blog/blog_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
