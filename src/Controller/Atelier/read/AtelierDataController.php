<?php

namespace App\Controller\Atelier\read;

use App\Repository\AtelierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AtelierDataController extends AbstractController
{
    #[Route('/atelier/list', name: 'app_atelier_list')]
    public function index(AtelierRepository $repository): Response
    {
        //Création de l'encodeur JSON
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $articles= $repository->findAll();

       
        return $this->json($articles); /*$serializer->serialize(, 'json'));*/
        
    }
}
