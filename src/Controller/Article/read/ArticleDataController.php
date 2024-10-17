<?php

namespace App\Controller\Article\read;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ArticleDataController extends AbstractController
{
    #[Route('/article/data', name: 'app_article_data')]

    // Fonction de creation du JSON
    
    public function encodeJSON(ArticleRepository $repository): Response
    {
        //Création de l'encodeur JSON
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $articles= $repository->findAll();

       
        return $this->json($articles); /*$serializer->serialize(, 'json'));*/
        
    }
}
