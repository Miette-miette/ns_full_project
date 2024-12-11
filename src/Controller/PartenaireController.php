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

        return $this->render('creation/create_data.html.twig',['form' => $form->createView(), 'controller_title' => 'Nouveau Partenaire']);
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

    #[Route('/api/partenaires', name: 'api_partenaires', methods: ['GET'])]
    public function getPartenairesAPI(PartenaireRepository $repository): Response
    {
        $partenaires = $repository->findAll();
        $data = [];

        foreach ($partenaires as $partenaire) {
            $data[] = [
                'id' => $partenaire->getId(),
                'title' => $partenaire->getTitre(),
                'Location' => $partenaire->getLieu(),
                'begin_datetime' => $partenaire->getBeginDatetime() ? $partenaire->getBeginDatetime()->format('Y-m-d H:i:s') : null,
                'end_datetime' => $partenaire->getEndDatetime() ? $partenaire->getEndDatetime()->format('Y-m-d H:i:s') : null,
                'description' => $partenaire->getContent(),
                'image' => $this->getParameter('app.base_url') . '/public/images/ns_img_content/' . $partenaire->getImageName(),
            ];
        }

        return $this->json($data, Response::HTTP_OK);
    }

    #[Route('/partenaire/edit/{id}', name: 'app_partenaire_edit', methods: ['GET','POST'])]
    public function edit(PartenaireRepository $repository, int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $partenaire = $repository->findOneBy(["id" => $id]);
        $form = $this->createForm(CreatePartenaireType::class, $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid())
        {
            $partenaireData = $form->getData();
            $entityManager->persist($partenaireData);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Le partenaire à été modifié avec succès!'
            );

            return $this->redirectToRoute('app_partenaire_list');
        }

        return $this->render('edition/edit.html.twig', [
            'form' => $form->createView(),
            'controller_title' => 'Modifier le partenaire'
        ]);
    }

    #[Route('/partenaire/delete/{id}', name: 'app_partenaire_delete', methods: ['GET','POST'])]
    public function delete(EntityManagerInterface $entityManager, Partenaire $partenaire) : Response
    {
        $entityManager->remove($partenaire);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Le partenaire à été supprimé avec succès!'
        );


        return $this->redirectToRoute('app_partenaire_list');
    }
    
}
