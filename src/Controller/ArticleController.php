<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\CreateArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ArticleController extends AbstractController
{
    // Function for creating a new article
    #[Route('/article/create', name: 'app_article_create')]
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


    // Function to encode the data into JSON
    #[Route('/article/data', name: 'app_article_data')]  
    public function encodeJSON(ArticleRepository $repository): Response
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $articles= $repository->findAll();

       
        return $this->json($articles); /*$serializer->serialize(, 'json'));*/
        
    }

    // Show all articles
    #[Route('/article/list', name: 'app_article_list')]
    public function ShowAll(ArticleRepository $repository,PaginatorInterface $paginator, Request $request): Response
    {
        //pagination 1 par page
        $articles = $paginator->paginate(
            $repository->findAll(), 
            $request->query->getInt('page', 1), 
            1 
        );
        
        return $this->render('article/article_list.html.twig',[

        'articles'=>$articles]);
    }

}



    
