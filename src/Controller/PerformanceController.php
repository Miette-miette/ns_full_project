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

    #[Route('/api/performances', name: 'api_performances', methods: ['GET'])]
    public function getAtelierAPI(PerformanceRepository $repository): Response
    {
        $performances = $repository->findAll();
        $data = [];

        foreach ($performances as $performance) {
            $data[] = [
                'id' => $performance->getId(),
                'title' => $performance->getTitre(),
                'Location' => $performance->getLieu(),
                'begin_datetime' => $performance->getBeginDatetime() ? $performance->getBeginDatetime()->format('Y-m-d H:i:s') : null,
                'end_datetime' => $performance->getEndDatetime() ? $performance->getEndDatetime()->format('Y-m-d H:i:s') : null,
                'description' => $performance->getContent(),
                'image' => $this->getParameter('app.base_url') . '/public/images/ns_img_content/' . $performance->getImageName(),
            ];
        }

        return $this->json($data, Response::HTTP_OK);
    }

}
