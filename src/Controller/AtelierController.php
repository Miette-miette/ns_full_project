<?php

namespace App\Controller;

use App\Entity\Atelier;
use App\Form\CreateAtelierType;
use App\Repository\AtelierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AtelierController extends AbstractController
{
    #[Route('/atelier', name: 'app_atelier_create')]
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

    #[Route('/atelier/data', name: 'app_atelier_data')]
    public function encodeJSON(AtelierRepository $repository): Response
    {
        //Création de l'encodeur JSON
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $articles= $repository->findAll();

       
        return $this->json($articles); /*$serializer->serialize(, 'json'));*/
        
    }

    #[Route('/atelier/list', name: 'app_atelier_list')]
    public function ShowAll(AtelierRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        //pagination 2 par page
        $atelier = $paginator->paginate(
            $repository->findAll(), 
            $request->query->getInt('page', 1), 
            2 
        );

        return $this->render('atelier_list/index.html.twig', [
            'atelier' =>$atelier]);
    }

}
