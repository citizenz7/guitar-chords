<?php

namespace App\Controller;

use App\Repository\SettingRepository;
use App\Repository\TonalitePageRepository;
use App\Repository\TonaliteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tonalites')]
final class TonaliteController extends AbstractController
{
    #[Route(name: 'app_tonalite_index', methods: ['GET'])]
    public function index(
        SettingRepository $settingRepository,
        TonaliteRepository $tonaliteRepository,
        TonalitePageRepository $tonalitePageRepository
    ): Response {
        $settings = $settingRepository->findOneBy([]);
        $tonalites = $tonaliteRepository->findAll();
        $tonalitesPage = $tonalitePageRepository->findOneBy([]);

        return $this->render('tonalites/index.html.twig', [
            'settings' => $settings,
            'tonalites' => $tonaliteRepository->findAll(),
            'tonalitesPage' => $tonalitesPage,
            'seoTitle' => $tonalitesPage->getSeoTitle(),
            'seoUrl' => $tonalitesPage->getSlug(),
            'seoDescription' => $tonalitesPage->getSeoDescription()
        ]);
    }

    // #[Route('/new', name: 'app_tonalite_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $tonalite = new Tonalite();
    //     $form = $this->createForm(TonaliteType::class, $tonalite);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($tonalite);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_tonalite_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('tonalites/new.html.twig', [
    //         'tonalite' => $tonalite,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{slug}', name: 'app_tonalite_show', methods: ['GET'])]
    public function show(
        SettingRepository $settingRepository,
        // Tonalite $tonalite
        TonaliteRepository $tonaliteRepository,
        TonalitePageRepository $tonalitePageRepository,
        string $slug
    ): Response {
        $settings = $settingRepository->findOneBy([]);
        $tonalite = $tonaliteRepository->findOneBy(['slug' => $slug]);
        $tonalites = $tonaliteRepository->findAll();
        $tonalitesPage = $tonalitePageRepository->findOneBy([]);

        return $this->render('tonalites/show.html.twig', [
            'tonalite' => $tonalite,
            'tonalites' => $tonalites,
            'tonalitesPage' => $tonalitesPage,
            'settings' => $settings,
            'seoTitle' => $tonalitesPage->getSeoTitle(),
            'seoUrl' => $tonalitesPage->getSlug(),
            'seoDescription' => $tonalitesPage->getSeoDescription()
        ]);
    }

    // #[Route('/{id}/edit', name: 'app_tonalite_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Tonalite $tonalite, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(TonaliteType::class, $tonalite);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_tonalite_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('tonalites/edit.html.twig', [
    //         'tonalite' => $tonalite,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_tonalite_delete', methods: ['POST'])]
    // public function delete(Request $request, Tonalite $tonalite, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$tonalite->getId(), $request->getPayload()->getString('_token'))) {
    //         $entityManager->remove($tonalite);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_tonalite_index', [], Response::HTTP_SEE_OTHER);
    // }
}
