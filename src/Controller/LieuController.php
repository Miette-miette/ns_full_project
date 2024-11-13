<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\CreateLieuType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LieuController extends AbstractController
{
    #[Route('/lieu/create', name: 'app_lieu_create')]
    public function createDataLieu(EntityManagerInterface $entityManager,Request $request)
    {
        $concert = new Lieu();
        $form = $this->createForm(CreateLieuType::class, $concert);

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
            $concertData = $form->getData();
            $entityManager->persist($concertData);
            $entityManager->flush();

            return new Response("Lieu ajouté!");
        }

        return $this->render('creation\create_data.html.twig',['form' => $form->createView(),'controller_title' => 'Nouveau lieu']);
    }
}
