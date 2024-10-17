<?php

namespace App\Controller\Article\create;

use App\Entity\Article;
use App\Form\CreateArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class ArticleCreateController extends AbstractController
{
    #[Route('/article/create', name: 'article_create')]

    // Fonction de creation d'article

    public function createDataArticle(EntityManagerInterface $entityManager,Request $request)
    {
        $article = new Article();
        $form = $this->createForm(CreateArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
            $articleData = $form->getData();
            $entityManager->persist($articleData);
            $entityManager->flush();

            return new Response("Article ajouté!");
        }

        return $this->render('creation\create_data.html.twig',['form' => $form->createView()]);
    }
}
