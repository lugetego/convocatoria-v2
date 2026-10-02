<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('admin/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    #[Route('/login_check', name: 'app_login_check')]
    public function loginCheck(): void
    {
        // Esta ruta nunca se ejecuta: la intercepta el listener de form_login del firewall.
        throw new \LogicException('This method can be blank - it will be intercepted by the firewall.');
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Esta ruta nunca se ejecuta: la intercepta el listener de logout del firewall.
        throw new \LogicException('This method can be blank - it will be intercepted by the firewall.');
    }
}
