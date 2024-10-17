<?php

namespace App\Controller\Article\update;

use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticleListController extends AbstractController
{
    #[Route('/article/list', name: 'app_article_list')]

    // Fonction pour afficher toute les données
    
    public function ShowAll(ArticleRepository $repository,PaginatorInterface $paginator, Request $request): Response
    {

        //pagination 4 par pages
        $articles = $paginator->paginate(
            $repository->findAll(), 
            $request->query->getInt('page', 1), 
            1 
        );
        

        return $this->render('article/article_list.html.twig',[

        'articles'=>$articles]);
    }
}
