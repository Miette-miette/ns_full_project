<?php

namespace App\Controller;

use App\Entity\Partenaire;
use App\Form\CreatePartenaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PartenaireController extends AbstractController
{
    #[Route('/partenaire', name: 'app_partenaire')]
    public function createDataPartenaire(EntityManagerInterface $entityManager,Request $request)
    {
        $concert = new Partenaire();
        $form = $this->createForm(CreatePartenaireType::class, $concert);

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
            $concertData = $form->getData();
            $entityManager->persist($concertData);
            $entityManager->flush();

            return new Response("Partenaire ajouté!");
        }

        return $this->render('creation\create_data.html.twig',['form' => $form->createView()]);
    }
}
