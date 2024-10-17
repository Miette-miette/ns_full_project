<?php

namespace App\Controller\Atelier\update;

use App\Repository\AtelierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AtelierListController extends AbstractController
{
    #[Route('/atelier/modify', name: 'app_atelier_modify')]
    public function index(AtelierRepository $repository): Response
    {

        $atelier= $repository->findAll();

        return $this->render('atelier_list/index.html.twig', [
            'atelier' =>$atelier]);
    }
}
