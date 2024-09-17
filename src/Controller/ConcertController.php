<?php

namespace App\Controller;

use App\Entity\Concert;
use App\Form\CreateDataConcertType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConcertController extends AbstractController
{
    #[Route('/concert', name: 'create_concert')]
    public function createDataConcert(EntityManagerInterface $entityManager,Request $request)
    {
        $concert = new Concert();
        $form = $this->createForm(CreateDataConcertType::class, $concert);

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
            $concertData = $form->getData();
            $entityManager->persist($concertData);
            $entityManager->flush();

            return new Response("Concert ajouté!");
        }

        return $this->render('concert\concert_data.html.twig',['form' => $form->createView()]);
    }
    
}
