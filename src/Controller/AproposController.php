<?php

namespace App\Controller;

use App\Repository\AproposRepository;
use App\Repository\SettingRepository;
use App\Repository\TonaliteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AproposController extends AbstractController
{
    #[Route('/a-propos', name: 'app_apropos')]
    public function index(
        SettingRepository $settingRepository,
        TonaliteRepository $tonaliteRepository,
        AproposRepository $aproposRepository
    ): Response
    {
        $settings = $settingRepository->findOneBy([]);
        $tonalites = $tonaliteRepository->findAll();
        $apropos = $aproposRepository->findOneBy([]);

        return $this->render('apropos/index.html.twig', [
            'settings' => $settings,
            'tonalites' => $tonalites,
            'apropos' => $apropos,
            'seoTitle' => $apropos->getSeoTitle(),
            'seoUrl' => $apropos->getSlug(),
            'seoDescription' => $apropos->getSeoDescription()
        ]);
    }
}
