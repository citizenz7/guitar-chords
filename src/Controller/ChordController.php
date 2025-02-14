<?php

namespace App\Controller;

use App\Repository\ChordPageRepository;
use App\Repository\ChordRepository;
use App\Repository\SettingRepository;
use App\Repository\TonaliteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/accords')]
final class ChordController extends AbstractController
{
    #[Route(name: 'app_chord_index', methods: ['GET'])]
    public function index(
        SettingRepository $settingRepository,
        ChordRepository $chordRepository,
        TonaliteRepository $tonaliteRepository,
        ChordPageRepository $chordPageRepository,
        PaginatorInterface $paginator,
        Request $request,
        EntityManagerInterface $em
    ): Response {
        $settings = $settingRepository->findOneBy([]);
        $tonalites = $tonaliteRepository->findAll();
        $chordsPage = $chordPageRepository->findOneBy([]);

        $dql = "SELECT c FROM App\Entity\Chord c WHERE c.active = true ORDER BY c.title ASC";
        $query = $em->createQuery($dql);

        $chords = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $chordsPage->getChordsNum()
        );

        $totalChords = $chordRepository->findBy(['active' => true], []);

        return $this->render('chords/index.html.twig', [
            'settings' => $settings,
            'chords' => $chords,
            'totalChords' => $totalChords,
            'chordsPage' => $chordsPage,
            'tonalites' => $tonalites,
            'seoTitle' => $chordsPage->getSeoTitle(),
            'seoUrl' => $chordsPage->getSlug(),
            'seoDescription' => $chordsPage->getSeoDescription()
        ]);
    }

    // #[Route('/new', name: 'app_chord_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $chord = new Chord();
    //     $form = $this->createForm(ChordType::class, $chord);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($chord);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_chord_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('chords/new.html.twig', [
    //         'chord' => $chord,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{slug}', name: 'app_chord_show', methods: ['GET'])]
    public function show(
        // Chord $chord
        SettingRepository $settingRepository,
        ChordRepository $chordRepository,
        TonaliteRepository $tonaliteRepository,
        ChordPageRepository $chordPageRepository,
        string $slug
    ): Response {
        $settings = $settingRepository->findOneBy([]);
        $chord = $chordRepository->findOneBy(['slug' => $slug]);
        $tonalites = $tonaliteRepository->findAll();
        $chordsPage = $chordPageRepository->findOneBy([]);

        return $this->render('chords/show.html.twig', [
            'settings' => $settings,
            'chord' => $chord,
            'tonalites' => $tonalites,
            'chordsPage' => $chordsPage,
            'seoTitle' => $chordsPage->getSeoTitle(),
            'seoUrl' => $chordsPage->getSlug(),
            'seoDescription' => $chordsPage->getSeoDescription()
        ]);
    }

    // #[Route('/{id}/edit', name: 'app_chord_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Chord $chord, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(ChordType::class, $chord);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_chord_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('chords/edit.html.twig', [
    //         'chord' => $chord,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_chord_delete', methods: ['POST'])]
    // public function delete(Request $request, Chord $chord, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$chord->getId(), $request->getPayload()->getString('_token'))) {
    //         $entityManager->remove($chord);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_chord_index', [], Response::HTTP_SEE_OTHER);
    // }
}
