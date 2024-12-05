<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\CreateLocationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LieuController extends AbstractController
{
    #[Route('/Location/create', name: 'app_Location_create', methods: ['GET','POST'])]
    public function createDataLocation(EntityManagerInterface $entityManager,Request $request)
    {
        $location = new Location();
        $form = $this->createForm(CreateLocationType::class, $location);

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
            $locationData = $form->getData();
            $entityManager->persist($locationData);
            $entityManager->flush();

            $this->addFlash(
                'sucsess',
                'Le lieu à été ajouté!'
            );

            return $this->redirectToRoute('app_home');
        }

        return $this->render('creation\create_data.html.twig',['form' => $form->createView(),'controller_title' => 'Nouveau lieu']);
    }
}
