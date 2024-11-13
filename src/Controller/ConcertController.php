<?php

namespace App\Controller;

use App\Entity\Concert;
use App\Form\CreateDataConcertType;
use App\Repository\ConcertRepository;
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

class ConcertController extends AbstractController
{
    #[Route('/concert', name: 'app_concert_create')]
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

        return $this->render('creation\create_data.html.twig',['form' => $form->createView(), 'controller_title' => 'Nouveau Concert']);
    }

    #[Route('/concert/data', name: 'app_concert_data')]
    public function encodeJSON(ConcertRepository $repository): Response
    {
        //Création de l'encodeur JSON
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $concerts= $repository->findAll();

       
        return $this->json($concerts); /*$serializer->serialize(, 'json'));*/
        
    }

    #[Route('/concert/list', name: 'app_concert_list')]
    public function index(ConcertRepository $repository,PaginatorInterface $paginator, Request $request): Response
    {
        //pagination 6 par page
        $concerts = $paginator->paginate(
            $repository->findAll(), 
            $request->query->getInt('page', 1), 
            6
        );
        
        return $this->render('concert_list/index.html.twig', [
            'concerts' =>$concerts]);
    }
    
    
}
