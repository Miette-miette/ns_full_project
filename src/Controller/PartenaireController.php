<?php

namespace App\Controller;

use App\Entity\Partenaire;
use App\Form\CreatePartenaireType;
use App\Repository\PartenaireRepository;
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

class PartenaireController extends AbstractController
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

        return $this->render('partenaire\index.html.twig',['form' => $form->createView(), 'controller_title' => 'Nouveau Partenaire']);
    }

    #[Route('/partenaire/data', name: 'app_partenaire_data')]
    public function encodeJSON(PartenaireRepository $repository): Response
    {
        //Création de l'encodeur JSON
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $concerts= $repository->findAll();

       
        return $this->json($concerts); /*$serializer->serialize(, 'json'));*/
        
    }

    #[Route('/partenaire/list', name: 'app_partenaire_list')]
    public function list(PartenaireRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        //pagination 2 par page
        $partenaire = $paginator->paginate(
            $repository->findAll(), 
            $request->query->getInt('page', 1), 
            2 
        );
        
        return $this->render('partenaire_list/index.html.twig',[

        'partenaire'=>$partenaire]);
    }
}
