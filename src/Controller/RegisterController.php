<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\RegisterUserType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request,EntityManagerInterface $entityMenager): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityMenager->persist($user);
            $entityMenager->flush();
            // Ici, vous pouvez gérer l'envoi des données, par exemple, enregistrer l'utilisateur dans la base de données

            // Redirigez vers une autre page ou affichez un message de succès
            return $this->redirectToRoute('app_success'); // Changez 'app_success' selon vos besoins
        }

        return $this->render('register/index.html.twig', [
            'registerForm' => $form->createView()
        ]);
    }
}
