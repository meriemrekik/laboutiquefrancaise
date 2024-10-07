<?php

namespace App\Controller;

use App\Form\PasswordUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }

    #[Route('/modifier-mot-de-passe', name: 'app_account_modify_pwd')]
    public function password(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(PasswordUserType::class, $user, [
            'passwordHasher' => $passwordHasher
        ]);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Votre mot de passe a été mis à jour avec succès.');
            $entityManager->flush();


        // Vérification de l'utilisateur
        if (!$user) {
            throw $this->createAccessDeniedException('Aucun utilisateur connecté.');
        }

      

    
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Votre mot de passe a été mis à jour avec succès.');
            $entityManager->flush();
            
            return $this->render('account/password.html.twig', [
                'modifyPwd' => $form->createView(),
            ]);

            $newPassword = $form->get('plainPassword')->getData();
            if ($newPassword) {
                $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);

                $user->setPassword($hashedPassword);
            }
            
            // Enregistrer les changements dans la base de données

          
           

            return $this->redirectToRoute('app_account'); // Rediriger vers la page de compte
        }
    
        return $this->render('account/password.html.twig', [
            'modifyPwd' => $form->createView(),
        ]);
    }
}
}