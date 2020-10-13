<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\articleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="articles_index")
     */
    public function index(ArticleRepository $articleRepository)
    {
        $articles = $articleRepository->findAll();
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            "articles" => $articles
        ]);
    }

    /**
     * @Route("/articles/create", name="articles_create")
     */
    public function create(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(articleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute("articles_read",[
                "article"=> $article->getId()
            ]);
        }
        return $this->render('article/create.html.twig',[
            "myform"=> $form->createView()
        ]);

    }

    /**
     * @Route("/articles/{article}", name="articles_read")
     */
    public function read(Article $article)
    {
        return $this->render('article/read.html.twig',[
            "article"=> $article
        ]);
    }

    /**
     * @Route("/articles/{article}/edit", name="articles_edit")
     */
    public function edit(Article $article,Request $request){

        $form = $this->createForm(articleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("articles_read",[
                "article"=> $article->getId()
            ]);
        }
        return $this->render('article/edit.html.twig',[
            "myform"=> $form->createView()
        ]);
    }

    /**
     * @Route("/articles/{article}/delete", name="articles_delete")
     */

    public function delete(Article $article){
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute("articles_index");
    }
}
