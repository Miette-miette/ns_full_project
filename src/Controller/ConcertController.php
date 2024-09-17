<?php

namespace App\Controller;

use App\Entity\Concert;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConcertController extends AbstractController
{
    #[Route('/concert', name: 'create_concert')]
    public function createDataConcert(EntityManagerInterface $entityManager): Response
    {
        $concert = new Concert();
        $concert->

    }
    
}
