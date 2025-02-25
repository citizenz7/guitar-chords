<?php

namespace App\Controller;

use App\Repository\SettingRepository;
use App\Repository\TonaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(
        AuthenticationUtils $authenticationUtils,
        SettingRepository $settingRepository,
        TonaliteRepository $tonaliteRepository
    ): Response {
        $settings = $settingRepository->findOneBy([]);
        $tonalites = $tonaliteRepository->findAll();

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'settings' => $settings,
            'tonalites' => $tonalites,
            'seoTitle' => 'Se connecter',
            'seoUrl' => 'login',
            'seoDescription' => 'Se connecter'
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
