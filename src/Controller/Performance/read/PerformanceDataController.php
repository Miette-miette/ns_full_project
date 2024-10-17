<?php

namespace App\Controller\Performance\read;

use App\Repository\PerformanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PerformanceDataController extends AbstractController
{
    #[Route('/performance/data', name: 'app_performance_data')]
    public function index(PerformanceRepository $repository): Response
    {
        //Création de l'encodeur JSON
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $concerts= $repository->findAll();

       
        return $this->json($concerts); /*$serializer->serialize(, 'json'));*/
        
    }
}
