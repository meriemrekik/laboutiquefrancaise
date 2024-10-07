<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/connexion', name: 'app_login')]
    public function index(AuthenticationUtils $AuthenticationUtils): Response
    {
        $error = $AuthenticationUtils->getLastAuthenticationError();
        $lastUserName = $AuthenticationUtils->getLastUsername();
        return $this->render('login/index.html.twig', [
          'error' => $error,
           'last_username' => $lastUserName,

        ]);
    }
    
    #[Route('/deconnexion', name: 'app_logout',methods:('GET'))]
    public function logout (): never
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');

    }
}
