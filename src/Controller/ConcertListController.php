<?php

namespace App\Controller;

use App\Repository\ConcertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ConcertListController extends AbstractController
{
    #[Route('/concert/list', name: 'app_concert_list')]
    public function index(ConcertRepository $repository): Response
    {
        //Création de l'encodeur JSON
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $concerts= $repository->findAll();

       
        return $this->json($concerts); /*$serializer->serialize(, 'json'));*/
        
    }
    /*public function list(ConcertRepository $repository): Response
    {
        $concerts= $repository->findAll();

        return $this->render('concert_list/index.html.twig', [
            'concerts' =>$concerts]);

    }*/
}
