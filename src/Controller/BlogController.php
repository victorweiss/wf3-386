<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog_list")
     */
    public function blog_list(ArticleRepository $articleRepository)
    {
        return $this->render('blog/blog_list.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/blog/{slug}", name="blog_single")
     */
    public function blog_single(Article $article)
    {
        return $this->render('blog/blog_single.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/blog/nouvel-article/{slug}", name="blog_new")
     */
    public function blog_new(
        // Le ParamConverter converti $id en Article
        // Le ? dit que $article = Article|null
        ?Article $article,
        Request $request,
        SluggerInterface $slugger
    ) {

        // Si aucun article n'a été trouvé..
        // .. Utiliser une nouvelle instance d'Article
        $new = false;
        if (!$article) {
            $article = new Article();
            $new = true;
        }

        // if ($id) {
        //     $article = $articleRepository->find($id);
        //     if (!$article) {
        //         // return $this->redirectToRoute('blog_new', [ 'id' => 0 ]);
        //         throw new NotFoundHttpException("L'article n'a pas été trouvé");
        //     }
        // }else{
        //     $article = new Article();
        // }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($new) {
                // On transforme le titre en slug
                $slug = $slugger->slug($article->getTitle());
                $article->setSlug($slug);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            $this->addFlash('success', "L'article a bien été ". ($new ? 'créé' : 'modifié') .".");
            return $this->redirectToRoute('blog_new', [ 'slug' => $article->getSlug() ]);
        }

        return $this->render('blog/blog_new.html.twig', [
            'form' => $form->createView(),
            'new' => $new,
            'article' => $article,
        ]);
    }

}
