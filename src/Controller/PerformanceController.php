<?php

namespace App\Controller;

use App\Entity\Performance;
use App\Form\CreatePerformanceType;
use App\Repository\PerformanceRepository;
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

class PerformanceController extends AbstractController
{
    #[Route('/performance/create', name: 'app_performance_create')]
    public function createDataPerformance(EntityManagerInterface $entityManager,Request $request)
    {
        $performance = new Performance();
        $form = $this->createForm(CreatePerformanceType::class, $performance);

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
            $performanceData = $form->getData();
            $entityManager->persist($performanceData);
            $entityManager->flush();

            return new Response("Performance ajouté!");
        }

        return $this->render('creation\create_data.html.twig',['form' => $form->createView(), 'controller_title' => 'Nouvelle Performance']);
    }

    #[Route('/performance/data', name: 'app_performance_data')]
    public function encodeJSON(PerformanceRepository $repository): Response
    {
        //Création de l'encodeur JSON
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $performance= $repository->findAll();

       
        return $this->json($performance); /*$serializer->serialize(, 'json'));*/
        
    }

    #[Route('/performance/list', name: 'app_performance_list')]
    public function index(PerformanceRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        //pagination 2 par page
        $performance = $paginator->paginate(
            $repository->findAll(), 
            $request->query->getInt('page', 1), 
            2 
        );

        return $this->render('performance_list/index.html.twig', [
            'performance' =>$performance]);
    }


}
