<?php

namespace App\Controller;

use App\Entity\Concert;
use App\Form\ConcertType;
use App\Repository\ConcertRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConcertController extends AbstractController
{
    #[Route('/concert', name: 'app_concert_create')]
    public function createDataConcert(EntityManagerInterface $entityManager,Request $request)
    {
        $concert = new Concert();
        $form = $this->createForm(ConcertType::class, $concert);

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

    #[Route('/api/concerts', name: 'api_concerts', methods: ['GET'])]
    public function getConcertsAPI(ConcertRepository $repository): Response
    {
        $concerts = $repository->findAll();
        $data = [];

        foreach ($concerts as $concert) {
            $data[] = [
                'id' => $concert->getId(),
                'title' => $concert->getTitre(),
                'Location' => $concert->getLocation(),
                'begin_datetime' => $concert->getBeginDatetime() ? $concert->getBeginDatetime()->format('Y-m-d H:i:s') : null,
                'end_datetime' => $concert->getEndDatetime() ? $concert->getEndDatetime()->format('Y-m-d H:i:s') : null,
                'description' => $concert->getContent(),
                'image' => $this->getParameter('app.base_url') . '/public/images/ns_img_content/' . $concert->getImageName(),
            ];
        }

        return $this->json($data, Response::HTTP_OK);
    }

    #[Route('/concert/edit/{id}', name: 'app_concert_edit', methods: ['GET','POST'])]
    public function edit(ConcertRepository $repository, int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $concert = $repository->findOneBy(["id" => $id]);
        $form = $this->createForm(ConcertType::class, $concert);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
            $concertData = $form->getData();
            $entityManager->persist($concertData);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Le concert à été modifié avec succès!'
            );

            return $this->redirectToRoute('app_concert_list');
        }

        return $this->render('edition/edit.html.twig', [
            'form' => $form->createView(),
            'controller_title' => 'Modifier le concert'
        ]);
    }

    #[Route('/concert/delete/{id}', name: 'app_concert_delete', methods: ['GET','POST'])]
    public function delete(EntityManagerInterface $entityManager, Concert $concert) : Response
    {
        $entityManager->remove($concert);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Le concert à été supprimé avec succès!'
        );


        return $this->redirectToRoute('app_concert_list');
    }
    
    
}
