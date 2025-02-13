<?php

namespace App\Controller;

use App\Entity\Chord;
use App\Form\ChordType;
use App\Repository\ChordRepository;
use App\Repository\SettingRepository;
use App\Repository\TonaliteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/chords')]
final class ChordController extends AbstractController
{
    #[Route(name: 'app_chord_index', methods: ['GET'])]
    public function index(
        SettingRepository $settingRepository,
        ChordRepository $chordRepository,
        TonaliteRepository $tonaliteRepository
    ): Response {
        $settings = $settingRepository->findOneBy([]);
        $chords = $chordRepository->findAll();
        $tonalites = $tonaliteRepository->findAll();

        return $this->render('chords/index.html.twig', [
            'settings' => $settings,
            'chords' => $chords,
            'tonalites' => $tonalites
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
        string $slug
    ): Response {
        $settings = $settingRepository->findOneBy([]);
        $chord = $chordRepository->findOneBy(['slug' => $slug]);
        $tonalites = $tonaliteRepository->findAll();

        return $this->render('chords/show.html.twig', [
            'settings' => $settings,
            'chord' => $chord,
            'tonalites' => $tonalites
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
