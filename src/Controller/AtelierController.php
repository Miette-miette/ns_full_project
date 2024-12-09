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

        return $this->render('creation\create_data.html.twig',['form' => $form->createView(), 'controller_title' => 'Nouvel Atelier']);
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

    #[Route('/api/ateliers', name: 'api_ateliers', methods: ['GET'])]
    public function getAtelierAPI(AtelierRepository $repository): Response
    {
        $ateliers = $repository->findAll();
        $data = [];

        foreach ($ateliers as $atelier) {
            $data[] = [
                'id' => $atelier->getId(),
                'title' => $atelier->getTitre(),
                'Location' => $atelier->getLieu(),
                'begin_datetime' => $atelier->getBeginDatetime() ? $atelier->getBeginDatetime()->format('Y-m-d H:i:s') : null,
                'end_datetime' => $atelier->getEndDatetime() ? $atelier->getEndDatetime()->format('Y-m-d H:i:s') : null,
                'description' => $atelier->getContent(),
                'image' => $this->getParameter('app.base_url') . '/public/images/ns_img_content/' . $atelier->getImageName(),
            ];
        }

        return $this->json($data, Response::HTTP_OK);
    }

    #[Route('/atelier/edit/{id}', name: 'app_atelier_edit', methods: ['GET','POST'])]
    public function edit(AtelierRepository $repository, int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $atelier = $repository->findOneBy(["id" => $id]);
        $form = $this->createForm(CreateAtelierType::class, $atelier);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
            $atelierData = $form->getData();
            $entityManager->persist($atelierData);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'L\'atelier à été modifié avec succès!'
            );

            return $this->redirectToRoute('app_atelier_list');
        }

        return $this->render('edition/edit.html.twig', [
            'form' => $form->createView(),
            'controller_title' => 'Modifier l\'atelier'
        ]);
    }

    #[Route('/atelier/delete/{id}', name: 'app_atelier_delete', methods: ['GET','POST'])]
    public function delete(EntityManagerInterface $entityManager, Atelier $atelier) : Response
    {
        $entityManager->remove($atelier);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'L\'atelier à été supprimé avec succès!'
        );


        return $this->redirectToRoute('app_atelier_list');
    }

}
