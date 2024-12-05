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

        return $this->render('creation\create_data.html.twig',['form' => $form->createView(), 'controller_title' => 'Nouvel Article']);
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

    #[Route('/api/articles', name: 'api_articles', methods: ['GET'])]
    public function getConcertsAPI(ArticleRepository $repository): Response
    {
        $articles = $repository->findAll();
        $data = [];

        foreach ($articles as $article) {
            $data[] = [
                'id' => $article->getId(),
                'title' => $article->getTitre(),
                'subtitle' => $article->getSousTitre(),
                'chapeau' => $article->getChapeau(),
                'description' => $article->getContent(),
                'image' => $this->getParameter('app.base_url') . '/images/ns_img_content/' . $article->getImageName(),
            ];
        }

        return $this->json($data, Response::HTTP_OK);
    }

}



    
