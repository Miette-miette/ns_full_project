<?php

namespace App\Controller\Concert\update;

use App\Repository\ConcertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConcertListController extends AbstractController
{
    #[Route('/concert/modify', name: 'app_concert_modify')]
    public function index(ConcertRepository $repository): Response
    {
        $concerts= $repository->findAll();

        return $this->render('concert_list/index.html.twig', [
            'concerts' =>$concerts]);
    }
}
