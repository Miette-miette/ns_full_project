<?php

namespace App\Controller;

use App\Repository\PerformanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PerformanceListController extends AbstractController
{
    #[Route('/performance/list', name: 'app_performance_list')]
    public function index(PerformanceRepository $repository): Response
    {
        $performance= $repository->findAll();

        return $this->render('performance_list/index.html.twig', [
            'performance' =>$performance]);
    }
}
