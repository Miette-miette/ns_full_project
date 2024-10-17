<?php

namespace App\Controller\Partenaire\update;

use App\Repository\PartenaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PartenaireListController extends AbstractController
{
    #[Route('/partenaire/list', name: 'app_partenaire_list')]
    public function index(PartenaireRepository $repository): Response
    {
        $partenaire= $repository->findAll();
        

        return $this->render('partenaire_list/index.html.twig',[

        'partenaire'=>$partenaire]);
    }
}
