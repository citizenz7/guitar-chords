<?php

namespace App\Controller;

use App\Repository\ChordRepository;
use App\Repository\HomeRepository;
use App\Repository\SettingRepository;
use App\Repository\TonaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        SettingRepository $settingRepository,
        TonaliteRepository $tonaliteRepository,
        ChordRepository $chordRepository,
        HomeRepository $homeRepository
    ): Response
    {
        $settings = $settingRepository->findOneBy([]);
        $tonalites = $tonaliteRepository->findAll();
        $chords = $chordRepository->findBy(['active' => true], []);
        $home = $homeRepository->findOneBy([]);

        return $this->render('home/index.html.twig', [
            'settings' => $settings,
            'tonalites' => $tonalites,
            'chords' => $chords,
            'home' => $home
        ]);
    }
}
