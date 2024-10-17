<?php

namespace App\Controller\Atelier\create;

use App\Entity\Atelier;
use App\Form\CreateAtelierType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AtelierCreateController extends AbstractController
{
    #[Route('/atelier', name: 'app_atelier')]
    public function createDataAtelier(EntityManagerInterface $entityManager,Request $request)
    {
        $article = new Atelier();
        $form = $this->createForm(CreateAtelierType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
            $articleData = $form->getData();
            $entityManager->persist($articleData);
            $entityManager->flush();

            return new Response("Article ajouté!");
        }

        return $this->render('creation\create_data.html.twig',['form' => $form->createView()]);
    }
}
