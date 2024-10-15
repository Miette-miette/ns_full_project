<?php

namespace App\Controller;

use App\Repository\AtelierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AtelierListController extends AbstractController
{
    #[Route('/atelier/list', name: 'app_atelier_list')]
    public function index(AtelierRepository $repository): Response
    {

        $atelier= $repository->findAll();

        return $this->render('atelier_list/index.html.twig', [
            'atelier' =>$atelier]);
    }
}
