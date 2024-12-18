<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\CreateLocationType;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LieuController extends AbstractController
{
    #[Route('/Location/create', name: 'app_Location_create', methods: ['GET','POST'])]
    public function createDataLocation(EntityManagerInterface $entityManager,Request $request)
    {
        $location = new Location();
        $form = $this->createForm(CreateLocationType::class, $location);

        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
            $locationData = $form->getData();
            $entityManager->persist($locationData);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Le lieu à été ajouté!'
            );

            return $this->redirectToRoute('app_location_list');
        }

        return $this->render('creation\create_data.html.twig',['form' => $form->createView(),'controller_title' => 'Nouveau lieu']);
    }

    #[Route('/location/list', name: 'app_location_list')]
    public function ShowAll(LocationRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        //pagination 2 par page
        $location = $paginator->paginate(
            $repository->findAll(), 
            $request->query->getInt('page', 1), 
            2 
        );

        return $this->render('location/list.html.twig', [
            'location' =>$location]);
    }

    #[Route('/location/edit/{id}', name: 'app_location_edit', methods: ['GET','POST'])]
    public function edit(LocationRepository $repository, int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $location = $repository->findOneBy(["id" => $id]);
        $form = $this->createForm(CreateLocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
            $locationData = $form->getData();
            $entityManager->persist($locationData);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Le lieu à été modifié avec succès!'
            );

            return $this->redirectToRoute('app_location_list');
        }

        return $this->render('edition/edit.html.twig', [
            'form' => $form->createView(),
            'controller_title' => 'Modifier un lieu'
        ]);
    }

    #[Route('/location/delete/{id}', name: 'app_location_delete', methods: ['GET','POST'])]
    public function delete(EntityManagerInterface $entityManager, Location $location) : Response
    {
        $entityManager->remove($location);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Le lieu à été supprimé avec succès!'
        );


        return $this->redirectToRoute('app_location_list');
    }
}
