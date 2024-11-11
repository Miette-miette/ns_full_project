<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CarteController extends AbstractController
{
    #[Route('/carte/setup', name: 'app_carte_setup')]
    public function setup(): Response
    {
        return $this->render('carte_setup/index.html.twig', [
            'controller_name' => 'CarteSetupController',
        ]);
    }
}
