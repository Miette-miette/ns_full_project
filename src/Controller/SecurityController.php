<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'app_security_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils ): Response
    {
        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'controller_name' => 'SecurityController'
        ]);
    }

    #[Route('/deconnexion', name: 'app_security_logout')]
    public function logout(){
        //nothing to do
    }

    #[Route('/inscription', name: 'app_security_registration', methods: ['GET', 'POST'])]
    public function registration(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        
        if ($form->isSubmitted()&& $form->isValid())
        {
            dd($form->getData());
            $userData = $form->getData();
            $entityManager->persist($userData);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre compte a bien été crée!'
            );

            return $this->redirectToRoute('app_partenaire_list');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
