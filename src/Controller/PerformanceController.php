<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PerformanceController extends AbstractController
{
    #[Route('/performance', name: 'app_performance')]
    public function index(): Response
    {
        return $this->render('performance/index.html.twig', [
            'controller_name' => 'PerformanceController',
        ]);
    }
}
