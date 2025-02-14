<?php

namespace App\Controller;

use App\Repository\CguRepository;
use App\Repository\SettingRepository;
use App\Repository\TonaliteRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CguController extends AbstractController
{
    #[Route('/cgu', name: 'app_cgu')]
    public function index(
        SettingRepository $settingRepository,
        TonaliteRepository $tonaliteRepository,
        CguRepository $cguRepository
    ): Response
    {
        $settings = $settingRepository->findOneBy([]);
        $tonalites = $tonaliteRepository->findAll();
        $cgu = $cguRepository->findOneBy([]);

        return $this->render('cgu/index.html.twig', [
            'settings' => $settings,
            'tonalites' => $tonalites,
            'cgu' => $cgu,
            'seoTitle' => $cgu->getSeoTitle(),
            'seoUrl' => $cgu->getSlug(),
            'seoDescription' => $cgu->getSeoDescription()
        ]);
    }
}
