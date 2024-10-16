<?php

namespace App\Controller\Partenaire\create;

use App\Entity\Partenaire;
use App\Form\CreatePartenaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PartenaireCreateController extends AbstractController
{
    #[Route('/partenaire/create', name: 'app_partenaire_create')]
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

        return $this->render('partenaire\index.html.twig',['form' => $form->createView()]);
    }
}
