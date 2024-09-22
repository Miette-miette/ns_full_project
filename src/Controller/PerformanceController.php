<?php

namespace App\Controller;

use App\Entity\Performance;
use App\Form\CreatePerformanceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PerformanceController extends AbstractController
{
    #[Route('/performance', name: 'app_performance')]
    public function createDataPerformance(EntityManagerInterface $entityManager,Request $request)
    {
        $concert = new Performance();
        $form = $this->createForm(CreatePerformanceType::class, $concert);

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
            $concertData = $form->getData();
            $entityManager->persist($concertData);
            $entityManager->flush();

            return new Response("Performance ajouté!");
        }

        return $this->render('creation\create_data.html.twig',['form' => $form->createView()]);
    }
}
