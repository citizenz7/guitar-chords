<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\SettingRepository;
use App\Repository\TonaliteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/articles')]
final class ArticleController extends AbstractController
{
    #[Route(name: 'app_article_index', methods: ['GET'])]
    public function index(
        SettingRepository $settingRepository,
        TonaliteRepository $tonaliteRepository,
        PaginatorInterface $paginator,
        EntityManagerInterface $em,
        Request $request
    ): Response {
        $settings = $settingRepository->findOneBy([]);
        $tonalites = $tonaliteRepository->findAll();

        $dql = "SELECT a FROM App\Entity\Article a WHERE a.isActive = true ORDER BY a.createdAt DESC";
        $query = $em->createQuery($dql);

        $articles = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            3
        );

        return $this->render('articles/index.html.twig', [
            'settings' => $settings,
            'tonalites' => $tonalites,
            'articles' => $articles,
            'seoTitle' => 'Tous les Articles',
            'seoUrl' => '/articles',
            'seoDescription' => 'Tous les articles du site'
        ]);
    }

    // #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $article = new Article();
    //     $form = $this->createForm(ArticleType::class, $article);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($article);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('articles/new.html.twig', [
    //         'article' => $article,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{slug}', name: 'app_article_show', methods: ['GET'])]
    public function show(
        SettingRepository $settingRepository,
        TonaliteRepository $tonaliteRepository,
        // Article $article
        ArticleRepository $articleRepository,
        string $slug
    ): Response {
        $settings = $settingRepository->findOneBy([]);
        $tonalites = $tonaliteRepository->findAll();

        $article = $articleRepository->findOneBy(['slug' => $slug]);

        return $this->render('articles/show.html.twig', [
            'settings' => $settings,
            'tonalites' => $tonalites,
            'article' => $article,
            'seoTitle' => $article->getSeoTitle(),
            'seoUrl' => $article->getSlug(),
            'seoDescription' => $article->getSeoDescription()
        ]);
    }

    // #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(ArticleType::class, $article);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('articles/edit.html.twig', [
    //         'article' => $article,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    // public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->getPayload()->getString('_token'))) {
    //         $entityManager->remove($article);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    // }
}
