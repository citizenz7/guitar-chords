<?php

namespace App\Controller;

use App\Form\SearchChordType;
use App\Repository\ChordRepository;
use App\Repository\SearchRepository;
use App\Repository\SettingRepository;
use App\Repository\TonaliteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class SearchController extends AbstractController
{
    #[Route('/recherche', name: 'app_search', methods: ['GET', 'POST'])]
    public function index(
        SettingRepository $settingRepository,
        TonaliteRepository $tonaliteRepository,
        ChordRepository $chordRepository,
        SearchRepository $searchRepository,
        Request $request,
        PaginatorInterface $paginator
    ): Response {
        $settings = $settingRepository->findOneBy([]);
        $tonalites = $tonaliteRepository->findAll();
        $search = $searchRepository->findOneBy([]);

        // Création du formulaire de recherche
        $searchForm = $this->createForm(SearchChordType::class);
        $searchForm->handleRequest($request);

        $donnees = null; // On n'affiche rien tant que la recherche n'est pas effectuée

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $title = $searchForm->getData()->getTitle();
            $donnees = $chordRepository->search($title);
        }

        $chords = null;
        if ($donnees !== null) {
            $chords = $paginator->paginate(
                $donnees, // Paginer seulement si une recherche a été faite
                $request->query->getInt('page', 1),
                8
            );
        }

        return $this->render('search/index.html.twig', [
            'settings' => $settings,
            'tonalites' => $tonalites,
            'search' => $search,
            'chords' => $chords, // ✅ Peut être null au départ
            'searchForm' => $searchForm,
            'seoTitle' => $search->getSeoTitle(),
            'seoUrl' => $search->getSlug(),
            'seoDescription' => $search->getSeoDescription()
        ]);
    }
}
