<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CarteMarkerController extends AbstractController
{
    #[Route('/carte/marker/create', name: 'app_carte_marker')]
    public function createMarker(): Response
    {
        return $this->render('carte_marker/index.html.twig', [
            'controller_name' => 'CarteMarkerController',
        ]);
    }


}
